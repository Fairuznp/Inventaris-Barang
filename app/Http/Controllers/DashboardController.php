<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache data yang jarang berubah selama 60 menit
        $statistics = Cache::remember('dashboard_statistics', 3600, function () {
            return [
                'jumlahBarang' => Barang::count(),
                'jumlahKategori' => Kategori::count(),
                'jumlahLokasi' => Lokasi::count(),
                'jumlahUser' => User::count(),
                'kondisiBaik' => Barang::sum('jumlah_baik'),
                'kondisiRusakRingan' => Barang::sum('jumlah_rusak_ringan'),
                'kondisiRusakBerat' => Barang::sum('jumlah_rusak_berat'),
                'totalPeminjaman' => Peminjaman::count(),
                'peminjamanAktif' => Peminjaman::where('status', 'dipinjam')->count(),
                'totalDipinjam' => Peminjaman::where('status', 'dipinjam')->sum('jumlah'),
            ];
        });

        // Data yang perlu fresh (barang terbaru)
        $barangTerbaru = Barang::select([
                'id', 'nama_barang', 'kategori_id', 'lokasi_id', 'tanggal_pengadaan', 'created_at'
            ])
            ->with([
                'kategori:id,nama_kategori', 
                'lokasi:id,nama_lokasi'
            ])
            ->latest()->take(5)->get();

        return view('dashboard', array_merge($statistics, compact('barangTerbaru')));
    }
}
