@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

<a href="{{ route('admin.orders.index') }}"
   class="btn btn-secondary mb-3">
    ← Kembali
</a>

<div class="card">

    <div class="card-body">

        <h2>Detail Pesanan</h2>

        <p>
            <strong>Kode:</strong>
            {{ $order->kode_pesanan }}
        </p>

        <p>
            <strong>Pelanggan:</strong>
            {{ $order->user->name ?? '-' }}
        </p>

        <p>
            <strong>Alamat:</strong>
            {{ $order->alamat_pengirim }}
        </p>

        <p>
            <strong>Metode Pengiriman:</strong>
            {{ $order->metode_pengiriman }}
        </p>

        <p>
            <strong>Metode Pembayaran:</strong>
            {{ $order->metode_pembayaran }}
        </p>

        <p>
            <strong>Total:</strong>
            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
        </p>

        <p>
            <strong>Status Pesanan:</strong>

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
                    Siap
                </span>

            @else

                <span class="badge bg-warning text-dark">
                    Menunggu
                </span>

            @endif

        </p>

        <form
            action="{{ route('admin.orders.update', $order->id) }}"
            method="POST"
            class="mt-3"
        >

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-5">

                    <label class="form-label">
                        Status Pesanan
                    </label>

                    <select
                        name="status"
                        class="form-control"
                        required
                    >

                        <option
                            value="menunggu"
                            {{ $order->status === 'menunggu' ? 'selected' : '' }}
                        >
                            Menunggu
                        </option>

                        <option
                            value="diproses"
                            {{ $order->status === 'diproses' ? 'selected' : '' }}
                        >
                            Diproses
                        </option>

                        <option
                            value="siap"
                            {{ $order->status === 'siap' ? 'selected' : '' }}
                        >
                            Siap
                        </option>

                        <option
                            value="selesai"
                            {{ $order->status === 'selesai' ? 'selected' : '' }}
                        >
                            Selesai
                        </option>

                        <option
                            value="batal"
                            {{ $order->status === 'batal' ? 'selected' : '' }}
                        >
                            Batal
                        </option>

                    </select>

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-dark"
                    >
                        Update
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- INFORMASI PEMBAYARAN --}}

<div class="card mt-3">

    <div class="card-header">
        <strong>Informasi Pembayaran</strong>
    </div>

    <div class="card-body">

        @if($order->metode_pembayaran === 'COD')

            <div class="alert alert-info mb-0">

                <h5>
                    Pembayaran COD
                </h5>

                <p class="mb-0">
                    Pesanan ini menggunakan metode
                    <strong>Cash on Delivery (COD)</strong>.
                    Pembayaran dilakukan saat pesanan diterima.
                </p>

            </div>

        @elseif($order->payment)

            <p>
                <strong>Metode Pembayaran:</strong>
                {{ $order->payment->metode_pembayaran ?? $order->metode_pembayaran }}
            </p>

            <p>
                <strong>Total Bayar:</strong>
                Rp {{ number_format($order->payment->total_bayar, 0, ',', '.') }}
            </p>

            <p>
                <strong>Status Pembayaran:</strong>

                @if($order->payment->status === 'lunas')

                    <span class="badge bg-success">
                        Lunas
                    </span>

                @elseif($order->payment->status === 'verifikasi')

                    <span class="badge bg-primary">
                        Verifikasi
                    </span>

                @elseif($order->payment->status === 'gagal')

                    <span class="badge bg-danger">
                        Gagal
                    </span>

                @else

                    <span class="badge bg-warning text-dark">
                        Menunggu
                    </span>

                @endif

            </p>

            <hr>

            <h2>
                Bukti Pembayaran
            </h2>

            @if($order->payment->bukti_pembayaran)

                <div class="mt-3">

                    <img
                        src="{{ route('admin.payments.proof', $order->payment->id) }}"
                        alt="Bukti Pembayaran"
                        class="img-fluid rounded border"
                        style="max-width: 600px;"
                    >

                </div>

            @else

                <div class="alert alert-secondary">
                    Belum ada bukti pembayaran.
                </div>

            @endif

            <hr>

            <h2>
                Verifikasi Pembayaran
            </h2>

            <form
                action="{{ route('admin.payments.update-status', $order->payment->id) }}"
                method="POST"
                class="mt-3"
            >

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-5">

                        <label class="form-label">
                            Status Pembayaran
                        </label>

                        <select
                            name="status"
                            class="form-control"
                            required
                        >

                            <option
                                value="menunggu"
                                {{ $order->payment->status === 'menunggu' ? 'selected' : '' }}
                            >
                                Menunggu
                            </option>

                            <option
                                value="verifikasi"
                                {{ $order->payment->status === 'verifikasi' ? 'selected' : '' }}
                            >
                                Verifikasi
                            </option>

                            <option
                                value="lunas"
                                {{ $order->payment->status === 'lunas' ? 'selected' : '' }}
                            >
                                Lunas
                            </option>

                            <option
                                value="gagal"
                                {{ $order->payment->status === 'gagal' ? 'selected' : '' }}
                            >
                                Gagal
                            </option>

                        </select>

                    </div>

                    <div class="col-md-3 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-dark"
                        >
                            Update Status
                        </button>

                    </div>

                </div>

            </form>

        @else

            <div class="alert alert-warning mb-0">
                Belum ada data pembayaran.
            </div>

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