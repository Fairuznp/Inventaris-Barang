<x-main-layout titlePage="{{ __('Daftar Barang') }}">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: #1a1a1a;">
                <i class="fas fa-boxes me-2" style="color: #6b7280;"></i>
                Manajemen Barang
            </h1>
            <p class="text-muted mb-0" style="color: #6b7280;">
                Kelola inventaris dan stok barang dengan mudah
            </p>
        </div>
        
        <!-- Stats Summary -->
        <div class="d-none d-md-flex gap-3">
            <div class="text-center px-3">
                <div class="fw-bold" style="color: #1a1a1a; font-size: 1.5rem;">
                    {{ $barangs->total() }}
                </div>
                <small style="color: #6b7280;">Total Item</small>
            </div>
            <div class="vr opacity-50"></div>
            <div class="text-center px-3">
                <div class="fw-bold" style="color: #1a1a1a; font-size: 1.5rem;">
                    {{ $barangs->currentPage() }}
                </div>
                <small style="color: #6b7280;">Halaman</small>
            </div>
        </div>
    </div>

    <!-- Toolbar Section -->
    <div class="mb-4">
        @include('barang.partials.toolbar')
    </div>
    
    <!-- Notification Alert -->
    <x-notif-alert class="mb-4" />
    
    <!-- Main Content -->
    <div class="position-relative">
        @include('barang.partials.list-barang')
    </div>
    
    <!-- Pagination Section -->
    @if($barangs->hasPages())
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted" style="color: #6b7280; font-size: 0.875rem;">
                    Menampilkan {{ $barangs->firstItem() }} sampai {{ $barangs->lastItem() }} 
                    dari {{ $barangs->total() }} hasil
                </div>
                
                <!-- View Mode Toggle (Optional) -->
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="view-mode" id="card-view" checked>
                    <label class="btn btn-outline-secondary btn-sm" for="card-view" 
                           style="border-color: #e5e7eb; color: #6b7280;">
                        <i class="fas fa-th-large"></i>
                    </label>
                    
                    <input type="radio" class="btn-check" name="view-mode" id="list-view">
                    <label class="btn btn-outline-secondary btn-sm" for="list-view"
                           style="border-color: #e5e7eb; color: #6b7280;">
                        <i class="fas fa-list"></i>
                    </label>
                </div>
            </div>
            
            <!-- Custom Pagination -->
            <div class="d-flex justify-content-center">
                <nav>
                    {{ $barangs->links('pagination::bootstrap-4', [
                        'class' => 'pagination-modern'
                    ]) }}
                </nav>
            </div>
        </div>
    @endif
</x-main-layout>

<style>
/* Page transition */
.position-relative {
    min-height: 200px;
}

/* Stats hover effect */
.d-md-flex .text-center:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* Modern pagination styles */
.pagination-modern .page-link {
    border: none !important;
    margin: 0 2px;
    border-radius: 8px !important;
    color: #6b7280 !important;
    background: #f3f4f6 !important;
    padding: 0.5rem 0.75rem !important;
    font-weight: 500;
    transition: all 0.2s ease;
}

.pagination-modern .page-link:hover {
    background: #e5e7eb !important;
    color: #1a1a1a !important;
    transform: translateY(-1px);
}

.pagination-modern .page-item.active .page-link {
    background: #1a1a1a !important;
    color: #fafafa !important;
    box-shadow: 0 2px 8px rgba(26, 26, 26, 0.2);
}

/* View mode toggle */
.btn-group .btn-check:checked + .btn-outline-secondary {
    background: #1a1a1a !important;
    border-color: #1a1a1a !important;
    color: #fafafa !important;
}

/* Loading state */
.loading-skeleton {
    background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .btn-group {
        order: -1;
    }
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Focus styles for accessibility */
.btn:focus,
.form-control:focus {
    outline: 2px solid #1a1a1a;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .btn, .pagination, .btn-group {
        display: none !important;
    }
    
    .card {
        break-inside: avoid;
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
}
</style>