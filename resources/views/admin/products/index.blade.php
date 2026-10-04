@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="catalog-page">

    {{-- Header --}}
    <div class="catalog-header">

        <div class="catalog-title">

            <h1>Manajemen Katalog Produk</h1>

            <p>
                Kelola ketersediaan, kategori, dan presentasi produk toko
            </p>

        </div>

        <div class="catalog-header-actions">

            <div class="catalog-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="productSearch"
                    placeholder="Cari nama cookies, brownies...">

            </div>


            <a
                href="{{ route('admin.products.create') }}"
                class="add-product-button">
                <i class="bi bi-plus-lg"></i>
                Tambah Produk
            </a>

        </div>

    </div>


    <div class="catalog-body">

        {{-- Konten utama --}}
        <div class="catalog-main">

            {{-- Kategori --}}
            <div class="category-filter">

                <button type="button" class="category-button active" data-category="all">
                    <strong>Semua Produk</strong>
                    <span>({{ $totalProducts }})</span>
                </button>

                @foreach($categories as $category)
                <button type="button" class="category-button" data-category="{{ $category->nama_kategori }}">
                    <strong>{{ $category->nama_kategori }}</strong>
                    <span>({{ $category->products_count }})</span>
                </button>
                @endforeach

            </div>

            {{-- Produk --}}
            <div class="product-list" id="productList">

                @forelse($products as $product)

                <div
                    class="product-row"
                    data-name="{{ strtolower($product->nama_kue) }}"
                    data-category="{{ $product->category->nama_kategori ?? '' }}">

                    {{-- Foto --}}
                    <div class="product-image">

                        @if($product->gambar)

                        <img
                            src="{{ asset('storage/products/' . $product->gambar) }}"
                            alt="{{ $product->nama_kue }}">

                        @else

                        <div class="product-image-empty">
                            <i class="bi bi-cake2"></i>
                        </div>

                        @endif

                    </div>


                    {{-- Informasi --}}
                    <div class="product-name-area">

                        <div class="product-status">

                            @if($product->stok > 5)

                            <span class="status-active">
                                <i class="bi bi-check-circle-fill"></i>
                                Aktif
                            </span>

                            @else

                            <span class="status-low">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Menipis
                            </span>

                            @endif

                        </div>


                        <span class="product-category">
                            {{ $product->category->nama_kategori ?? 'Cookies' }}
                        </span>


                        <h3>
                            {{ $product->nama_kue }}
                        </h3>


                        <p>
                            {{ \Illuminate\Support\Str::limit($product->deskripsi ?? 'Classic artisan bakery product...', 25) }}
                        </p>

                    </div>


                    {{-- SKU --}}
                    <div class="product-sku">
                        <span>SKU:</span>
                        <strong>
                            CK-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}
                        </strong>

                    </div>


                    {{-- Harga --}}
                    <div class="product-price">

                        <span>
                            HARGA
                        </span>

                        <strong>
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </strong>

                    </div>


                    {{-- Stok --}}
                    @php
                    $stokClass = $product->stok <= 5 ? 'stock-bar-low' : 'stock-bar-normal' ;
                        $stokWidth=min(($product->stok / 30) * 100, 100);
                        @endphp

                        <div class="product-stock">

                            @if($product->stok <= 5)
                                <span class="stock-label stock-warning">
                                STOK MENIPIS
                                </span>
                                @else
                                <span class="stock-label">
                                    STOK TOKO
                                </span>
                                @endif

                                <div class="stock-value">
                                    <strong>
                                        {{ $product->stok }} pcs
                                    </strong>
                                </div>

                                <span
                                    class="{{ $stokClass }}"
                                    @style(['width'=> $stokWidth . '%'])
                                    ></span>

                        </div>


                        {{-- Aksi --}}
                        <div class="product-actions">

                            <a
                                href="{{ route('admin.products.edit', $product->id) }}"
                                class="edit-product-button">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>


                            <a
                                href="{{ route('admin.products.show', $product->id) }}"
                                class="icon-product-button"
                                title="Lihat Produk">
                                <i class="bi bi-eye"></i>
                            </a>


                            <form
                                action="{{ route('admin.products.destroy', $product->id) }}"
                                method="POST"
                                class="product-delete-form"
                                onsubmit="return confirm('Yakin hapus produk {{ $product->nama_kue }}?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="icon-product-button delete-button"
                                    title="Hapus Produk">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>


                        </div>

                </div>

                @empty

                <div class="empty-product">

                    <i class="bi bi-box-seam"></i>

                    <h3>
                        Belum ada produk
                    </h3>

                    <p>
                        Tambahkan produk pertama ke katalog SweetBites.
                    </p>

                    <a
                        href="{{ route('products.create') }}"
                        class="add-product-button">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Produk
                    </a>

                </div>

                @endforelse

            </div>

        </div>


        {{-- Sidebar kanan --}}
        <aside class="catalog-summary">

            {{-- Tips --}}
            <section class="catalog-tip">

                <div class="tip-heading">

                    <i class="bi bi-lightbulb-fill"></i>

                    <strong>
                        TIPS ETALASE CANTIK
                    </strong>

                </div>


                <p>
                    Foto beresolusi tinggi dengan pencahayaan natural
                    meningkatkan konversi pembelian hingga 42%.
                    Pastikan stok harian diperbarui sebelum jam buka cafe
                    (08:00 WIB).
                </p>

            </section>

        </aside>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const searchInput = document.getElementById('productSearch');

        const productRows = document.querySelectorAll('.product-row');

        const categoryButtons =
            document.querySelectorAll('.category-button');


        /* Search */

        searchInput.addEventListener('input', function() {

            const searchValue =
                this.value.toLowerCase().trim();

            productRows.forEach(function(row) {

                const productName =
                    row.dataset.name;

                if (productName.includes(searchValue)) {

                    row.style.display = '';

                } else {

                    row.style.display = 'none';

                }

            });

        });


        /* Category */

        categoryButtons.forEach(function(button) {

            button.addEventListener('click', function() {

                categoryButtons.forEach(function(item) {
                    item.classList.remove('active');
                });

                this.classList.add('active');

                const category =
                    this.dataset.category;

                productRows.forEach(function(row) {

                    const productCategory =
                        row.dataset.category;

                    if (
                        category === 'all' ||
                        productCategory === category
                    ) {

                        row.style.display = '';

                    } else {

                        row.style.display = 'none';

                    }

                });

            });

        });


        /* View */

        const tableButton =
            document.getElementById('tableViewButton');

        const gridButton =
            document.getElementById('gridViewButton');


        tableButton.addEventListener('click', function() {

            productRows.forEach(function(row) {

                row.classList.remove('grid-product');

            });

            tableButton.classList.add('active');
            gridButton.classList.remove('active');

        });


        gridButton.addEventListener('click', function() {

            productRows.forEach(function(row) {

                row.classList.add('grid-product');

            });

            gridButton.classList.add('active');
            tableButton.classList.remove('active');

        });

    });
</script>
@endsection