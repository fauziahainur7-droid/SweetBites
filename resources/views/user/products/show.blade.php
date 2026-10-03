@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

<div class="detail-page">

    {{-- Kembali ke katalog --}}
    <a href="{{ route('catalog') }}" class="detail-back">
        <span>&lsaquo;</span>
        Kembali ke Katalog
    </a>

    {{-- Kartu utama detail produk --}}
    <section class="detail-card">

        {{-- Kolom kiri: foto produk --}}
        <div class="detail-left">

            <div class="detail-image">
                @if($product->gambar)
                    <img
                        src="{{ asset('storage/products/' . $product->gambar) }}"
                        alt="{{ $product->nama_kue }}"
                    >
                @else
                    <div class="detail-no-image">
                        <span>SweetBites</span>
                        <p>Foto produk belum tersedia</p>
                    </div>
                @endif
            </div>

            <div class="detail-fresh-note">
                <span class="fresh-dot"></span>
                Dipanggang Segar Hari Ini
            </div>

        </div>

        {{-- Kolom kanan: informasi produk --}}
        <div class="detail-right">

            <span class="detail-category">
                {{ $product->category->nama_kategori ?? 'KUE ARTISAN' }}
            </span>

            <h1 class="detail-title">
                {{ $product->nama_kue }}
            </h1>

            <div class="detail-rating">
                <span class="rating-stars">★★★★★</span>
                <strong>
                    {{ number_format($reviews->count() > 0 ? $reviews->avg('rating') : 0, 1) }}
                </strong>
                <span class="rating-count">
                    ({{ $reviews->count() }} ulasan)
                </span>
            </div>

            <div class="detail-price">
                Rp {{ number_format($product->harga, 0, ',', '.') }}
                <span>/ pack</span>
            </div>

            <p class="detail-description">
                {{ $product->deskripsi ?: 'Dibuat segar setiap hari menggunakan bahan pilihan untuk menghadirkan rasa manis di setiap momen.' }}
            </p>

            {{-- Stok --}}
            <div class="detail-stock">
               <span class="stock-dot {{ $product->stok <= 0 ? 'stock-empty' : '' }}"></span>
                <span>
                    @if($product->stok > 0)
                        Stok tersedia:
                        <strong>{{ $product->stok }}</strong> pack
                    @else
                        <strong>Stok habis</strong>
                    @endif
                </span>
            </div>

            {{-- Form pembelian --}}
            @auth

                @php
                    $isAdmin = \App\Models\Admin::where(
                        'email',
                        auth()->user()->email
                    )->exists();
                @endphp

                @if(!$isAdmin)

                    @if($product->stok > 0)

                        <form
                            action="{{ route('cart.store') }}"
                            method="POST"
                            class="detail-cart-form"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="product_id"
                                value="{{ $product->id }}"
                            >

                            <div class="quantity-control">
                                <button
                                    type="button"
                                    class="quantity-btn"
                                    onclick="ubahJumlah(-1)"
                                    aria-label="Kurangi jumlah"
                                >−</button>

                                <input
                                    type="number"
                                    id="jumlahProduk"
                                    name="jumlah"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stok }}"
                                    aria-label="Jumlah produk"
                                    required
                                >

                                <button
                                    type="button"
                                    class="quantity-btn"
                                    onclick="ubahJumlah(1)"
                                    aria-label="Tambah jumlah"
                                >+</button>
                            </div>

                            <button type="submit" class="detail-cart-btn">
                                <span>🛍</span>
                                Tambah ke Keranjang
                            </button>

                        </form>

                    @else

                        <button class="detail-cart-btn" disabled>
                            Stok Habis
                        </button>

                    @endif

                @else

                    <div class="detail-admin-note">
                        Akun admin tidak dapat melakukan pembelian.
                    </div>

                @endif

            @else

                <a href="{{ route('login') }}" class="detail-cart-btn detail-login-btn">
                    Login untuk Beli
                </a>

            @endauth

            {{-- Informasi layanan --}}
            <div class="detail-benefits">

                <div class="benefit-item">
                    <span class="benefit-icon">◷</span>

                    <div>
                        <strong>Pengiriman Instan &amp; Sameday</strong>
                        <p>Praktis untuk menemani momen spesialmu.</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <span class="benefit-icon">♧</span>

                    <div>
                        <strong>Kemasan Higienis &amp; Aman</strong>
                        <p>Dikemas rapi untuk menjaga kualitas kue.</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    {{-- Ulasan pelanggan --}}
    <section class="customer-reviews">

        <div class="reviews-heading">
            <h2>Ulasan Pelanggan</h2>

            <span>
                {{ $reviews->count() }} ulasan terbaru
            </span>
        </div>

        @if($reviews->count() > 0)

            @foreach($reviews as $review)

                <article class="review-card">

                    <div class="review-top">

                        <div class="review-user">

                            <div class="review-avatar">
                                {{ strtoupper(substr($review->user->name ?? 'P', 0, 1)) }}
                            </div>

                            <div>
                                <h3>
                                    {{ $review->user->name ?? 'Pelanggan' }}
                                </h3>

                                <p>
                                    Pembeli Terverifikasi
                                    &bull;
                                    {{ $review->created_at->format('d/m/Y') }}
                                </p>
                            </div>

                        </div>

                        <div class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span>★</span>
                                @else
                                    <span>☆</span>
                                @endif
                            @endfor
                        </div>

                    </div>

                    @if($review->komentar)

                        <p class="review-comment">
                            “{{ $review->komentar }}”
                        </p>

                    @endif

                </article>

            @endforeach

        @else

            <div class="review-empty">
                <span>♡</span>
                <h3>Belum ada ulasan</h3>
                <p>
                    Jadilah pelanggan pertama yang memberikan ulasan
                    untuk produk ini.
                </p>
            </div>

        @endif

    </section>

</div>

<script>
    function ubahJumlah(perubahan) {
        const input = document.getElementById('jumlahProduk');

        if (!input) return;

        const minimum = Number(input.min) || 1;
        const maksimum = Number(input.max) || 1;
        const jumlahSekarang = Number(input.value) || minimum;

        input.value = Math.max(
            minimum,
            Math.min(maksimum, jumlahSekarang + perubahan)
        );
    }
</script>

@endsection