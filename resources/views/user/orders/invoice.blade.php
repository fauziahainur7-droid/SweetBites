@extends('layouts.app')

@section('title', 'Invoice Pesanan')

@section('content')

<div class="container mt-4 mb-5">

    <div class="card">

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-6">

                    <h2 class="fw-bold">
                        SweetBites
                    </h2>

                    <p class="mb-0">
                        Toko Kue SweetBites
                    </p>

                    <p>
                        Bukti Pembelian
                    </p>

                </div>

                <div class="col-md-6 text-end">

                    <h4>
                        INVOICE
                    </h4>

                    <p class="mb-0">
                        {{ $order->kode_pesanan }}
                    </p>

                    <p>
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>

                </div>

            </div>

            <hr>


            <div class="row mb-4">

                <div class="col-md-6">

                    <strong>Pelanggan</strong>

                    <p class="mb-0">
                        {{ $order->user->name }}
                    </p>

                    <p class="mb-0">
                        {{ $order->user->email }}
                    </p>

                    <p>
                        {{ $order->user->no_hp }}
                    </p>

                </div>


                <div class="col-md-6">

                    <strong>Alamat Pengiriman</strong>

                    <p>
                        {{ $order->alamat_pengirim }}
                    </p>

                </div>

            </div>


            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($order->orderDetails as $detail)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $detail->product->nama_kue ?? '-' }}
                            </td>

                            <td>
                                {{ $detail->jumlah }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


            <div class="row mt-4">

                <div class="col-md-7">

                    <p>
                        <strong>Metode Pembayaran:</strong>
                        {{ $order->metode_pembayaran }}
                    </p>

                    <p>
                        <strong>Metode Pengiriman:</strong>
                        {{ $order->metode_pengiriman }}
                    </p>

                    <p>
                        <strong>Status:</strong>

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

                    </p>

                </div>


                <div class="col-md-5">

                    <div class="border p-3">

                        <h5>
                            Total Pembayaran
                        </h5>

                        <h3>
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </h3>

                    </div>

                </div>

            </div>


            <hr>


            <div class="text-center mt-4">

                <p>
                    Terima kasih telah berbelanja di SweetBites.
                </p>

                <button
                    onclick="window.print()"
                    class="btn btn-dark"
                >
                    Cetak Invoice
                </button>

                <a
                    href="{{ route('orders.show', $order->id) }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </div>

    </div>

</div>


<style>

@media print {

    nav,
    .navbar,
    button,
    a {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .card {
        border: none !important;
    }

}

</style>

@endsection