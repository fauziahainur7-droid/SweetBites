@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="topbar">
    <h1>Dashboard</h1>
    <div class="date-badge">
        <i class="bi bi-calendar3"></i>
        <span>{{ now()->translatedFormat('d F Y') }}</span>
    </div>
</div>

<div class="stat-row">

    <div class="stat-card-modern gold">
        <div class="info">
            <span>Total Produk</span>
            <h3>{{ $totalProducts }}</h3>
            <small>Produk tersedia</small>
        </div>
        <i class="bi bi-cake2 icon-big"></i>
    </div>

    <div class="stat-card-modern green">
        <div class="info">
            <span>Total Pesanan</span>
            <h3>{{ $totalOrders }}</h3>
            <small>Pesanan masuk</small>
        </div>
        <i class="bi bi-cart-check icon-big"></i>
    </div>

    <div class="stat-card-modern teal">
        <div class="info">
            <span>Total Pendapatan</span>
            <h3>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <small>Pesanan selesai</small>
        </div>
        <i class="bi bi-cash-stack icon-big"></i>
    </div>

</div>

<div class="middle-row">

    <div class="card-modern">
        <div class="card-header">
            <div>
                <h5>Pesanan Terbaru</h5>
                <p>Ringkasan pesanan pelanggan</p>
            </div>
            <a href="{{ url('/admin/orders') }}">Lihat semua</a>
        </div>

        <table class="table-modern">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Pesanan</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                @php
                $nama = $order->user->name ?? 'User';
                $kata = preg_split('/\s+/', trim($nama));
                $inisial = '';
                foreach (array_slice($kata, 0, 2) as $k) {
                if (!empty($k)) $inisial .= strtoupper(substr($k, 0, 1));
                }
                $status = strtolower(trim($order->status));
                $badgeClass = match ($status) {
                'selesai' => 'done',
                'dibatalkan' => 'cancel',
                default => 'pending',
                };
                @endphp
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">{{ $inisial ?: 'U' }}</div>
                            <div>
                                <strong class="customer-name">{{ $nama }}</strong><br>
                                <small class="customer-email">{{ $order->user->email ?? '' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>#{{ $order->kode_pesanan }}</td>
                    <td>
                        <span class="badge-modern {{ $badgeClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="4">Belum ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-modern">
        <div class="statistik-image">
            <img src="{{ asset('images/statistik.png') }}" alt="Statistik">
        </div>
    </div>

</div>

<div class="bottom-row">

    <div class="card-modern">
        <div class="card-header">
            <div>
                <h5>Produk Terlaris</h5>
                <p>Berdasarkan jumlah pesanan</p>
            </div>
        </div>


        @php
        $bestSellers = $bestSellers
        ->filter(function ($product) {
        return $product->order_details_count > 0;
        })
        ->values();
        @endphp

        @if($bestSellers->count() > 0)
        @php
        $warnaDonut = ['#1E3A34', '#C9A227', '#2E8B8B', '#D4966E', '#8B5E4B'];
        $totalBest = $bestSellers->sum('order_details_count') ?: 1;
        $gradientParts = [];
        $start = 0;
        foreach ($bestSellers as $i => $p) {
        $percent = ($p->order_details_count / $totalBest) * 100;
        $end = $start + $percent;
        $gradientParts[] = $warnaDonut[$i % count($warnaDonut)] . " {$start}% {$end}%";
        $start = $end;
        }
        $gradient = implode(', ', $gradientParts);
        @endphp

        <div class="donut-wrapper">
            <div class="donut" data-gradient="{{ $gradient }}"></div>
        </div>

        <div class="donut-legend">
            @foreach($bestSellers as $i => $p)
            <div class="donut-legend-item">
                <span>
                    <span class="dot" data-color="{{ $warnaDonut[$i % count($warnaDonut)] }}"></span>
                    {{ $p->nama_kue }}
                </span>
                <strong>{{ $p->order_details_count }}</strong>
            </div>
            @endforeach
        </div>
        @else
        <p class="empty-donut">Belum ada data</p>
        @endif
    </div>

    <div class="card-modern">
        <div class="card-header">
            <div>
                <h5>Grafik Penjualan</h5>
                <p>Pendapatan bulanan {{ now()->year }}</p>
            </div>
        </div>

        @php
        $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $revenueByMonth = $monthlyRevenue->keyBy('month');
        $maxPenjualan = $monthlyRevenue->max('total') ?? 1;
        $maxPenjualan = max($maxPenjualan, 1);
        @endphp

        <div class="line-chart">
            @for($b = 1; $b <= 12; $b++)
                @php
                $total=isset($revenueByMonth[$b]) ? (float) $revenueByMonth[$b]->total : 0;
                $tinggi = ($total / $maxPenjualan) * 100;
                if ($total > 0 && $tinggi < 5) $tinggi=5;
                    @endphp
                    <div class="line-point">
                    <div class="dot-point" data-offset="{{ $tinggi }}"></div>
                    <span>{{ $namaBulan[$b-1] }}</span>
        </div>
        @endfor
    </div>
</div>

</div>

@endsection