@extends('layouts.app')

@section('title', 'Laporan & Statistik')

@section('content')

<h2>Laporan & Statistik</h2>

<form action="{{ route('admin.reports.index') }}" method="GET">

    <div class="row mb-3">

        <div class="col-md-3">

            <input
                type="month"
                name="bulan"
                class="form-control"
                value="{{ $bulan }}"
            >

        </div>

        <div class="col-md-2">

            <button
                type="submit"
                class="btn btn-dark"
            >
                Tampilkan
            </button>

        </div>

    </div>

</form>

<div class="row">

    <div class="col-md-3">

        <div class="card bg-dark text-white">

            <div class="card-body">

                <h5>Pendapatan</h5>

                <h2>
                    Rp{{ number_format(
                        $totalRevenue ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-secondary text-white">

            <div class="card-body">

                <h5>Total Pesanan</h5>

                <h2>
                    {{ $totalOrders ?? 0 }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-dark text-white">

            <div class="card-body">

                <h5>Pelanggan</h5>

                <h2>
                    {{ $totalCustomers ?? 0 }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-secondary text-white">

            <div class="card-body">

                <h5>Kue Terlaris</h5>

                <h5>
                    {{ $bestSeller->product->nama_kue ?? '-' }}
                </h5>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card">

            <div class="card-header">
                Grafik Pendapatan Bulanan
            </div>

            <div class="card-body text-center text-muted">

                [GRAFIK PENDAPATAN]

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card">

            <div class="card-header">
                Kategori Terlaris
            </div>

            <div class="card-body text-center text-muted">

                [GRAFIK KATEGORI]

            </div>

        </div>

    </div>

</div>

<div class="card mt-4">

    <div class="card-header">

        <strong>Daftar Transaksi</strong>

        <div class="float-end">

            <button
                type="button"
                class="btn btn-dark btn-sm"
            >
                Export PDF
            </button>

        </div>

    </div>

    <div class="card-body">

        <table class="table">

            <thead>

                <tr>

                    <th>Tanggal</th>
                    <th>No.Pesanan</th>
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
                            {{ $order->created_at->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $order->kode_pesanan }}
                        </td>

                        <td>
                            {{ $order->user->name ?? '-' }}
                        </td>

                        <td>
                            Rp
                            {{ number_format(
                                $order->total_harga,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>

                            @if($order->status === 'selesai')

                                <span class="badge bg-success">
                                    Selesai
                                </span>

                            @elseif($order->status === 'diproses')

                                <span class="badge bg-warning text-dark">
                                    Diproses
                                </span>

                            @elseif($order->status === 'batal')

                                <span class="badge bg-danger">
                                    Batal
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst($order->status) }}
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $order->metode_pembayaran ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center"
                        >
                            Belum ada data transaksi
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection