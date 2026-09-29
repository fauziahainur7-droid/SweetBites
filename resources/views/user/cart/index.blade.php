@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')

<div class="cart-page">

    <h1 class="text-center cart-title">Shoping Cart</h1>

    <form action="{{ route('checkout.index') }}" method="GET">
        <div class="cart-layout">

            {{-- KIRI: DAFTAR PRODUK --}}
            <div class="cart-left">

                <div class="cart-table-wrapper">
                    <table class="cart-table">
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
                            @forelse($carts as $i => $cart)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <div class="cart-product">
                                            <img src="{{ asset('images/' . $cart->product->gambar) }}"
                                                 alt="{{ $cart->product->nama_kue }}"
                                                 class="cart-product-img">
                                            <div>
                                                <strong>{{ $cart->product->nama_kue }}</strong>
                                                <small>{{ $cart->product->category->nama_kategori ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp{{ number_format($cart->product->harga, 0, ',', '.') }}</td>
                                    <td>
                                        {{-- Form update jumlah --}}
                                        <form action="{{ route('cart.update', $cart->id) }}"
                                              method="POST"
                                              class="cart-qty-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="cart-qty">
                                                <button type="button" class="qty-btn qty-minus">−</button>
                                                <input type="number"
                                                       name="jumlah"
                                                       value="{{ $cart->jumlah }}"
                                                       min="1"
                                                       max="{{ $cart->product->stok }}"
                                                       class="qty-input">
                                                <button type="button" class="qty-btn qty-plus">+</button>
                                            </div>
                                            <button type="submit" class="qty-update-btn">Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <strong>
                                            Rp{{ number_format($cart->product->harga * $cart->jumlah, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td>
                                        {{-- Form hapus (method DELETE) --}}
                                        <form action="{{ route('cart.destroy', $cart->id) }}"
                                              method="POST"
                                              class="cart-remove-form"
                                              onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-remove-x"
                                                    title="Hapus produk">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="cart-empty">
                                        <i class="bi bi-cart-x" style="font-size: 48px; color: var(--gray-text);"></i>
                                        <p>Keranjang kamu masih kosong</p>
                                        <a href="{{ route('catalog') }}" class="btn-shop-now">Mulai Belanja</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($carts->count() > 0)
                    @php
                        $total = $carts->sum(fn($c) => $c->product->harga * $c->jumlah);
                    @endphp

                    {{-- Total di kiri bawah tabel --}}
                    <div class="cart-total-left">
                        <span>Total</span>
                        <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                @endif

            </div>

            {{-- KANAN: INFORMASI PEMESANAN--}}
            <div class="cart-right">

                <div class="cart-info-card">
                    <h3>Informasi Pemesanan</h3>

                    {{-- Alamat Pengiriman --}}
                    <div class="form-group">
                        <label>Alamat Pengiriman</label>
                        <textarea name="alamat"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Tulis alamat lengkap pengiriman..."
                                  required>{{ old('alamat', auth()->user()->alamat ?? '') }}</textarea>
                    </div>

                    {{-- Metode Pengiriman --}}
                    <div class="form-group">
                        <label>Metode Pengiriman</label>
                        <select name="metode_pengiriman" class="form-control" required>
                            <option value="">-- Pilih Metode Pengiriman --</option>
                            <option value="ambil_di_toko" {{ old('metode_pengiriman') == 'ambil_di_toko' ? 'selected' : '' }}>
                                Ambil di Toko 
                            </option>
                            <option value="jne" {{ old('metode_pengiriman') == 'jne' ? 'selected' : '' }}>
                                Dikirim Tim SwettBites
                            </option>
                        </select>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control" required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="transfer_bca" {{ old('metode_pembayaran') == 'transfer_bca' ? 'selected' : '' }}>
                                Bank Transfer (BCA / Mandiri / BRI)
                            </option>
                            <option value="transfer_mandiri" {{ old('metode_pembayaran') == 'transfer_mandiri' ? 'selected' : '' }}>
                                E-Wallet (OVO / Gopay / DANA)
                            </option>
                            <option value="cod" {{ old('metode_pembayaran') == 'cod' ? 'selected' : '' }}>
                                COD (Bayar di Tempat)
                            </option>
                        </select>
                    </div>

                    {{-- Divider --}}
                    <hr class="cart-divider">

                    {{-- Tombol Aksi --}}
                    <div class="cart-actions-buttons">
                        <button type="submit"
                                class="btn-checkout"
                                {{ $carts->count() == 0 ? 'disabled' : '' }}>
                            Lanjut ke Checkout
                        </button>

                        <a href="{{ route('catalog') }}" class="btn-back-shop-dark">
                            Kembali Belanja
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </form>

</div>

{{-- Script tombol + / − --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cart-qty').forEach(function (wrapper) {
        const minusBtn = wrapper.querySelector('.qty-minus');
        const plusBtn = wrapper.querySelector('.qty-plus');
        const input = wrapper.querySelector('.qty-input');

        minusBtn.addEventListener('click', function () {
            let val = parseInt(input.value) || 1;
            if (val > 1) input.value = val - 1;
        });

        plusBtn.addEventListener('click', function () {
            let val = parseInt(input.value) || 1;
            let max = parseInt(input.getAttribute('max')) || 999;
            if (val < max) input.value = val + 1;
        });
    });
});
</script>


@endsection