@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')

<h2>Riwayat Pesanan Saya</h2>

<hr>

<div class="row mb-3">

    <div class="col-md-5">
        <input
            type="text"
            id="searchOrder"
            class="form-control"
            placeholder="Cari Pesanan....">
    </div>

    <div class="col-md-5">
        <select
            id="filterStatus"
            class="form-control">
            <option value="">Status Semua</option>
            <option value="menunggu">Menunggu</option>
            <option value="diproses">Diproses</option>
            <option value="siap">Siap</option>
            <option value="selesai">Selesai</option>
            <option value="batal">Batal</option>
        </select>
    </div>

</div>


<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody id="orderTable">

                    @forelse($orders as $order)

                    <tr
                        class="order-row"
                        data-status="{{ $order->status }}"
                        data-search="{{ strtolower($order->kode_pesanan) }}">

                        <td>
                            {{ $loop->iteration }}.
                        </td>

                        <td>
                            {{ $order->kode_pesanan }}
                        </td>

                        <td>
                            {{ $order->created_at->format('d/m/Y') }}
                        </td>

                        <td>
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>

                        <td>

                            @if($order->status === 'selesai')

                            <span class="badge bg-success">
                                Selesai
                            </span>

                            @elseif($order->status === 'batal')

                            <span class="badge bg-danger">
                                Batal
                            </span>

                            @elseif($order->status === 'diproses')

                            <span class="badge bg-primary">
                                Diproses
                            </span>

                            @elseif($order->status === 'siap')

                            <span class="badge bg-info text-dark">
                                Siap
                            </span>

                            @else

                            <span class="badge bg-warning text-dark">
                                Menunggu
                            </span>

                            @endif

                        </td>

                        <td>

                            {{-- Tombol Detail --}}
                            <a
                                href="{{ route('orders.show', $order->id) }}"
                                class="btn btn-dark btn-sm">
                                Detail
                            </a>


                            {{-- Tombol Cetak Invoice --}}
                            <a
                                href="{{ route('orders.invoice', $order->id) }}"
                                target="_blank"
                                class="btn btn-secondary btn-sm">
                                Cetak Invoice
                            </a>


                            {{-- Tombol Beri Ulasan --}}
                            @if($order->status === 'selesai')

                            <a
                                href="{{ route('reviews.create', $order->id) }}"
                                class="btn btn-success btn-sm">
                                Beri Ulasan
                            </a>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center">
                            Belum ada pesanan
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<div class="text-center mt-4">

    <strong>
        Total Pesanan:
        {{ $orders->count() }}
    </strong>

    <span class="mx-2">|</span>

    <strong>
        Total Belanja:
        Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
    </strong>

</div>


<script>
    document.getElementById('searchOrder').addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();

        let rows = document.querySelectorAll('.order-row');

        rows.forEach(function(row) {

            let order = row.getAttribute('data-search');

            if (order.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }

        });

    });


    document.getElementById('filterStatus').addEventListener('change', function() {

        let status = this.value;

        let rows = document.querySelectorAll('.order-row');

        rows.forEach(function(row) {

            let rowStatus = row.getAttribute('data-status');

            if (status === '' || rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }

        });

    });
</script>

@endsection