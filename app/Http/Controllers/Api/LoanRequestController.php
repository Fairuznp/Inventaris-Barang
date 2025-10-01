<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanRequestController extends Controller
{
    public function index(Request $request)
    {
        $userIdentifier = $request->input('user_identifier');
        
        if (!$userIdentifier) {
            return response()->json([
                'success' => false,
                'message' => 'User identifier is required'
            ], 400);
        }
        
        $requests = LoanRequest::with(['barang.kategori', 'barang.lokasi'])
            ->where('user_identifier', $userIdentifier)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $requests
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'required|string|max:255',
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'kontak_peminjam' => 'required|string|max:255',
            'instansi_peminjam' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if item is available for borrowing
        $barang = Barang::find($request->barang_id);
        
        if (!$barang->dapat_dipinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Barang ini tidak dapat dipinjam'
            ], 400);
        }

        if ($barang->stok_baik_tersedia < $request->jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok_baik_tersedia
            ], 400);
        }

        $loanRequest = LoanRequest::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Permintaan peminjaman berhasil diajukan',
            'data' => $loanRequest->load(['barang.kategori', 'barang.lokasi'])
        ], 201);
    }

    public function show($id, Request $request)
    {
        $userIdentifier = $request->input('user_identifier');
        
        $loanRequest = LoanRequest::with(['barang.kategori', 'barang.lokasi', 'approver'])
            ->where('id', $id)
            ->where('user_identifier', $userIdentifier)
            ->first();

        if (!$loanRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $loanRequest
        ]);
    }

    public function cancel($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'required|string|max:255',
            'reason' => 'required|string|min:10|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $loanRequest = LoanRequest::where('id', $id)
            ->where('user_identifier', $request->user_identifier)
            ->first();

        if (!$loanRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan'
            ], 404);
        }

        // Only allow cancel if status is pending
        if ($loanRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya permintaan dengan status pending yang dapat dibatalkan. Status saat ini: ' . $loanRequest->status
            ], 400);
        }

        // Update status to cancelled with required reason
        $updateData = [
            'status' => 'cancelled',
            'admin_notes' => "Dibatalkan oleh user: " . $request->reason
        ];

        $loanRequest->update($updateData);

        // Trigger event for real-time notification to admin
        event(new \App\Events\LoanRequestCancelled($loanRequest));

        return response()->json([
            'success' => true,
            'message' => 'Permintaan peminjaman berhasil dibatalkan',
            'data' => $loanRequest->fresh()->load(['barang.kategori', 'barang.lokasi'])
        ]);
    }
}
