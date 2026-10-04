@extends('layouts.app')

@section('title', 'Katalog')

@section('content')

<section class="katalog-section">

    <div class="container">

        <!-- HEADER -->
        <div class="katalog-heading">

            <span class="katalog-label">
                SWEETBITES PÂTISSERIE & COOKIES BAR
            </span>

            <h1 class="katalog-title">
                Katalog Kue
            </h1>

            <p class="katalog-subtitle">
                Temukan berbagai pilihan kue favorit SweetBites
                yang dibuat fresh dengan bahan berkualitas.
            </p>

        </div>


        <!-- PENCARIAN -->
        <div class="katalog-filter-box">

            <div class="katalog-search-wrapper">

                <input
                    type="text"
                    class="katalog-search"
                    placeholder="Cari kue favoritmu...">

            </div>


            <select class="katalog-select">

                <option>Semua Kategori</option>

                <option>Cookies</option>

                <option>Brownies</option>

                <option>Pastry</option>

                <option>Dessert Box</option>

                <option>Cupcake</option>

            </select>


            <button type="button" class="katalog-btn">
                Cari
            </button>


            <button type="button"
                class="katalog-btn katalog-btn-reset">
                Reset
            </button>

        </div>


        <!-- PRODUK -->
        <div class="katalog-grid">

            @foreach($products as $product)

            <div class="katalog-card">

                <!-- GAMBAR -->
                <div class="katalog-image">
                    @if($product->gambar)
                    <img
                        src="{{ asset('storage/products/' . $product->gambar) }}"
                        alt="{{ $product->nama_kue }}">
                    @else
                    <img
                        src="{{ asset('images/no-image.png') }}"
                        alt="Tidak ada gambar">
                    @endif
                </div>


                <!-- ISI -->
                <div class="katalog-body">

                    <h3 class="katalog-nama">
                        {{ $product->nama_kue }}
                    </h3>


                    <p class="katalog-desc">
                        {{ $product->deskripsi }}
                    </p>


                    <!-- FOOTER -->
                    <div class="katalog-footer">

                        <span class="katalog-harga">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </span>


                        <div class="katalog-actions">

                            <!-- DETAIL -->
                            <a
                                href="{{ route('products.show', $product->id) }}"
                                class="katalog-btn-detail">
                                Detail
                            </a>


                            <!-- KERANJANG -->
                            <form
                                action="{{ route('cart.store') }}"
                                method="POST"
                                class="katalog-cart-form">

                                @csrf

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="{{ $product->id }}">

                                <input
                                    type="hidden"
                                    name="jumlah"
                                    value="1">

                                <button
                                    type="submit"
                                    class="katalog-btn-keranjang">
                                    Keranjang
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>


        <!-- PAGINATION -->
        <div class="katalog-pagination">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>

    </div>

</section>

@endsection