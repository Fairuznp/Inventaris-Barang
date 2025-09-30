<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BarangController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:manage barang', except: ['destroy']),
            new Middleware('permission:delete barang', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $barangs = Barang::select([
                'id', 'kode_barang', 'nama_barang', 'kategori_id', 'lokasi_id',
                'jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 
                'jumlah_total', 'satuan', 'gambar', 'created_at'
            ])
            ->withOptimizedRelations()
            ->search($search)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();

        $barang = new Barang();

        return view('barang.create', compact('barang', 'kategori', 'lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'jumlah_baik' => 'required|integer|min:0',
            'jumlah_rusak_ringan' => 'required|integer|min:0',
            'jumlah_rusak_berat' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_pengadaan' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validasi tambahan: minimal ada 1 barang
        $totalBarang = $validated['jumlah_baik'] + $validated['jumlah_rusak_ringan'] + $validated['jumlah_rusak_berat'];
        if ($totalBarang <= 0) {
            return back()->withErrors(['jumlah_baik' => 'Total jumlah barang harus lebih dari 0'])
                ->withInput();
        }

        // Optimasi upload gambar dengan kompres
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan dengan nama yang dioptimasi
            $validated['gambar'] = $file->storeAs('', $filename, 'gambar-barang');
        }

        // Set total otomatis
        $validated['jumlah_total'] = $totalBarang;

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi']);

        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();

        return view('barang.edit', compact('barang', 'kategori', 'lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'jumlah_baik' => 'required|integer|min:0',
            'jumlah_rusak_ringan' => 'required|integer|min:0',
            'jumlah_rusak_berat' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_pengadaan' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validasi tambahan: minimal ada 1 barang
        $totalBarang = $validated['jumlah_baik'] + $validated['jumlah_rusak_ringan'] + $validated['jumlah_rusak_berat'];
        if ($totalBarang <= 0) {
            return back()->withErrors(['jumlah_baik' => 'Total jumlah barang harus lebih dari 0'])
                ->withInput();
        }

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('gambar-barang')->delete($barang->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store(null, 'gambar-barang');
        }

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::disk('gambar-barang')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }

    /**
     * Generate PDF report for all barang.
     */
    public function cetakLaporan()
    {
        $barangs = Barang::with(['kategori', 'lokasi'])->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('barang.laporan', compact('barangs'));

        return $pdf->stream('laporan-barang.pdf');
    }
}
