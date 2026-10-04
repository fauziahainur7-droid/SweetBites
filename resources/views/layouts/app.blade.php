<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SweetBites - @yield('title', 'Toko Kue')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS SweetBites -->
    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">

</head>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bar-item .bar').forEach(function (el) {
        var h = el.getAttribute('data-height');
        if (h) el.style.height = h + '%';
    });

    document.querySelectorAll('.donut').forEach(function (el) {
        var g = el.getAttribute('data-gradient');
        if (g) el.style.background = 'conic-gradient(' + g + ')';
    });

    document.querySelectorAll('.donut-legend-item .dot').forEach(function (el) {
        var c = el.getAttribute('data-color');
        if (c) el.style.backgroundColor = c;
    });

    document.querySelectorAll('.line-point .dot-point').forEach(function (el) {
        var o = el.getAttribute('data-offset');
        if (o) el.style.marginBottom = o + '%';
    });
});
</script>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-sweetbites">
        <div class="container ">

            <a class="navbar-brand fw-bold d-flex align-items-center"
                href="{{ route('home') }}">

                <img src="{{ asset('images/logotoko1.png') }}"
                    alt="Logo SweetBites"
                    class="logo-sweetbites">

                <span>SweetBites</span>

            </a>
            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav navbar-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog') }}">
                            Katalog
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            Tentang Kami
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            Kontak
                        </a>
                    </li>

                    @auth

                    @php
                    $isAdmin = \App\Models\Admin::where(
                    'email',
                    auth()->user()->email
                    )->exists();
                    @endphp

                    @if(!$isAdmin)

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            Keranjang
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            Pesanan
                        </a>
                    </li>



                    @endif

                    @if($isAdmin)

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            Dashboard Admin
                        </a>
                    </li>

                    @endif

                    @endauth

                </ul>

                <ul class="navbar-nav navbar-right">

                    @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>

                    @else

                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        Halo, {{ auth()->user()->name }}
                    </a>

                    <li class="nav-item">

                        <form action="{{ route('logout') }}"
                            method="POST"
                            class="d-inline">

                            @csrf

                            <button type="submit"
                                class="btn btn-link nav-link">
                                Logout
                            </button>

                        </form>

                    </li>

                    @endguest

                </ul>

            </div>
        </div>
    </nav>


    {{-- PESAN SUCCESS --}}
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- PESAN ERROR --}}
    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif


    {{-- ISI HALAMAN --}}
        @yield('content')

    {{-- FOOTER --}}

    @if (!request()->is('admin/*'))

        <footer class="footer" style="height: 300px !important; padding: 20px !important;">

            <div class="footer-box" style="height: 250px !important; padding: 20px 30px !important;">

                <div class="sweet-footer-content">

                    <!-- SweetBites -->
                    <div class="sweet-footer-column sweet-footer-brand">

                        <h3>SweetBites</h3>

                        <p>
                            Homemade bakery<br>
                            dengan rasa premium<br>
                            dan dibuat fresh<br>
                            setiap hari.
                        </p>

                    </div>

                    <!-- Navigasi -->
                    <div class="sweet-footer-column">

                        <h3>Navigasi</h3>

                        <div class="sweet-footer-line"></div>

                        <a href="{{ route('home') }}">
                            Beranda
                        </a>

                        <a href="{{ route('catalog') }}">
                            Katalog
                        </a>

                        <a href="{{ route('about') }}">
                            Tentang Kami
                        </a>

                        <a href="{{ route('contact') }}">
                            Kontak
                        </a>

                    </div>

                    <!-- Hubungi Kami -->
                    <div class="sweet-footer-column">

                        <h3>Hubungi Kami</h3>

                        <div class="sweet-footer-line"></div>

                        <p>📍 Purbalingga</p>
                        <p>📞 08xx-xxx</p>
                        <p>✉️ sweetbites@gmail.com</p>

                    </div>

                </div>

                <!-- Tulisan besar -->
                <div class="footer-brand">
                    SWEETBITES
                </div>

            </div>

        </footer>

    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>