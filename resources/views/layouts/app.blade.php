<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SweetBites - @yield('title', 'Toko Kue')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                SweetBites
            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">

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

                <ul class="navbar-nav">

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
    <div class="container mt-4">

        @yield('content')

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>