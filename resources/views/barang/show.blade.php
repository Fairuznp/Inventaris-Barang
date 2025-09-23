<x-main-layout titlePage="{{ __('Detail Barang: ' . $barang->nama_barang) }}">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <div class="d-flex align-items-center mb-2">
                <h1 class="h3 fw-bold mb-0" style="color: #1a1a1a;">
                    <i class="fas fa-box me-2" style="color: #6b7280;"></i>
                    {{ $barang->nama_barang }}
                </h1>
            </div>
            <p class="text-muted mb-0" style="color: #6b7280;">
                Informasi lengkap tentang barang inventaris
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left Column - Image -->
        <div class="col-lg-4">
            @include('barang.partials.info-gambar-barang-modern')
        </div>
        
        <!-- Right Column - Details -->
        <div class="col-lg-8">
            @include('barang.partials.info-data-barang-modern')
        </div>
    </div>
     @can('manage barang')
        <div class="d-flex align-items-center justify-content-between mt-4">
            <x-tombol-kembali href="{{ route('barang.index') }}" class="me-3" />
            <button type="button" class="btn px-4 py-2" 
                    onclick="window.location.href='{{ route('barang.edit', $barang->id) }}'"
                    style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; transition: all 0.2s ease;"
                    onmouseover="this.style.background='#374151'"
                    onmouseout="this.style.background='#1a1a1a'">
                <i class="fas fa-edit me-2"></i>
                Edit Barang
            </button>
        </div>
        @endcan
</x-main-layout>