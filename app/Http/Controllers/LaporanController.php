<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Peminjaman;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display laporan index page
     */
    public function index()
    {
        return view('laporan.index');
    }

    /**
     * Laporan Kategori - Menampilkan barang per kategori
     */
    public function kategori(Request $request)
    {
        $search = $request->get('search');

        $kategoris = Kategori::withCount('barangs')
            ->when($search, function ($query, $search) {
                return $query->where('nama_kategori', 'like', '%' . $search . '%');
            })
            ->with(['barangs' => function ($query) {
                $query->select('id', 'nama_barang', 'kode_barang', 'kategori_id', 'jumlah_total', 'jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 'satuan')
                    ->orderBy('nama_barang');
            }])
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('laporan.kategori', compact('kategoris', 'search'));
    }

    /**
     * Laporan Lokasi - Menampilkan barang per lokasi
     */
    public function lokasi(Request $request)
    {
        $search = $request->get('search');

        $lokasis = Lokasi::withCount('barangs')
            ->when($search, function ($query, $search) {
                return $query->where('nama_lokasi', 'like', '%' . $search . '%');
            })
            ->with(['barangs' => function ($query) {
                $query->select('id', 'nama_barang', 'kode_barang', 'lokasi_id', 'jumlah_total', 'jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 'satuan')
                    ->orderBy('nama_barang');
            }])
            ->orderBy('nama_lokasi')
            ->paginate(10);

        return view('laporan.lokasi', compact('lokasis', 'search'));
    }

    /**
     * Laporan Peminjaman
     */
    public function peminjaman(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');
        $status = $request->get('status');
        $search = $request->get('search');

        // Set default tanggal jika tidak ada
        if (!$tanggal_mulai) {
            $tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!$tanggal_selesai) {
            $tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $peminjamans = Peminjaman::with(['barang:id,nama_barang,kode_barang', 'user:id,name'])
            ->when($tanggal_mulai, function ($query, $tanggal_mulai) {
                return $query->where('tanggal_pinjam', '>=', $tanggal_mulai);
            })
            ->when($tanggal_selesai, function ($query, $tanggal_selesai) {
                return $query->where('tanggal_pinjam', '<=', $tanggal_selesai);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_peminjam', 'like', '%' . $search . '%')
                        ->orWhere('instansi_peminjam', 'like', '%' . $search . '%')
                        ->orWhereHas('barang', function ($barangQuery) use ($search) {
                            $barangQuery->where('nama_barang', 'like', '%' . $search . '%')
                                ->orWhere('kode_barang', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(15);

        // Summary data
        $summary = [
            'total_peminjaman' => Peminjaman::whereBetween('tanggal_pinjam', [$tanggal_mulai, $tanggal_selesai])->count(),
            'sedang_dipinjam' => Peminjaman::whereBetween('tanggal_pinjam', [$tanggal_mulai, $tanggal_selesai])->where('status', 'dipinjam')->count(),
            'sudah_dikembalikan' => Peminjaman::whereBetween('tanggal_pinjam', [$tanggal_mulai, $tanggal_selesai])->where('status', 'dikembalikan')->count(),
            'terlambat' => Peminjaman::whereBetween('tanggal_pinjam', [$tanggal_mulai, $tanggal_selesai])->where('status', 'terlambat')->count(),
        ];

        return view('laporan.peminjaman', compact('peminjamans', 'summary', 'tanggal_mulai', 'tanggal_selesai', 'status', 'search'));
    }

    /**
     * Laporan Pemeliharaan
     */
    public function pemeliharaan(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');
        $status = $request->get('status');
        $search = $request->get('search');

        // Set default tanggal jika tidak ada
        if (!$tanggal_mulai) {
            $tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!$tanggal_selesai) {
            $tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $pemeliharaans = Pemeliharaan::with(['barang:id,nama_barang,kode_barang', 'user:id,name'])
            ->when($tanggal_mulai, function ($query, $tanggal_mulai) {
                return $query->where('tanggal_kirim', '>=', $tanggal_mulai);
            })
            ->when($tanggal_selesai, function ($query, $tanggal_selesai) {
                return $query->where('tanggal_kirim', '<=', $tanggal_selesai);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('kode_pemeliharaan', 'like', '%' . $search . '%')
                        ->orWhere('nama_vendor', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi_kerusakan', 'like', '%' . $search . '%')
                        ->orWhereHas('barang', function ($barangQuery) use ($search) {
                            $barangQuery->where('nama_barang', 'like', '%' . $search . '%')
                                ->orWhere('kode_barang', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderBy('tanggal_kirim', 'desc')
            ->paginate(15);

        // Summary data
        $summary = [
            'total_pemeliharaan' => Pemeliharaan::whereBetween('tanggal_kirim', [$tanggal_mulai, $tanggal_selesai])->count(),
            'dalam_perbaikan' => Pemeliharaan::whereBetween('tanggal_kirim', [$tanggal_mulai, $tanggal_selesai])->where('status', 'dalam_perbaikan')->count(),
            'selesai' => Pemeliharaan::whereBetween('tanggal_kirim', [$tanggal_mulai, $tanggal_selesai])->where('status', 'selesai')->count(),
            'total_biaya' => Pemeliharaan::whereBetween('tanggal_kirim', [$tanggal_mulai, $tanggal_selesai])->where('status', 'selesai')->sum('biaya_aktual'),
        ];

        return view('laporan.pemeliharaan', compact('pemeliharaans', 'summary', 'tanggal_mulai', 'tanggal_selesai', 'status', 'search'));
    }

    /**
     * Export Laporan Kategori ke PDF
     */
    public function exportKategoriPdf()
    {
        $kategoris = Kategori::with(['barangs' => function ($query) {
            $query->select('id', 'nama_barang', 'kode_barang', 'kategori_id', 'jumlah_total', 'jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 'satuan')
                ->orderBy('nama_barang');
        }])->orderBy('nama_kategori')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.export.kategori-pdf', compact('kategoris'));

        return $pdf->download('laporan-kategori-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Laporan Lokasi ke PDF
     */
    public function exportLokasiPdf()
    {
        $lokasis = Lokasi::with(['barangs' => function ($query) {
            $query->select('id', 'nama_barang', 'kode_barang', 'lokasi_id', 'jumlah_total', 'jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 'satuan')
                ->orderBy('nama_barang');
        }])->orderBy('nama_lokasi')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.export.lokasi-pdf', compact('lokasis'));

        return $pdf->download('laporan-lokasi-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Laporan Peminjaman ke PDF
     */
    public function exportPeminjamanPdf(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');
        $status = $request->get('status');

        // Set default tanggal jika tidak ada
        if (!$tanggal_mulai) {
            $tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!$tanggal_selesai) {
            $tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $peminjamans = Peminjaman::with(['barang:id,nama_barang,kode_barang', 'user:id,name'])
            ->when($tanggal_mulai, function ($query, $tanggal_mulai) {
                return $query->where('tanggal_pinjam', '>=', $tanggal_mulai);
            })
            ->when($tanggal_selesai, function ($query, $tanggal_selesai) {
                return $query->where('tanggal_pinjam', '<=', $tanggal_selesai);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $summary = [
            'total_peminjaman' => $peminjamans->count(),
            'sedang_dipinjam' => $peminjamans->where('status', 'dipinjam')->count(),
            'sudah_dikembalikan' => $peminjamans->where('status', 'dikembalikan')->count(),
            'terlambat' => $peminjamans->where('status', 'terlambat')->count(),
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.export.peminjaman-pdf', compact('peminjamans', 'summary', 'tanggal_mulai', 'tanggal_selesai'));

        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export Laporan Pemeliharaan ke PDF
     */
    public function exportPemeliharaanPdf(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');
        $status = $request->get('status');

        // Set default tanggal jika tidak ada
        if (!$tanggal_mulai) {
            $tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!$tanggal_selesai) {
            $tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $pemeliharaans = Pemeliharaan::with(['barang:id,nama_barang,kode_barang', 'user:id,name'])
            ->when($tanggal_mulai, function ($query, $tanggal_mulai) {
                return $query->where('tanggal_kirim', '>=', $tanggal_mulai);
            })
            ->when($tanggal_selesai, function ($query, $tanggal_selesai) {
                return $query->where('tanggal_kirim', '<=', $tanggal_selesai);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('tanggal_kirim', 'desc')
            ->get();

        $summary = [
            'total_pemeliharaan' => $pemeliharaans->count(),
            'dalam_perbaikan' => $pemeliharaans->where('status', 'dalam_perbaikan')->count(),
            'selesai' => $pemeliharaans->where('status', 'selesai')->count(),
            'total_biaya' => $pemeliharaans->where('status', 'selesai')->sum('biaya_aktual'),
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.export.pemeliharaan-pdf', compact('pemeliharaans', 'summary', 'tanggal_mulai', 'tanggal_selesai'));

        return $pdf->download('laporan-pemeliharaan-' . date('Y-m-d') . '.pdf');
    }
}
