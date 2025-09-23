<section class="hero-section text-white d-flex align-items-center" style="margin-top: 76px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-4" style="font-weight: 700; line-height: 1.2;">
                        Sistem Inventaris
                        <span style="color: #d1d5db;">Modern</span>
                    </h1>
                    <p class="lead mb-4" style="font-size: 1.25rem; color: #d1d5db; font-weight: 300;">
                        Kelola aset dan stok barang dengan mudah, cepat, dan akurat. 
                        Solusi inventaris yang dirancang untuk efisiensi maksimal.
                    </p>
                    <div class="hero-buttons">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg me-3">
                                    <i class="bi bi-arrow-right me-2"></i>
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light btn-lg me-3">
                                    <i class="bi bi-arrow-right me-2"></i>
                                    Mulai Sekarang
                                </a>
                            @endauth
                        @endif
                        <a href="#fitur" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-info-circle me-2"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image mt-5 mt-lg-0">
                    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 3rem; backdrop-filter: blur(10px);">
                        <i class="bi bi-boxes" style="font-size: 8rem; color: rgba(255, 255, 255, 0.8);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>