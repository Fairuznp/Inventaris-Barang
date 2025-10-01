<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'lokasi'])
            ->where('dapat_dipinjam', true)
            ->where('jumlah_baik', '>', 0);

        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        // Filter by location
        if ($request->has('lokasi_id')) {
            $query->where('lokasi_id', $request->input('lokasi_id'));
        }

        $barangs = $query->paginate(12);

        // Add available stock calculation
        $barangs->getCollection()->transform(function ($barang) {
            $barang->available_stock = $barang->stok_baik_tersedia;
            return $barang;
        });

        return response()->json([
            'success' => true,
            'data' => $barangs
        ]);
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'lokasi'])
            ->where('id', $id)
            ->where('dapat_dipinjam', true)
            ->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan atau tidak dapat dipinjam'
            ], 404);
        }

        $barang->available_stock = $barang->stok_baik_tersedia;

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function categories()
    {
        $categories = Kategori::orderBy('nama_kategori')->get();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function locations()
    {
        $locations = Lokasi::orderBy('nama_lokasi')->get();
        
        return response()->json([
            'success' => true,
            'data' => $locations
        ]);
    }
}
