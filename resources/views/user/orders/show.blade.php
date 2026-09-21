@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">
    ← Kembali
</a>

{{-- DETAIL PESANAN --}}
<div class="card">

    <div class="card-body">

        <h3>Detail Pesanan</h3>

        <p>
            <strong>Kode:</strong>
            {{ $order->kode_pesanan }}
        </p>

        <p>
            <strong>Status:</strong>

            @if($order->status === 'selesai')

                <span class="badge bg-success">
                    Selesai
                </span>

            @elseif($order->status === 'batal')

                <span class="badge bg-danger">
                    Dibatalkan
                </span>

            @elseif($order->status === 'diproses')

                <span class="badge bg-primary">
                    Diproses
                </span>

            @elseif($order->status === 'siap')

                <span class="badge bg-info text-dark">
                    Siap Diambil/Dikirim
                </span>

            @else

                <span class="badge bg-warning text-dark">
                    Menunggu
                </span>

            @endif

        </p>

        <p>
            <strong>Alamat:</strong>
            {{ $order->alamat_pengirim }}
        </p>

        <p>
            <strong>Total:</strong>
            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
        </p>

        <p>
            <strong>Metode Pembayaran:</strong>
            {{ $order->metode_pembayaran }}
        </p>

        <hr>

        {{-- INFORMASI PEMBAYARAN --}}

        @if($order->metode_pembayaran === 'COD')

            {{-- COD --}}
            <div class="alert alert-info">

                <strong>Pembayaran COD</strong>

                <p class="mb-0 mt-1">
                    Pembayaran dilakukan saat pesanan diterima.
                    Tidak perlu upload bukti pembayaran.
                </p>

            </div>


        @elseif($order->payment)

            {{-- SUDAH ADA PEMBAYARAN --}}

            @if($order->payment->status === 'menunggu')

                <div class="alert alert-warning">

                    <strong>
                        Bukti pembayaran sedang diperiksa.
                    </strong>

                    <p class="mb-0 mt-1">
                        Silakan tunggu verifikasi dari admin.
                    </p>

                </div>


            @elseif($order->payment->status === 'verifikasi')

                <div class="alert alert-primary">

                    <strong>
                        Pembayaran sedang diverifikasi.
                    </strong>

                    <p class="mb-0 mt-1">
                        Admin sedang memeriksa bukti pembayaran kamu.
                    </p>

                </div>


            @elseif($order->payment->status === 'lunas')

                <div class="alert alert-success">

                    <strong>
                        Pembayaran sudah lunas.
                    </strong>

                    <p class="mb-0 mt-1">
                        Pembayaran kamu sudah diverifikasi oleh admin.
                        Pesanan sedang diproses oleh SweetBites.
                    </p>

                </div>


            @elseif($order->payment->status === 'gagal')

                <div class="alert alert-danger">

                    <strong>
                        Pembayaran ditolak.
                    </strong>

                    <p class="mb-0 mt-1">
                        Bukti pembayaran tidak dapat diverifikasi.
                        Silakan hubungi admin untuk informasi lebih lanjut.
                    </p>

                </div>

            @endif


        @elseif($order->status === 'menunggu')

            {{-- BELUM UPLOAD BUKTI --}}

            <div class="alert alert-warning">

                <strong>
                    Pembayaran belum dilakukan.
                </strong>

                <p class="mb-0 mt-1">
                    Silakan upload bukti pembayaran.
                </p>

            </div>

            <form
                action="{{ route('payments.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="mt-3"
            >

                @csrf

                <input
                    type="hidden"
                    name="order_id"
                    value="{{ $order->id }}"
                >

                <input
                    type="hidden"
                    name="metode_pembayaran"
                    value="{{ $order->metode_pembayaran }}"
                >

                <input
                    type="hidden"
                    name="total_bayar"
                    value="{{ $order->total_harga }}"
                >

                <div class="row">

                    <div class="col-md-8">

                        <label class="form-label">
                            Upload Bukti Pembayaran
                        </label>

                        <input
                            type="file"
                            name="bukti_pembayaran"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg"
                            required
                        >

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-dark w-100"
                        >
                            Upload Bukti
                        </button>

                    </div>

                </div>

            </form>

        @endif


        <hr>

        {{-- BATALKAN PESANAN --}}

        @if($order->status === 'menunggu')

            <form
                action="{{ route('orders.cancel', $order->id) }}"
                method="POST"
                class="d-inline"
                onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    Batalkan Pesanan
                </button>

            </form>

        @endif


        {{-- CETAK INVOICE --}}

        @if($order->status === 'selesai')

            <a
                href="{{ route('orders.invoice', $order->id) }}"
                target="_blank"
                class="btn btn-dark"
            >
                Cetak Invoice
            </a>

        @endif

    </div>

</div>


{{-- ITEM PESANAN --}}

<div class="card mt-3">

    <div class="card-header">
        Item Pesanan
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table">

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

                    @forelse($order->orderDetails as $detail)

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

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center"
                            >
                                Tidak ada item
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection