<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Jaya Kost Group')</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/logo-jaya-kost.png') }}" alt="Logo Jaya Kost Group">
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('about') }}">Tentang Kami</a>
            <a href="{{ route('gallery') }}">Galeri</a>
            <a href="{{ route('book') }}">Pesan Sekarang</a>

        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @endif

            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        @else
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        @endauth

        </div>

        <button class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
    
    <!-- Menu Overlay for mobile -->
    <div class="menu-overlay"></div>
    
    @yield('content')
    <footer>
        <div class="footer-contact">
            <a href="https://maps.app.goo.gl/soiJSYGetd88fPr76" target="_blank" rel="noopener noreferrer">
                Jl. Limo Raya Blok Kramat No.26A, RT.03/RW.05, Limo, Kec. Limo, Kota Depok, Jawa Barat 16531
            </a>
        </div>
        © 2025 Jaya Kost Group. All rights reserved.
    </footer>
    <script src="{{ asset('script.js') }}"></script>
    @yield('scripts')
</body>
</html>