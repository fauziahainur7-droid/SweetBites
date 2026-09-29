<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SweetBites Admin - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS SweetBites -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="admin-dashboard">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="sidebar-profile">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <strong>{{ auth()->user()->name }}</strong>
            <small>{{ auth()->user()->email }}</small>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/admin/products') }}"
               class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Produk</span>
            </a>

            <a href="{{ url('/admin/categories') }}"
               class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ url('/admin/orders') }}"
               class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="bi bi-bag-check-fill"></i>
                <span>Pesanan</span>
            </a>

            <a href="{{ url('/admin/payments') }}"
               class="{{ request()->is('admin/payments*') ? 'active' : '' }}">
                <i class="bi bi-credit-card-fill"></i>
                <span>Pembayaran</span>
            </a>

            <a href="{{ url('/admin/reviews') }}"
               class="{{ request()->is('admin/reviews*') ? 'active' : '' }}">
                <i class="bi bi-star-fill"></i>
                <span>Review</span>
            </a>

            <a href="{{ url('/admin/reports') }}"
               class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('home') }}">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Toko</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA (diisi oleh tiap halaman)       --}}
    <main class="main-content">

        {{-- Alert success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Alert error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Validation error --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ISI HALAMAN --}}
        @yield('content')

    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Script chart (buat dashboard) --}}
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

</body>
</html>