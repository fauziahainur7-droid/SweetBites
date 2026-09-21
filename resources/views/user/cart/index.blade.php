@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')

<div class="container mt-4 mb-5">

    <h2 class="mb-4">Keranjang Belanja</h2>

    {{-- PESANAN BERHASIL --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($carts->isEmpty())

        <div class="alert alert-secondary">
            Keranjang kamu masih kosong.
        </div>

        <a href="{{ route('catalog') }}" class="btn btn-dark">
            Belanja Sekarang
        </a>

    @else

        {{-- DAFTAR PRODUK --}}
        <div class="card mb-4">

            <div class="card-header">
                <strong>Daftar Produk</strong>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @php
                                $total = 0;
                            @endphp

                            @foreach($carts as $cart)

                                @php
                                    $subtotal = $cart->product->harga * $cart->jumlah;
                                    $total += $subtotal;
                                @endphp

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $cart->product->nama_kue }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($cart->product->harga, 0, ',', '.') }}
                                    </td>

                                    <td>

                                        <form
                                            action="{{ route('cart.update', $cart->id) }}"
                                            method="POST"
                                            class="d-flex"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="number"
                                                name="jumlah"
                                                value="{{ $cart->jumlah }}"
                                                min="1"
                                                max="{{ $cart->product->stok }}"
                                                class="form-control"
                                                style="width: 90px;"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-secondary ms-2"
                                            >
                                                Update
                                            </button>

                                        </form>

                                    </td>

                                    <td>
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>

                                    <td>

                                        <form
                                            action="{{ route('cart.destroy', $cart->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus produk ini dari keranjang?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="text-end mt-3">

                    <h4>
                        Total:
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- PILIHAN PESANAN --}}
        <div class="card">

            <div class="card-header">
                <strong>Informasi Pemesanan</strong>
            </div>

            <div class="card-body">

                <form
                    action="{{ route('checkout.index') }}"
                    method="GET"
                >

                    {{-- ALAMAT --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Alamat Pengiriman
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="3"
                            required
                        >{{ auth()->user()->alamat }}</textarea>

                    </div>


                    {{-- METODE PENGIRIMAN --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Metode Pengiriman
                        </label>

                        <select
                            name="metode_pengiriman"
                            id="metode_pengiriman"
                            class="form-control"
                            required
                        >

                            <option value="">
                                -- Pilih Metode Pengiriman --
                            </option>

                            <option value="Diantar">
                                Diantar
                            </option>

                            <option value="Ambil Sendiri">
                                Ambil Sendiri
                            </option>

                        </select>

                    </div>


                    {{-- METODE PEMBAYARAN --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Metode Pembayaran
                        </label>

                        <select
                            name="metode_pembayaran"
                            class="form-control"
                            required
                        >

                            <option value="">
                                -- Pilih Metode Pembayaran --
                            </option>

                            <option value="Bank Transfer">
                                Bank Transfer (BCA/Mandiri/BRI)
                            </option>

                            <option value="E-Wallet">
                                E-Wallet
                            </option>

                            <option value="COD">
                                COD (Bayar di Tempat)
                            </option>

                        </select>

                    </div>


                    {{-- TOMBOL --}}
                    <div class="mt-4">

                        <button
                            type="submit"
                            class="btn btn-dark"
                        >
                            Lanjut ke Checkout
                        </button>

                        <a
                            href="{{ route('catalog') }}"
                            class="btn btn-secondary"
                        >
                            Kembali Belanja
                        </a>

                    </div>

                </form>

            </div>

        </div>

    @endif

</div>

@endsection