<x-main-layout titlePage="{{ __('Permintaan Peminjaman') }}">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: #1a1a1a;">
                <i class="fas fa-clipboard-list me-2" style="color: #6b7280;"></i>
                Permintaan Peminjaman
            </h1>
            <p class="text-muted mb-0" style="color: #6b7280;">
                Kelola permintaan peminjaman dari mobile app
            </p>
        </div>
        
        <!-- Stats Summary -->
        <div class="d-none d-md-flex gap-3">
            <div class="text-center px-3">
                <div class="fw-bold" style="color: #f59e0b; font-size: 1.5rem;">
                    {{ $pendingCount }}
                </div>
                <small style="color: #6b7280;">Pending</small>
            </div>
            <div class="vr opacity-50"></div>
            <div class="text-center px-3">
                <div class="fw-bold" style="color: #1a1a1a; font-size: 1.5rem;">
                    {{ $requests->total() }}
                </div>
                <small style="color: #6b7280;">Total</small>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm" style="background: #fafafa; border-radius: 12px;">
            <div class="card-body p-3">
                <form method="GET" class="d-flex gap-3 align-items-center">
                    <div>
                        <label class="form-label fw-semibold mb-1" style="color: #1a1a1a; font-size: 0.875rem;">Status:</label>
                        <select name="status" class="form-select form-select-sm" style="min-width: 150px;" onchange="this.form.submit()">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Notification Alert -->
    <x-notif-alert class="mb-4" />
    
    <!-- Main Content -->
    <div class="row g-4">
        @forelse ($requests as $request)
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100" style="background: #fafafa; border-radius: 12px; transition: all 0.3s ease;">
                    <!-- Card Header -->
                    <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: transparent; padding: 1.25rem 1.25rem 0.75rem;">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; background: #f3f4f6; color: #1a1a1a;">
                                <i class="fas fa-user" style="font-size: 16px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="color: #1a1a1a; font-size: 0.9rem;">
                                    {{ $request->nama_peminjam }}
                                </h6>
                                <small class="text-muted" style="color: #6b7280 !important; font-size: 0.75rem;">
                                    {{ $request->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <span class="badge {{ $request->status_badge_class }} px-2 py-1" style="font-size: 0.7rem; font-weight: 600;">
                            {{ $request->status_text }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body" style="padding: 0.75rem 1.25rem 1.25rem;">
                        <!-- Barang Info -->
                        <h5 class="card-title mb-3 fw-bold lh-base" style="color: #1a1a1a; font-size: 1rem;">
                            {{ $request->barang->nama_barang }}
                        </h5>

                        <!-- Request Info Grid -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="small fw-medium" style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Jumlah
                                    </span>
                                    <span class="fw-semibold mt-1" style="color: #1a1a1a; font-size: 0.875rem;">
                                        {{ $request->jumlah }} unit
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-column">
                                    <span class="small fw-medium" style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Tanggal Pinjam
                                    </span>
                                    <span class="fw-semibold mt-1" style="color: #1a1a1a; font-size: 0.875rem;">
                                        {{ $request->tanggal_pinjam->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                            @if($request->kontak_peminjam)
                            <div class="col-12">
                                <div class="d-flex flex-column">
                                    <span class="small fw-medium" style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Kontak
                                    </span>
                                    <span class="fw-semibold mt-1" style="color: #1a1a1a; font-size: 0.875rem;">
                                        {{ $request->kontak_peminjam }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Cancelled Reason Preview -->
                        @if($request->hasCancellationReason())
                        <div class="mb-3 p-2 rounded" style="background: #fff3cd; border-left: 4px solid #ffc107;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-comment-alt text-warning me-2 mt-1" style="font-size: 0.75rem;"></i>
                                <div class="flex-grow-1">
                                    <span class="small fw-medium text-warning-emphasis d-block">Alasan Dibatalkan:</span>
                                    <span class="small text-muted" style="font-size: 0.75rem;">
                                        {{ Str::limit($request->cancellation_reason, 50) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('loan-requests.show', $request) }}" class="btn btn-sm px-3 py-2" 
                               style="background: #f3f4f6; color: #1a1a1a; border: none; border-radius: 8px; font-weight: 500; font-size: 0.8rem; transition: all 0.2s ease;">
                                <i class="fas fa-eye me-1" style="font-size: 0.75rem;"></i>
                                Detail
                            </a>
                            
                            @if($request->status === 'pending')
                                <form method="POST" action="{{ route('loan-requests.approve', $request) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm px-3 py-2" 
                                            style="background: #16a34a; color: #ffffff; border: none; border-radius: 8px; font-weight: 500; font-size: 0.8rem; transition: all 0.2s ease;"
                                            onclick="return confirm('Setujui permintaan peminjaman ini?')">
                                        <i class="fas fa-check me-1" style="font-size: 0.75rem;"></i>
                                        Setujui
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div class="text-center py-5" style="background: #fafafa; border-radius: 12px; border: 2px dashed #e5e7eb;">
                    <div class="mb-3">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #9ca3af;"></i>
                    </div>
                    <h5 class="mb-2" style="color: #1a1a1a;">Belum Ada Permintaan</h5>
                    <p class="mb-0" style="color: #6b7280;">
                        Belum ada permintaan peminjaman dari mobile app.
                    </p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination Section -->
    @if($requests->hasPages())
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted" style="color: #6b7280; font-size: 0.875rem;">
                    Menampilkan {{ $requests->firstItem() }} sampai {{ $requests->lastItem() }} 
                    dari {{ $requests->total() }} permintaan
                </div>
            </div>
            {{ $requests->withQueryString()->links() }}
        </div>
    @endif

    <!-- Real-time Notification JavaScript -->
    @push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize broadcasting if available
        @if(config('broadcasting.default') === 'reverb' || config('broadcasting.default') === 'pusher')
        try {
            const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") ?? config("broadcasting.connections.reverb.key") }}', {
                cluster: '{{ config("broadcasting.connections.pusher.options.cluster") ?? "mt1" }}',
                encrypted: true
            });

            // Subscribe to admin notifications
            const adminChannel = pusher.subscribe('admin-notifications');
            
            adminChannel.bind('loan-request.created', function(data) {
                // Show notification
                showNotification(data.message, 'info');
                // Optionally reload page or update counter
                setTimeout(() => window.location.reload(), 2000);
            });

            adminChannel.bind('loan-request.cancelled', function(data) {
                // Extract reason from admin_notes
                const reason = data.admin_notes ? data.admin_notes.replace('Dibatalkan oleh user: ', '') : '';
                const reasonPreview = reason.length > 50 ? reason.substring(0, 50) + '...' : reason;
                
                // Show notification for cancelled request with reason preview
                const message = `
                    <strong>Permintaan Dibatalkan</strong><br>
                    <small>Dari: ${data.nama_peminjam}</small><br>
                    <small>Barang: ${data.barang_nama}</small><br>
                    ${reason ? `<small><em>"${reasonPreview}"</em></small>` : ''}
                `;
                showNotification(message, 'warning');
                // Reload page to update list
                setTimeout(() => window.location.reload(), 3000);
            });

            function showNotification(message, type = 'info') {
                // Simple notification - you can integrate with toast library
                const alertClass = type === 'info' ? 'alert-info' : 
                                 type === 'warning' ? 'alert-warning' : 'alert-success';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                         style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', alertHtml);
            }
        } catch (error) {
            console.log('Broadcasting not available:', error);
        }
        @endif
    });
    </script>
    @endpush

    <style>
    .card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-2 .btn {
            width: 100%;
            justify-content: center;
        }
    }

    .card {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</x-main-layout>