<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/" style="color: var(--primary); font-size: 1.5rem;">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="box-shadow: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ url('/dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-dark ms-2" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Masuk
                            </a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>