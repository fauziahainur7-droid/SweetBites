@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="container mt-4 mb-5">

    <h2 class="mb-4">
        Checkout
    </h2>

    {{-- PESANAN --}}
    <div class="row">

        {{-- FORM CHECKOUT --}}
        <div class="col-md-8">

            <div class="card">

                <div class="card-body">

                    <form
                        action="{{ route('orders.store') }}"
                        method="POST"
                    >

                        @csrf


                        {{-- ALAMAT --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Alamat Pengiriman
                            </label>

                            <textarea
                                name="alamat_pengirim"
                                class="form-control"
                                rows="3"
                                required
                            >{{ request('alamat') }}</textarea>

                        </div>


                        {{-- METODE PENGIRIMAN --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Metode Pengiriman
                            </label>

                            <div class="form-control bg-light">
                                {{ request('metode_pengiriman') }}
                            </div>

                            <input
                                type="hidden"
                                name="metode_pengiriman"
                                value="{{ request('metode_pengiriman') }}"
                            >

                        </div>


                        {{-- METODE PEMBAYARAN --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Metode Pembayaran
                            </label>

                            <div class="form-control bg-light">
                                {{ request('metode_pembayaran') }}
                            </div>

                            <input
                                type="hidden"
                                name="metode_pembayaran"
                                value="{{ request('metode_pembayaran') }}"
                            >

                        </div>


                        {{-- INFORMASI TAMBAHAN --}}
                        @if(request('metode_pengiriman') === 'Diantar')

                            <div class="alert alert-info">
                                Pesanan akan diantar ke alamat yang kamu masukkan.
                            </div>

                        @elseif(request('metode_pengiriman') === 'Ambil Sendiri')

                            <div class="alert alert-info">
                                Pesanan akan diambil sendiri di toko SweetBites.
                            </div>

                        @endif


                        {{-- TOMBOL --}}
                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn btn-dark"
                            >
                                Buat Pesanan
                            </button>

                            <a
                                href="{{ route('cart.index') }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- RINGKASAN --}}
        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    Ringkasan
                </div>

                <div class="card-body">

                    @php
                        $total = 0;
                    @endphp

                    @foreach($carts as $cart)

                        @php
                            $subtotal =
                                $cart->product->harga *
                                $cart->jumlah;

                            $total += $subtotal;
                        @endphp

                        <p>
                            {{ $cart->product->nama_kue }}
                            x{{ $cart->jumlah }}

                            =
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </p>

                    @endforeach

                    <hr>

                    <h5>
                        Total:
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </h5>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection