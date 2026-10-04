@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="checkout-page">

    <h1 class="checkout-title">CHECKOUT</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="checkout-layout">

            {{-- KIRI: Form --}}
            <div class="checkout-left">

                {{-- Section: Alamat --}}
                <div class="checkout-section">
                    <h2 class="section-title">Alamat Pengiriman</h2>
                    <textarea name="alamat_pengirim"
                              rows="4"
                              class="form-control"
                              placeholder="Tulis alamat lengkap pengiriman..."
                              required>{{ old('alamat_pengirim', auth()->user()->alamat ?? '') }}</textarea>
                </div>

                {{-- Section: Metode Pengiriman --}}
                <div class="checkout-section">
                    <h2 class="section-title">Metode Pengiriman</h2>

                    <label class="radio-option">
                        <input type="radio" name="metode_pengiriman" value="Ambil Sendiri"
                               {{ old('metode_pengiriman') == 'Ambil Sendiri' ? 'checked' : '' }} required>
                        <span class="radio-content">
                            <span class="radio-title">Ambil Sendiri</span>
                            <span class="radio-desc">Ambil langsung di Purbalingga</span>
                        </span>
                        <span class="radio-price">Gratis</span>
                    </label>

                    <label class="radio-option">
                        <input type="radio" name="metode_pengiriman" value="Diantar"
                               {{ old('metode_pengiriman') == 'Diantar' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <span class="radio-title">Diantar</span>
                            <span class="radio-desc">Dikirim oleh kurir SweetBites</span>
                        </span>
                        <span class="radio-price">Gratis</span>
                    </label>
                </div>

                {{-- Section: Metode Pembayaran --}}
                <div class="checkout-section">
                    <h2 class="section-title">Metode Pembayaran</h2>

                    <label class="radio-option">
                        <input type="radio" name="metode_pembayaran" value="Bank Transfer"
                               {{ old('metode_pembayaran') == 'Bank Transfer' ? 'checked' : '' }} required>
                        <span class="radio-content">
                            <span class="radio-title">Transfer Bank</span>
                            <span class="radio-desc">BCA, Mandiri, atau BRI</span>
                        </span>
                    </label>

                    <label class="radio-option">
                        <input type="radio" name="metode_pembayaran" value="E-Wallet"
                               {{ old('metode_pembayaran') == 'E-Wallet' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <span class="radio-title">E-Wallet</span>
                            <span class="radio-desc">DANA, OVO, GoPay, atau ShopeePay</span>
                        </span>
                    </label>

                    <label class="radio-option">
                        <input type="radio" name="metode_pembayaran" value="COD"
                               {{ old('metode_pembayaran') == 'COD' ? 'checked' : '' }}>
                        <span class="radio-content">
                            <span class="radio-title">COD (Bayar di Tempat)</span>
                            <span class="radio-desc">Bayar saat pesanan tiba</span>
                        </span>
                    </label>
                </div>

                {{-- Tombol aksi --}}
                <div class="checkout-actions">
                    <button type="submit" class="btn-place-order">
                        <i class="bi bi-bag-check"></i>
                        Buat Pesanan
                    </button>

                    <a href="{{ route('cart.index') }}" class="btn-back-cart">
                        Kembali
                    </a>
                </div>

            </div>

            {{-- KANAN: Ringkasan --}}
            <div class="checkout-right">

                <div class="checkout-summary">
                    <h2 class="summary-title">Shopping Bag ({{ $carts->count() }})</h2>

                    <div class="summary-items">
                        @forelse($carts as $cart)
                            <div class="summary-item">
                                <div class="summary-item-info">
                                    <span class="summary-item-name">{{ $cart->product->nama_kue }}</span>
                                    <span class="summary-item-qty">x{{ $cart->jumlah }}</span>
                                </div>
                                <strong class="summary-item-price">
                                    Rp{{ number_format($cart->product->harga * $cart->jumlah, 0, ',', '.') }}
                                </strong>
                            </div>
                        @empty
                            <p class="summary-empty">Keranjang kosong</p>
                        @endforelse
                    </div>

                    <hr class="checkout-divider">

                    <div class="summary-total">
                        <span>Total</span>
                        <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>

                </div>

            </div>

        </div>
    </form>

</div>
@endsection