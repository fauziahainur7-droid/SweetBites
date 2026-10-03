@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')

<div class="cart-page">

    <h1 class="text-center cart-title">Shoping Cart</h1>
    <div class="cart-breadcrumb">
        <a href="{{ route('home') }}">SweetBites Home</a>
        <span>/</span>
        <span>Shopping Cart</span>
    </div>

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
                                <div class="cart-qty">
                                    <button type="button" class="qty-btn qty-minus" data-id="{{ $cart->id }}">−</button>
                                    <input type="number"
                                        class="qty-input"
                                        data-id="{{ $cart->id }}"
                                        value="{{ $cart->jumlah }}"
                                        min="1"
                                        max="{{ $cart->product->stok }}">
                                    <button type="button" class="qty-btn qty-plus" data-id="{{ $cart->id }}">+</button>
                                </div>

                                {{-- Form tersembunyi buat auto-submit --}}
                                <form action="{{ route('cart.update', $cart->id) }}"
                                    method="POST"
                                    class="cart-update-form-{{ $cart->id }}"
                                    style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="jumlah" value="{{ $cart->jumlah }}">
                                </form>
                            </td>
                            <td>
                                <strong>
                                    Rp{{ number_format($cart->product->harga * $cart->jumlah, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                {{-- Form hapus (berdiri sendiri, tidak nested) --}}
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

        <div class="cart-right">

            <div class="cart-trust-card">
                <h3>Kenapa Belanja di Sini?</h3>

                {{-- Trust item 1 --}}
                <div class="trust-item">
                    <div class="trust-icon">
                        <img src="{{ asset('images/icons/pengiriman.png') }}" alt="Gratis Ongkir">
                    </div>
                    <div class="trust-text">
                        <strong>Gratis Ongkir</strong>
                        <small>Min. pembelian Rp100.000</small>
                    </div>
                </div>

                {{-- Trust item 2 --}}
                <div class="trust-item">
                    <div class="trust-icon">
                        <img src="{{ asset('images/icons/pembayaran.png') }}" alt="Pembayaran Aman">
                    </div>
                    <div class="trust-text">
                        <strong>Pembayaran Aman</strong>
                        <small>Transfer, COD, QRIS</small>
                    </div>
                </div>

                {{-- Trust item 3 --}}
                <div class="trust-item">
                    <div class="trust-icon">
                        <img src="{{ asset('images/icons/pilih-kue.png') }}" alt="Fresh Setiap Hari">
                    </div>
                    <div class="trust-text">
                        <strong>Fresh Setiap Hari</strong>
                        <small>Dibuat saat dipesan</small>
                    </div>
                </div>

                <hr class="cart-divider">

                <div class="cart-actions-buttons">
                    <a href="{{ route('checkout.index') }}" class="btn-checkout">
                        <i class="bi bi-bag-check"></i>
                        Checkout
                    </a>
                    <a href="{{ route('catalog') }}" class="btn-back-shop-dark">
                        Kembali
                    </a>
                </div>

            </div>

        </div>

    </div>

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
            if (val > 1) {
                input.value = val - 1;
                autoUpdate(input);
            }
        });

        plusBtn.addEventListener('click', function () {
            let val = parseInt(input.value) || 1;
            let max = parseInt(input.getAttribute('max')) || 999;
            if (val < max) {
                input.value = val + 1;
                autoUpdate(input);
            }
        });

        input.addEventListener('change', function () {
            autoUpdate(input);
        });
    });

    function autoUpdate(input) {
        const id = input.getAttribute('data-id');
        const form = document.querySelector('.cart-update-form-' + id);
        const hiddenInput = form.querySelector('input[name="jumlah"]');
        hiddenInput.value = input.value;
        form.submit();
    }
});
</script>

@endsection