@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h2>Dashboard Admin</h2>
<p>Selamat datang, {{ auth()->user()->name }}!</p>

<!-- STATISTIK UTAMA -->
<div class="row">
    <div class="col-md-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5>Produk</h5>
                <h2>{{ $totalProducts ?? \App\Models\Product::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5>Pesanan</h5>
                <h2>{{ $totalOrders ?? \App\Models\Order::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5>Pendapatan</h5>
                <h2>Rp {{ number_format($totalRevenue ?? \App\Models\Order::where('status', 'selesai')->sum('total_harga'), 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5>Pelanggan</h5>
                <h2>{{ $totalUsers ?? \App\Models\User::count() }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- STATISTIK TAMBAHAN -->
@if(isset($ordersToday))
<div class="row mt-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Pesanan Hari Ini</h6>
                <h3>{{ $ordersToday }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Pesanan Menunggu</h6>
                <h3>{{ $pendingOrders ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Pembayaran Menunggu</h6>
                <h3>{{ $pendingPayments ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>
@endif

<!-- MENU CEPAT + GRAFIK -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Menu Cepat</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-dark">Produk</a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kategori</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-dark">Pesanan</a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Pembayaran</a>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-dark">Review</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Laporan</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-dark">User</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Grafik Pendapatan Bulanan</div>
            <div class="card-body">
                @if(isset($monthlyRevenue) && $monthlyRevenue->count() > 0)
                    <table class="table table-sm">
                        <thead><tr><th>Bulan</th><th>Pendapatan</th></tr></thead>
                        <tbody>
                            @foreach($monthlyRevenue as $rev)
                                <tr>
                                    <td>Bulan {{ $rev->month }}</td>
                                    <td>Rp {{ number_format($rev->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center">[GRAFIK PENDAPATAN BULANAN]</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- PRODUK TERLARIS & PESANAN TERBARU -->
<div class="row mt-4">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Kue Terlaris</div>
            <div class="card-body">
                @forelse($bestSellers ?? [] as $product)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $product->nama_kue }}</span>
                        <span class="badge bg-dark">{{ $product->order_details_count ?? 0 }} terjual</span>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data penjualan</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">Pesanan Terbaru</div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead><tr><th>Kode</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>{{ $order->kode_pesanan }}</td>
                                <td>{{ $order->user->name ?? '-' }}</td>
                                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'batal' ? 'danger' : 'warning') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection