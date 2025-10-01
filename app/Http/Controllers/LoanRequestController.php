<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LoanRequest::with(['barang.kategori', 'barang.lokasi'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(15);
        $pendingCount = LoanRequest::pending()->count();

        return view('loan-requests.index', compact('requests', 'pendingCount'));
    }

    public function show(LoanRequest $loanRequest)
    {
        $loanRequest->load(['barang.kategori', 'barang.lokasi', 'approver']);
        
        return view('loan-requests.show', compact('loanRequest'));
    }

    public function approve(LoanRequest $loanRequest, Request $request)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        if (!$loanRequest->canBeApproved()) {
            return back()->with('error', 'Permintaan tidak dapat disetujui. Periksa ketersediaan barang.');
        }

        $loanRequest->approve(Auth::id(), $request->admin_notes);

        // Create peminjaman record
        $peminjaman = Peminjaman::create([
            'request_id' => $loanRequest->id,
            'barang_id' => $loanRequest->barang_id,
            'nama_peminjam' => $loanRequest->nama_peminjam,
            'kontak_peminjam' => $loanRequest->kontak_peminjam,
            'instansi_peminjam' => $loanRequest->instansi_peminjam,
            'jumlah' => $loanRequest->jumlah,
            'tanggal_pinjam' => $loanRequest->tanggal_pinjam,
            'tanggal_kembali' => $loanRequest->tanggal_kembali,
            'keterangan' => $loanRequest->keterangan,
            'status' => 'dipinjam'
        ]);

        // Update stok barang
        $loanRequest->barang->decrement('jumlah_baik', $loanRequest->jumlah);

        return back()->with('success', 'Permintaan peminjaman telah disetujui dan peminjaman berhasil dibuat.');
    }

    public function reject(LoanRequest $loanRequest, Request $request)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $loanRequest->reject(Auth::id(), $request->admin_notes);

        return back()->with('success', 'Permintaan peminjaman telah ditolak.');
    }

    public function getPendingCount()
    {
        $count = LoanRequest::pending()->count();
        
        return response()->json(['count' => $count]);
    }
}
