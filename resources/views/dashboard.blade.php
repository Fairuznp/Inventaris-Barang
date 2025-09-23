<x-main-layout titlePage="{{ __('Dashboard') }}">
    <style>
    /* Global Modern Dashboard Styles */
    .dashboard-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .welcome-section {
        background: linear-gradient(135deg, #1a1a1a 0%, #6b7280 100%);
        color: #fafafa;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        transform: translate(-20px, 20px);
    }

    .welcome-text {
        position: relative;
        z-index: 1;
    }

    .welcome-text h3 {
        font-weight: 300;
        font-size: 1.5rem;
        margin: 0;
        opacity: 0.9;
    }

    .welcome-text strong {
        font-weight: 600;
        color: #fafafa;
    }

    .section-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .section-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #1a1a1a;
    }

    .card-header-modern {
        background: #f3f4f6;
        border-bottom: 1px solid #f3f4f6;
        padding: 20px 24px;
    }

    .card-header-modern h6 {
        color: #1a1a1a;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .card-header-modern h6 i {
        margin-right: 8px;
        font-size: 1.1rem;
        color: #6b7280;
    }

    .card-body-modern {
        padding: 0;
    }

    .table-container {
        background: #fafafa;
        border-radius: 0 0 16px 16px;
        overflow: hidden;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .welcome-section {
            padding: 24px;
        }
        
        .welcome-text h3 {
            font-size: 1.25rem;
        }
        
        .section-card:hover {
            transform: none;
        }
    }
    </style>

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h3>
                    Selamat Datang, <strong>{{ auth()->user()->name }}</strong>!
                </h3>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row">
            @include('dashboard-partials.list-kartu-total')
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Kondisi Barang Section -->
            <div class="col-lg-6 mb-4">
                <div class="section-card">
                    <div class="card-header-modern">
                        <h6>
                            <i class="bi-pie-chart"></i>
                            Ringkasan Stok per Kondisi
                        </h6>
                    </div>
                    @include('dashboard-partials.list-kondisi-barang')
                </div>
            </div>

            <!-- Recent Items Section -->
            <div class="col-lg-6 mb-4">
                <div class="section-card">
                    <div class="card-header-modern">
                        <h6>
                            <i class="bi-clock-history"></i>
                            5 Barang Terakhir Ditambahkan
                        </h6>
                    </div>

                    <div class="table-container">
                        @include('dashboard-partials.list-barang-terakhir')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>