@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')

<div class="container mt-4 mb-5">

    <div class="card">
        <div class="card-body p-4">

            <h2 class="text-center mb-4">
                Terima kasih telah berbelanja!
            </h2>

            <p>
                <strong>No. Pesanan:</strong>
                {{ $order->kode_pesanan }}
            </p>

            <p>
                <strong>Total:</strong>
                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
            </p>

            <p>
                <strong>Pengiriman:</strong>
                {{ $order->metode_pengiriman }}
            </p>

            <p>
                <strong>Pembayaran:</strong>
                {{ $order->metode_pembayaran }}
            </p>

            <p>
                <strong>Status:</strong>

                @if($order->metode_pembayaran === 'COD')

                    <span class="badge bg-success">
                        Pesanan Diproses
                    </span>

                @else

                    <span class="badge bg-warning text-dark">
                        Menunggu Pembayaran
                    </span>

                @endif
            </p>

            <hr>

            {{-- COD --}}

            @if($order->metode_pembayaran === 'COD')

                <div class="alert alert-success">

                    <h5>
                        Pesanan COD Berhasil!
                    </h5>

                    <p class="mb-0">
                        Pembayaran dilakukan saat pesanan
                        diterima. Tidak perlu melakukan transfer
                        atau mengunggah bukti pembayaran.
                    </p>

                </div>


            {{-- BANK TRANSFER --}}

            @elseif($order->metode_pembayaran === 'Bank Transfer')

                <div class="border p-3 mb-3">

                    <h4>
                        INSTRUKSI PEMBAYARAN
                    </h4>

                    <p>
                        Silakan lakukan transfer ke rekening berikut:
                    </p>

                    <p>
                        <strong>Bank BCA</strong><br>
                        1234567890<br>
                        a/n SweetBites
                    </p>

                    <p>
                        <strong>Total Transfer:</strong><br>

                        Rp {{ number_format(
                            $order->total_harga,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                    <p class="text-danger">
                        <strong>Batas Pembayaran:</strong>
                        24 Jam
                    </p>

                </div>

                <form
                    action="{{ route('payments.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
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

                    <div class="mb-3">

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

                    <button
                        type="submit"
                        class="btn btn-dark"
                    >
                        Kirim Bukti Pembayaran
                    </button>

                </form>

            {{-- E-WALLET --}}

            @elseif($order->metode_pembayaran === 'E-Wallet')

                <div class="border p-3 mb-3">

                    <h4>
                        INSTRUKSI PEMBAYARAN E-WALLET
                    </h4>

                    <p>
                        Silakan lakukan pembayaran menggunakan
                        salah satu E-Wallet berikut:
                    </p>

                    <p>
                        <strong>DANA</strong><br>
                        081234567890
                    </p>

                    <p>
                        <strong>OVO</strong><br>
                        081234567890
                    </p>

                    <p>
                        <strong>GoPay</strong><br>
                        081234567890
                    </p>

                    <p>
                        <strong>Total Pembayaran:</strong><br>

                        Rp {{ number_format(
                            $order->total_harga,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                    <p class="text-danger">
                        <strong>Batas Pembayaran:</strong>
                        24 Jam
                    </p>

                </div>

                <form
                    action="{{ route('payments.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
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

                    <div class="mb-3">

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

                    <button
                        type="submit"
                        class="btn btn-dark"
                    >
                        Kirim Bukti Pembayaran
                    </button>

                </form>

            @endif

            {{-- TOMBOL BAWAH --}}

            <div class="text-center mt-4">

                <a
                    href="{{ route('orders.show', $order->id) }}"
                    class="btn btn-secondary"
                >
                    Lihat Riwayat Pesanan
                </a>

                <a
                    href="{{ route('home') }}"
                    class="btn btn-outline-dark"
                >
                    Kembali ke Beranda
                </a>

            </div>

        </div>
    </div>

</div>

@endsection
