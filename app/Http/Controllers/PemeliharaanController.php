<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use App\Models\PemeliharaanHistory;
use App\Models\Barang;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PemeliharaanController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth'),
            new Middleware('can:manage pemeliharaan', except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $vendor = $request->vendor;

        $pemeliharaan = Pemeliharaan::select([
            'id',
            'barang_id',
            'user_id',
            'kode_pemeliharaan',
            'jenis_kerusakan',
            'deskripsi_kerusakan',
            'jumlah_dipelihara',
            'nama_vendor',
            'pic_vendor',
            'estimasi_biaya',
            'biaya_aktual',
            'tanggal_kirim',
            'estimasi_selesai',
            'tanggal_selesai_aktual',
            'status',
            'jumlah_berhasil_diperbaiki',
            'jumlah_tidak_bisa_diperbaiki'
        ])
            ->withOptimalRelations()
            ->search($search)
            ->when($status, function ($query, $status) {
                $query->byStatus($status);
            })
            ->when($vendor, function ($query, $vendor) {
                $query->byVendor($vendor);
            })
            ->latest('tanggal_kirim')
            ->paginate(12)
            ->withQueryString();

        // Statistics untuk dashboard
        $statistics = CacheService::remember('pemeliharaan_statistics', function () {
            return [
                'total_pemeliharaan' => Pemeliharaan::count(),
                'dalam_perbaikan' => Pemeliharaan::byStatus('dalam_perbaikan')->count(),
                'menunggu_approval' => Pemeliharaan::byStatus('menunggu_approval')->count(),
                'selesai_bulan_ini' => Pemeliharaan::byStatus('selesai')
                    ->whereMonth('tanggal_selesai_aktual', now()->month)
                    ->count(),
                'total_biaya_bulan_ini' => Pemeliharaan::byStatus('selesai')
                    ->whereMonth('tanggal_selesai_aktual', now()->month)
                    ->sum('biaya_aktual'),
                'rata_rata_durasi' => Pemeliharaan::byStatus('selesai')
                    ->whereNotNull('tanggal_selesai_aktual')
                    ->get()
                    ->avg(function ($item) {
                        return $item->durasi_pemeliharaan;
                    }) ?? 0,
            ];
        });

        return view('pemeliharaan.index', compact('pemeliharaan', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil barang yang ada kondisi rusak
        $barangs = CacheService::remember('barangs_for_pemeliharaan', function () {
            return Barang::select([
                'id',
                'nama_barang',
                'kode_barang',
                'jumlah_rusak_ringan',
                'jumlah_rusak_berat'
            ])
                ->where(function ($query) {
                    $query->where('jumlah_rusak_ringan', '>', 0)
                        ->orWhere('jumlah_rusak_berat', '>', 0);
                })
                ->with(['kategori:id,nama_kategori', 'lokasi:id,nama_lokasi'])
                ->orderBy('nama_barang')
                ->get();
        });

        return view('pemeliharaan.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jenis_kerusakan' => 'required|in:rusak_ringan,rusak_berat',
            'deskripsi_kerusakan' => 'required|string|max:1000',
            'jumlah_dipelihara' => 'required|integer|min:1',
            'nama_vendor' => 'required|string|max:255',
            'kontak_vendor' => 'nullable|string|max:255',
            'alamat_vendor' => 'nullable|string|max:500',
            'pic_vendor' => 'nullable|string|max:255',
            'estimasi_biaya' => 'nullable|numeric|min:0',
            'tanggal_kirim' => 'required|date',
            'estimasi_selesai' => 'nullable|date|after_or_equal:tanggal_kirim',
            'catatan_internal' => 'nullable|string|max:1000',
            'foto_sebelum.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            return DB::transaction(function () use ($validated, $request) {
                $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

                // Validasi stok yang tersedia
                $stokTersedia = $validated['jenis_kerusakan'] === 'rusak_ringan'
                    ? $barang->jumlah_rusak_ringan
                    : $barang->jumlah_rusak_berat;

                if ($validated['jumlah_dipelihara'] > $stokTersedia) {
                    throw new \Exception("Stok {$validated['jenis_kerusakan']} tersedia hanya {$stokTersedia} unit.");
                }

                // Upload foto sebelum
                if ($request->hasFile('foto_sebelum')) {
                    $fotoSebelum = [];
                    foreach ($request->file('foto_sebelum') as $foto) {
                        $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                        $path = $foto->storeAs('sebelum', $filename, 'foto-pemeliharaan');
                        $fotoSebelum[] = $path;
                    }
                    $validated['foto_sebelum'] = $fotoSebelum;
                }

                // Set user_id
                $validated['user_id'] = Auth::id();

                // Kurangi stok rusak
                if ($validated['jenis_kerusakan'] === 'rusak_ringan') {
                    $barang->decrement('jumlah_rusak_ringan', $validated['jumlah_dipelihara']);
                } else {
                    $barang->decrement('jumlah_rusak_berat', $validated['jumlah_dipelihara']);
                }

                // Buat record pemeliharaan
                $pemeliharaan = Pemeliharaan::create($validated);

                // Buat history awal
                PemeliharaanHistory::create([
                    'pemeliharaan_id' => $pemeliharaan->id,
                    'status_dari' => '',
                    'status_ke' => 'dikirim',
                    'keterangan' => 'Pemeliharaan dibuat dan barang dikirim ke vendor',
                    'user_id' => Auth::id(),
                ]);

                // Clear cache
                CacheService::clearCache(['barangs_for_pemeliharaan', 'pemeliharaan_statistics']);

                return redirect()->route('pemeliharaan.index')
                    ->with('success', 'Pemeliharaan berhasil dibuat dengan kode: ' . $pemeliharaan->kode_pemeliharaan);
            });
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->load([
            'barang.kategori:id,nama_kategori',
            'barang.lokasi:id,nama_lokasi',
            'user:id,name',
            'history.user:id,name'
        ]);

        return view('pemeliharaan.show', compact('pemeliharaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemeliharaan $pemeliharaan)
    {
        // Hanya bisa edit jika status masih aktif
        if (in_array($pemeliharaan->status, ['selesai', 'dibatalkan', 'tidak_bisa_diperbaiki'])) {
            return redirect()->route('pemeliharaan.index')
                ->with('error', 'Pemeliharaan dengan status "' . $pemeliharaan->status . '" tidak bisa diedit.');
        }

        return view('pemeliharaan.edit', compact('pemeliharaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $validated = $request->validate([
            'status' => 'required|in:dalam_perbaikan,menunggu_approval,selesai,dibatalkan,tidak_bisa_diperbaiki',
            'biaya_aktual' => 'nullable|numeric|min:0',
            'rincian_biaya' => 'nullable|string|max:2000',
            'tanggal_selesai_aktual' => 'required_if:status,selesai|nullable|date',
            'jumlah_berhasil_diperbaiki' => 'required_if:status,selesai|nullable|integer|min:0|max:' . $pemeliharaan->jumlah_dipelihara,
            'jumlah_tidak_bisa_diperbaiki' => 'nullable|integer|min:0',
            'catatan_vendor' => 'nullable|string|max:1000',
            'catatan_internal' => 'nullable|string|max:1000',
            'dokumen_invoice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_sesudah.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            return DB::transaction(function () use ($validated, $request, $pemeliharaan) {
                $statusLama = $pemeliharaan->status;

                // Upload dokumen invoice
                if ($request->hasFile('dokumen_invoice')) {
                    if ($pemeliharaan->dokumen_invoice) {
                        Storage::disk('foto-pemeliharaan')->delete($pemeliharaan->dokumen_invoice);
                    }
                    $filename = time() . '_invoice.' . $request->file('dokumen_invoice')->getClientOriginalExtension();
                    $validated['dokumen_invoice'] = $request->file('dokumen_invoice')->storeAs('invoice', $filename, 'foto-pemeliharaan');
                }

                // Upload foto sesudah
                if ($request->hasFile('foto_sesudah')) {
                    $fotoSesudah = $pemeliharaan->foto_sesudah ?? [];
                    foreach ($request->file('foto_sesudah') as $foto) {
                        $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                        $path = $foto->storeAs('sesudah', $filename, 'foto-pemeliharaan');
                        $fotoSesudah[] = $path;
                    }
                    $validated['foto_sesudah'] = $fotoSesudah;
                }

                // Set jumlah tidak bisa diperbaiki otomatis
                if ($validated['status'] === 'selesai' && isset($validated['jumlah_berhasil_diperbaiki'])) {
                    $validated['jumlah_tidak_bisa_diperbaiki'] = $pemeliharaan->jumlah_dipelihara - $validated['jumlah_berhasil_diperbaiki'];
                }

                // Update pemeliharaan
                $pemeliharaan->update($validated);

                // Jika selesai, kembalikan stok yang berhasil diperbaiki ke kondisi baik
                if ($validated['status'] === 'selesai' && $statusLama !== 'selesai') {
                    $jumlahBerhasil = $validated['jumlah_berhasil_diperbaiki'] ?? 0;
                    if ($jumlahBerhasil > 0) {
                        $pemeliharaan->barang->increment('jumlah_baik', $jumlahBerhasil);
                    }
                }

                // Buat history perubahan status
                if ($statusLama !== $validated['status']) {
                    PemeliharaanHistory::create([
                        'pemeliharaan_id' => $pemeliharaan->id,
                        'status_dari' => $statusLama,
                        'status_ke' => $validated['status'],
                        'keterangan' => $validated['catatan_internal'] ?? 'Status diperbarui',
                        'biaya_perubahan' => $validated['biaya_aktual'] ?? null,
                        'user_id' => Auth::id(),
                    ]);
                }

                // Clear cache
                CacheService::clearCache(['pemeliharaan_statistics']);

                return redirect()->route('pemeliharaan.index')
                    ->with('success', 'Status pemeliharaan berhasil diperbarui.');
            });
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemeliharaan $pemeliharaan)
    {
        // Hanya bisa hapus jika status draft atau dibatalkan
        if (!in_array($pemeliharaan->status, ['dikirim', 'dibatalkan'])) {
            return redirect()->route('pemeliharaan.index')
                ->with('error', 'Pemeliharaan dengan status "' . $pemeliharaan->status . '" tidak bisa dihapus.');
        }

        try {
            return DB::transaction(function () use ($pemeliharaan) {
                // Kembalikan stok jika belum selesai
                if ($pemeliharaan->status === 'dikirim') {
                    if ($pemeliharaan->jenis_kerusakan === 'rusak_ringan') {
                        $pemeliharaan->barang->increment('jumlah_rusak_ringan', $pemeliharaan->jumlah_dipelihara);
                    } else {
                        $pemeliharaan->barang->increment('jumlah_rusak_berat', $pemeliharaan->jumlah_dipelihara);
                    }
                }

                // Hapus foto
                if ($pemeliharaan->foto_sebelum) {
                    foreach ($pemeliharaan->foto_sebelum as $foto) {
                        Storage::disk('foto-pemeliharaan')->delete($foto);
                    }
                }
                if ($pemeliharaan->foto_sesudah) {
                    foreach ($pemeliharaan->foto_sesudah as $foto) {
                        Storage::disk('foto-pemeliharaan')->delete($foto);
                    }
                }
                if ($pemeliharaan->dokumen_invoice) {
                    Storage::disk('foto-pemeliharaan')->delete($pemeliharaan->dokumen_invoice);
                }

                // Hapus record
                $pemeliharaan->delete();

                // Clear cache
                CacheService::clearCache(['barangs_for_pemeliharaan', 'pemeliharaan_statistics']);

                return redirect()->route('pemeliharaan.index')
                    ->with('success', 'Pemeliharaan berhasil dihapus.');
            });
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
}
