<x-main-layout titlePage="{{ __('Detail Lokasi: ' . $lokasi->nama_lokasi) }}">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <div class="d-flex align-items-center mb-2">
                <x-tombol-kembali href="{{ route('lokasi.index') }}" class="me-3" />
                <h1 class="h3 fw-bold mb-0" style="color: #1a1a1a;">
                    <i class="fas fa-map-marker-alt me-2" style="color: #6b7280;"></i>
                    {{ $lokasi->nama_lokasi }}
                </h1>
            </div>
            <p class="text-muted mb-0" style="color: #6b7280;">
                Daftar barang yang tersimpan di lokasi ini
            </p>
        </div>
        
        <!-- Stats Summary -->
        <div class="d-none d-md-flex gap-3">
            <div class="text-center px-3">
                <div class="fw-bold" style="color: #1a1a1a; font-size: 1.5rem;">
                    {{ $barangs->total() }}
                </div>
                <small style="color: #6b7280;">Total Barang</small>
            </div>
            @if($barangs->hasPages())
            <div class="vr opacity-50"></div>
            <div class="text-center px-3">
                <div class="fw-bold" style="color: #1a1a1a; font-size: 1.5rem;">
                    {{ $barangs->currentPage() }}
                </div>
                <small style="color: #6b7280;">Halaman</small>
            </div>
            @endif
        </div>
    </div>

    <!-- Notification Alert -->
    <x-notif-alert class="mb-4" />
    
    <!-- Main Content -->
    <div class="position-relative">
        @include('lokasi.partials.list-barang-lokasi')
    </div>
    
    <!-- Pagination Section -->
    @if($barangs->hasPages())
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted" style="color: #6b7280; font-size: 0.875rem;">
                    Menampilkan {{ $barangs->firstItem() }} sampai {{ $barangs->lastItem() }} 
                    dari {{ $barangs->total() }} barang
                </div>
                <div class="text-muted" style="color: #6b7280; font-size: 0.875rem;">
                    Halaman {{ $barangs->currentPage() }} dari {{ $barangs->lastPage() }}
                </div>
            </div>
            
            <div class="d-flex justify-content-center">
                <nav aria-label="Pagination">
                    {{ $barangs->withQueryString()->links() }}
                </nav>
            </div>
        </div>
    @endif
</x-main-layout>