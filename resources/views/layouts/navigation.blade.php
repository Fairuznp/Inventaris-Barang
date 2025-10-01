<style>
/* Modern Navbar Styles */
.navbar-modern {
    background: #fafafa !important;
    border-bottom: 1px solid #f3f4f6 !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    padding: 12px 0;
    transition: all 0.3s ease;
}

.navbar-modern .navbar-brand {
    font-weight: 600;
    color: #1a1a1a !important;
    transition: all 0.2s ease;
}

.navbar-modern .navbar-brand:hover {
    transform: scale(1.05);
}

.navbar-modern .navbar-toggler {
    border: 1px solid #f3f4f6;
    border-radius: 8px;
    padding: 8px 12px;
    transition: all 0.2s ease;
}

.navbar-modern .navbar-toggler:hover {
    background: #f3f4f6;
    border-color: #1a1a1a;
}

.navbar-modern .navbar-toggler:focus {
    box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
}

.navbar-modern .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%231a1a1a' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Navigation Links */
.navbar-modern .navbar-nav .nav-link {
    color: #6b7280 !important;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 8px 16px !important;
    margin: 0 4px;
    border-radius: 8px;
    transition: all 0.2s ease;
    position: relative;
}

.navbar-modern .navbar-nav .nav-link:hover {
    color: #1a1a1a !important;
    background: #f3f4f6;
    transform: translateY(-1px);
}

.navbar-modern .navbar-nav .nav-link.active {
    color: #fafafa !important;
    background: #1a1a1a;
    font-weight: 600;
}

.navbar-modern .navbar-nav .nav-link.active:hover {
    background: #1a1a1a;
    color: #fafafa !important;
}

/* Laravel Breeze Dropdown Styles */
.navbar-modern .dropdown button {
    color: #1a1a1a !important;
    font-weight: 600;
    padding: 8px 16px !important;
    border-radius: 8px;
    border: 1px solid #f3f4f6;
    background: #fafafa;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.navbar-modern .dropdown button:hover {
    background: #f3f4f6;
    border-color: #1a1a1a;
    transform: translateY(-1px);
}

.navbar-modern .dropdown button:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
}

/* Dropdown content styling */
.navbar-modern .dropdown > div[role="menu"] {
    background: #fafafa;
    border: 1px solid #f3f4f6;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 8px;
    margin-top: 8px;
    min-width: 160px;
}

.navbar-modern .dropdown a,
.navbar-modern .dropdown button[type="submit"] {
    color: #6b7280 !important;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 10px 16px;
    border-radius: 8px;
    transition: all 0.2s ease;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
    text-decoration: none;
    display: block;
}

.navbar-modern .dropdown a:hover,
.navbar-modern .dropdown button[type="submit"]:hover {
    color: #1a1a1a !important;
    background: #f3f4f6;
    transform: translateX(4px);
}

.navbar-modern .dropdown a:active,
.navbar-modern .dropdown button[type="submit"]:active {
    background: #1a1a1a;
    color: #fafafa !important;
}

/* User Avatar/Icon */
.user-avatar {
    width: 32px;
    height: 32px;
    background: #1a1a1a;
    color: #fafafa;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.8rem;
    margin-right: 8px;
    transition: all 0.2s ease;
}

.navbar-modern .dropdown-toggle:hover .user-avatar {
    background: #6b7280;
    transform: scale(1.1);
}

/* Mobile Responsive */
@media (max-width: 991.98px) {
    .navbar-modern .navbar-collapse {
        background: #fafafa;
        border-radius: 12px;
        margin-top: 16px;
        padding: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .navbar-modern .navbar-nav .nav-link {
        margin: 4px 0;
        text-align: center;
    }
    
    .navbar-modern .dropdown button {
        justify-content: center;
        margin-top: 12px;
    }
    
    .navbar-modern .dropdown > div[role="menu"] {
        position: static !important;
        transform: none !important;
        box-shadow: none;
        border: none;
        background: transparent;
        margin-top: 8px;
    }
    
    .navbar-modern .dropdown a,
    .navbar-modern .dropdown button[type="submit"] {
        background: #f3f4f6;
        margin-bottom: 4px;
    }
}

/* Animation for dropdown - Laravel Breeze compatible */
.navbar-modern .dropdown > div[role="menu"] {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.navbar-modern .dropdown[aria-expanded="true"] > div[role="menu"],
.navbar-modern .dropdown.show > div[role="menu"] {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
</style>

<nav class="navbar navbar-expand-lg navbar-light navbar-modern">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo style="height: 32px; width:auto;" />
        </a>

        <!-- Toggler (hamburger) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                @php
                $navs = [
                    ['route' => 'dashboard', 'name' => 'Dashboard'],
                    ['route' => 'barang.index', 'name' => 'Barang'],
                    ['route' => 'peminjaman.index', 'name' => 'Peminjaman'],
                    ['route' => 'loan-requests.index', 'name' => 'Permintaan', 'icon' => 'fas fa-clipboard-list'],
                    ['route' => 'pemeliharaan.index', 'name' => 'Pemeliharaan'],
                    ['route' => 'lokasi.index', 'name' => 'Lokasi'],
                    ['route' => 'kategori.index', 'name' => 'Kategori'],
                    ['route' => 'laporan.index', 'name' => 'Laporan'],
                    ['route' => 'user.index', 'name' => 'User', 'role' => 'admin'],
                ];
                @endphp

                @foreach ($navs as $nav)
                    @php
                        extract($nav);
                    @endphp

                    @if (isset($role))
                        @role($role)
                            <li class="nav-item">
                                <x-nav-link :active="request()->routeIs($route)" :href="route($route)">
                                    {{ __($name) }}
                                </x-nav-link>
                            </li>
                        @endrole
                    @else
                        <li class="nav-item">
                            <x-nav-link :active="request()->routeIs($route)" :href="route($route)">
                                {{ __($name) }}
                            </x-nav-link>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown User -->
                <x-dropdown>
                    <x-slot name="trigger">
                        <span class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        {{ Auth::user()->name }}
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </ul>
        </div>
    </div>
</nav>