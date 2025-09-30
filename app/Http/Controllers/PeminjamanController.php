<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;
use Carbon\Carbon;

class PeminjamanController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth'),
            new Middleware('can:manage peminjaman', except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        // Query utama dengan optimasi
        $peminjaman = Peminjaman::select([
            'id',
            'barang_id',
            'user_id',
            'nama_peminjam',
            'kontak_peminjam',
            'instansi_peminjam',
            'jumlah',
            'tanggal_pinjam',
            'tanggal_kembali',
            'tanggal_kembali_aktual',
            'status',
            'keterangan'
        ])
            ->withOptimalRelations()
            ->search($search)
            ->when($status, function ($query, $status) {
                $query->byStatus($status);
            })
            ->latest('tanggal_pinjam')
            ->paginate(12)
            ->withQueryString();

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cache dan optimasi query untuk dropdown barang
        $barangs = CacheService::remember('barangs_available_for_loan', function () {
            return Barang::select([
                'id',
                'nama_barang',
                'kode_barang',
                'jumlah_baik',
                'satuan',
                'dapat_dipinjam'
            ])
                ->with(['peminjamanAktif:barang_id,jumlah'])
                ->availableForLoan() // Hanya barang yang dapat dipinjam dan stok > 0
                ->orderBy('nama_barang')
                ->get()
                ->map(function ($barang) {
                    $barang->stok_tersedia = $barang->stok_baik_tersedia;
                    return $barang;
                })
                ->where('stok_tersedia', '>', 0)
                ->values(); // Reset array keys setelah filter
        });

        return view('peminjaman.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'kontak_peminjam' => 'nullable|string|max:255',
            'instansi_peminjam' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

                // Validasi apakah barang dapat dipinjam
                if (!$barang->dapat_dipinjam) {
                    throw new \Exception("Barang ini tidak dapat dipinjam.");
                }

                // Validasi stok baik yang tersedia setelah lock
                if ($validated['jumlah'] > $barang->stok_baik_tersedia) {
                    throw new \Exception("Stok baik tersedia hanya {$barang->stok_baik_tersedia} unit.");
                }

                // Set user_id ke auth user untuk tracking (opsional)
                if (Auth::check()) {
                    $validated['user_id'] = Auth::id();
                }

                // Kurangi stok baik
                $barang->decrement('jumlah_baik', $validated['jumlah']);

                // Simpan peminjaman
                $peminjaman = Peminjaman::create($validated);

                return redirect()->route('peminjaman.index')
                    ->with('success', 'Peminjaman berhasil ditambahkan.');
            });
        } catch (\Exception $e) {
            return back()->withErrors([
                'jumlah' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['barang', 'user']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Hanya peminjaman dengan status "dipinjam" yang bisa dikembalikan.');
        }

        $peminjaman->load(['barang']);

        return view('peminjaman.edit', compact('peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'status' => 'required|in:dikembalikan,hilang,terlambat',
            'jumlah_kembali' => 'required_unless:status,hilang|integer|min:0|max:' . $peminjaman->jumlah,
            'tanggal_kembali_aktual' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $barang = $peminjaman->barang;
        $jumlahKembali = $validated['status'] === 'hilang' ? 0 : ($validated['jumlah_kembali'] ?? 0);

        // Jika dikembalikan atau terlambat, tambahkan kembali ke stok baik
        if (in_array($validated['status'], ['dikembalikan', 'terlambat']) && $jumlahKembali > 0) {
            $barang->increment('jumlah_baik', $jumlahKembali);
        }

        // Jika pengembalian sebagian, buat record baru untuk sisa
        if ($jumlahKembali < $peminjaman->jumlah && $jumlahKembali > 0) {
            // Buat record baru untuk yang dikembalikan
            Peminjaman::create([
                'barang_id' => $peminjaman->barang_id,
                'user_id' => $peminjaman->user_id,
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'kontak_peminjam' => $peminjaman->kontak_peminjam,
                'instansi_peminjam' => $peminjaman->instansi_peminjam,
                'jumlah' => $jumlahKembali,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $peminjaman->tanggal_kembali,
                'tanggal_kembali_aktual' => $validated['tanggal_kembali_aktual'],
                'status' => $validated['status'],
                'keterangan' => $validated['keterangan'],
            ]);

            // Update record asli untuk sisa yang belum dikembalikan
            $peminjaman->update([
                'jumlah' => $peminjaman->jumlah - $jumlahKembali,
                'keterangan' => 'Pengembalian sebagian - sisa ' . ($peminjaman->jumlah - $jumlahKembali) . ' unit',
            ]);
        } else {
            // Update record asli jika dikembalikan semua atau hilang
            $peminjaman->update([
                'status' => $validated['status'],
                'tanggal_kembali_aktual' => $validated['tanggal_kembali_aktual'],
                'keterangan' => $validated['keterangan'],
            ]);
        }

        $statusMsg = match ($validated['status']) {
            'dikembalikan' => 'dikembalikan',
            'terlambat' => 'dikembalikan (terlambat)',
            'hilang' => 'dilaporkan hilang',
        };

        return redirect()->route('peminjaman.index')
            ->with('success', "Barang berhasil {$statusMsg}.");
    }

    /**
     * Method untuk kembalikan barang
     */
    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        return $this->update($request, $peminjaman);
    }
}
