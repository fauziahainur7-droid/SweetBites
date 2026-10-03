@extends('layouts.admin')

@section('title', 'Laporan & Statistik')

@section('content')
<div class="report-page">

    {{-- HEADER --}}
    <div class="report-header">
        <div class="report-heading">
            <span class="report-eyebrow">SWEETBITES ADMINISTRATION</span>
            <h1>Laporan &amp; Statistik</h1>
            <p>Ringkasan performa penjualan dan analitik transaksi toko SweetBites.</p>
        </div>

        <form action="{{ route('admin.reports.index') }}" method="GET" class="report-date-form">
            <div class="report-shortcuts">
                <a href="{{ route('admin.reports.index', ['bulan' => now()->format('Y-m')]) }}"
                   class="report-shortcut {{ ($bulan ?? '') === now()->format('Y-m') ? 'active' : '' }}">
                    Bulan Ini
                </a>

                <a href="{{ route('admin.reports.index', ['bulan' => now()->subDays(29)->format('Y-m')]) }}"
                   class="report-shortcut">
                    30 Hari
                </a>

                <a href="{{ route('admin.reports.index', ['bulan' => now()->format('Y') . '-01']) }}"
                   class="report-shortcut">
                    Tahun Ini
                </a>
            </div>

            <div class="report-date-controls">
                <label for="bulanLaporan">
                    <i class="fa-regular fa-calendar"></i>
                </label>

                <input type="month"
                       id="bulanLaporan"
                       name="bulan"
                       value="{{ $bulan ?? now()->format('Y-m') }}">

                <button type="submit" class="report-primary-button">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- KARTU STATISTIK --}}
    <section class="report-stats">

        <article class="report-stat-card">
            <div class="report-stat-top">
                <span>Pendapatan</span>
                <div class="report-stat-icon brown">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>

            <strong class="report-stat-value">
                Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
            </strong>

            <div class="report-stat-foot">
                <i class="fa-solid fa-chart-line"></i>
                <span>Total pendapatan pesanan selesai</span>
            </div>
        </article>

        <article class="report-stat-card">
            <div class="report-stat-top">
                <span>Total Pesanan</span>
                <div class="report-stat-icon caramel">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>

            <strong class="report-stat-value">
                {{ $totalOrders ?? 0 }}
            </strong>

            <div class="report-stat-foot">
                <span class="report-status-dot sage"></span>
                <span>Pesanan pada periode terpilih</span>
            </div>
        </article>

        <article class="report-stat-card">
            <div class="report-stat-top">
                <span>Pelanggan</span>
                <div class="report-stat-icon sage">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <strong class="report-stat-value">
                {{ $totalCustomers ?? 0 }}
            </strong>

            <div class="report-stat-foot">
                <span class="report-status-dot sage"></span>
                <span>Pelanggan yang melakukan pesanan</span>
            </div>
        </article>

        <article class="report-stat-card report-best-card">
            <div class="report-stat-top">
                <span>Kue Terlaris</span>
                <div class="report-stat-icon cream">
                    <i class="fa-solid fa-cake-candles"></i>
                </div>
            </div>

            <strong class="report-best-name">
                {{ $bestSeller?->product?->nama_kue ?? 'Belum ada penjualan' }}
            </strong>

            <div class="report-best-bottom">
                <span class="report-category-chip">Produk terlaris</span>
                <span>{{ $bestSeller?->total_terjual ?? 0 }} terjual</span>
            </div>
        </article>

    </section>

    {{-- GRAFIK DAN INFORMASI PRODUK --}}
    <section class="report-analytics">

        <article class="report-panel report-chart-panel">
            <div class="report-panel-heading">
                <div>
                    <h2>Rincian Transaksi Bulanan</h2>
                    <p>Nilai pesanan yang tercatat pada bulan terpilih.</p>
                </div>

                <span class="report-legend">
                    <span></span> Nilai Pesanan
                </span>
            </div>

            <div class="report-chart">
                <div class="report-chart-y-labels">
                    <span>Nilai transaksi</span>
                    <span>Rp 0</span>
                </div>

                <div class="report-chart-area">
                    <div class="report-chart-grid">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="report-chart-bars">
                        @forelse($orders as $order)
                            <div class="report-chart-column">
                                <div class="report-bar"
                                    <div class="report-bar" style="height: 50%;">
                                    <span class="report-bar-tooltip">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                <span class="report-chart-month">
                                    {{ $order->created_at?->format('d/m') ?? '-' }}
                                </span>
                            </div>
                        @empty
                            <p class="report-empty-note">
                                Belum ada transaksi pada bulan ini.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </article>

        <article class="report-panel report-category-panel">
            <div class="report-panel-heading">
                <div>
                    <h2>Produk Terlaris</h2>
                    <p>{{ $bulan ?? now()->format('Y-m') }}</p>
                </div>
            </div>

            <div class="report-donut-wrap">
                <div class="report-donut"
                     style="--donut-percent: {{ ($bestSeller?->total_terjual ?? 0) > 0 ? '75%' : '0%' }}">
                    <div class="report-donut-center">
                        <strong>{{ $bestSeller?->total_terjual ?? 0 }}</strong>
                        <span>Terjual</span>
                    </div>
                </div>
            </div>

            <div class="report-category-list">
                <div class="report-category-item">
                    <span class="report-category-name">
                        <i class="report-category-dot dot-brown"></i>
                        Nama Produk
                    </span>
                    <strong>
                        {{ $bestSeller?->product?->nama_kue ?? '-' }}
                    </strong>
                </div>

                <div class="report-category-item">
                    <span class="report-category-name">
                        <i class="report-category-dot dot-sage"></i>
                        Total Terjual
                    </span>
                    <strong>{{ $bestSeller?->total_terjual ?? 0 }} item</strong>
                </div>
            </div>

            <div class="report-category-note">
                <i class="fa-regular fa-lightbulb"></i>
                <span>
                    Produk dengan jumlah penjualan tertinggi pada periode yang dipilih.
                </span>
            </div>
        </article>

    </section>

    {{-- TABEL TRANSAKSI --}}
    <section class="report-panel report-transactions">
        <div class="report-transactions-heading">
            <div>
                <h2>Daftar Transaksi</h2>
                <p>Daftar pesanan dan status transaksi pada periode yang dipilih.</p>
            </div>

            <div class="report-export-actions">
                <button type="button" id="exportCsv" class="report-outline-button">
                    <i class="fa-solid fa-download"></i>
                    Unduh Laporan
                </button>

                <button type="button" onclick="window.print()" class="report-primary-button">
                    <i class="fa-solid fa-file-pdf"></i>
                    Export PDF
                </button>
            </div>
        </div>

        <div class="report-table-scroll">
            <table class="report-transaction-table" id="reportTransactionTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Metode</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                {{ $order->created_at?->format('d/m/y') ?? '-' }}
                            </td>

                            <td>
                                <div class="report-order-code">
                                    <i class="fa-solid fa-box"></i>
                                    <span>{{ $order->kode_pesanan ?? ('ORD-' . $order->id) }}</span>
                                </div>
                            </td>

                            <td>
                                <div class="report-customer">
                                    <span class="report-customer-avatar">
                                        {{ strtoupper(substr($order->user->name ?? 'P', 0, 1)) }}
                                    </span>

                                    <span>{{ $order->user->name ?? '-' }}</span>
                                </div>
                            </td>

                            <td class="report-amount">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="report-status-badge status-{{ $order->status ?? 'default' }}">
                                    <span></span>
                                    {{ ucfirst($order->status ?? 'Belum ada') }}
                                </span>
                            </td>

                            <td>
                                <span class="report-payment-method">
                                    @if(strtolower($order->metode_pembayaran ?? '') === 'cod')
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                        COD
                                    @elseif(!empty($order->metode_pembayaran))
                                        <i class="fa-solid fa-building-columns"></i>
                                        {{ ucfirst($order->metode_pembayaran) }}
                                    @else
                                        <i class="fa-regular fa-credit-card"></i>
                                        -
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="report-no-transactions">
                                Belum ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="report-table-footer">
            <span>
                Menampilkan {{ $orders->count() }} dari {{ $orders->count() }} transaksi
            </span>

            <span class="report-footer-brand">
                SweetBites © {{ now()->year }}
            </span>
        </div>
    </section>

    {{-- LAPORAN TERSIMPAN --}}
    <section class="report-panel report-saved-panel">
        <div class="report-transactions-heading">
            <div>
                <h2>Laporan Tersimpan</h2>
                <p>Daftar laporan yang telah dibuat sebelumnya.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="report-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="report-alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="report-table-scroll">
            <table class="report-transaction-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Periode Mulai</th>
                        <th>Periode Selesai</th>
                        <th>Total Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->judul }}</td>
                            <td>{{ $report->periode_mulai }}</td>
                            <td>{{ $report->periode_selesai }}</td>
                            <td class="report-amount">
                                Rp {{ number_format($report->total_penjualan, 0, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                   class="report-outline-button report-detail-button">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="report-no-transactions">
                                Belum ada laporan tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const exportButton = document.getElementById('exportCsv');

    if (exportButton) {
        exportButton.addEventListener('click', function () {
            const table = document.getElementById('reportTransactionTable');

            const rows = Array.from(table.querySelectorAll('tr'));

            const csv = rows.map(function (row) {
                return Array.from(row.querySelectorAll('th, td'))
                    .map(function (cell) {
                        return '"' + cell.innerText.trim().replace(/"/g, '""') + '"';
                    })
                    .join(',');
            }).join('\r\n');

            const blob = new Blob(['\uFEFF' + csv], {
                type: 'text/csv;charset=utf-8;'
            });

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = 'laporan-sweetbites.csv';
            link.click();

            URL.revokeObjectURL(url);
        });
    }
});
</script>

@endsection