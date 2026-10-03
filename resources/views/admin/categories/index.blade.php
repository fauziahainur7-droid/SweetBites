@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="category-page">

    <!-- HEADER -->
    <div class="category-header">

        <div class="category-title">
            <h1>Manajemen Kategori</h1>

            <p>
                Kelola kategori produk SweetBites
            </p>
        </div>

        <div class="category-header-right">

            <!-- SEARCH -->
            <div class="category-search">

                <span>⌕</span>

                <input
                    type="text"
                    id="categorySearch"
                    placeholder="Cari nama kategori..."
                >

            </div>


            <!-- TAMBAH -->
            <a
                href="{{ route('admin.categories.create') }}"
                class="add-category-button"
            >
                + Tambah Kategori
            </a>

        </div>

    </div>


    <!-- CONTENT -->
    <main class="category-main">


        <!-- RINGKASAN -->
        <section class="category-summary">

            <div class="summary-title">
                RINGKASAN KATEGORI
            </div>


            <div class="summary-cards">

                <!-- TOTAL KATEGORI -->
                <div class="summary-card">

                    <div class="summary-label">
                        Total Kategori
                    </div>

                    <div class="summary-number">
                        {{ $categories->count() }}
                    </div>

                    <div class="summary-description">
                        Kategori tersedia
                    </div>

                </div>


                <!-- TOTAL PRODUK -->
                <div class="summary-card">

                    <div class="summary-label">
                        Total Produk
                    </div>

                    <div class="summary-number">
                        {{ $categories->sum('products_count') }}
                    </div>

                    <div class="summary-description">
                        Produk terdaftar
                    </div>

                </div>

            </div>

        </section>


        <!-- URUTKAN -->
        <div class="category-sort">

            <label for="sortCategory">
                Urutkan:
            </label>

            <select id="sortCategory">

                <option value="latest">
                    Terbaru Ditambahkan
                </option>

                <option value="name">
                    Nama Kategori
                </option>

                <option value="product">
                    Jumlah Produk
                </option>

            </select>

        </div>


        <!-- LIST KATEGORI -->
        <div
            class="category-list"
            id="categoryList"
        >

            @forelse($categories as $category)

                <div
                    class="category-card"
                    data-name="{{ strtolower($category->nama_kategori) }}"
                    data-products="{{ $category->products_count ?? 0 }}"
                >

                    <!-- INFORMASI -->
                    <div class="category-info">

                        <span class="category-label">
                            KATEGORI
                        </span>

                        <h3>
                            {{ $category->nama_kategori }}
                        </h3>

                        <p>
                            {{ $category->deskripsi ?? 'Tidak ada deskripsi kategori.' }}
                        </p>

                    </div>


                    <!-- JUMLAH PRODUK -->
                    <div class="category-product">

                        <span>
                            JUMLAH PRODUK
                        </span>

                        <strong>
                            {{ $category->products_count ?? 0 }}
                        </strong>

                        <small>
                            Produk
                        </small>

                    </div>


                    <!-- STATUS -->
                    <div class="category-status">

                        @if(($category->products_count ?? 0) > 0)

                            <span class="status-active">
                                Aktif
                            </span>

                        @else

                            <span class="status-empty">
                                Kosong
                            </span>

                        @endif

                    </div>


                    <!-- ACTION -->
                    <div class="category-actions">

                        <!-- EDIT -->
                        <a
                            href="{{ route('admin.categories.edit', $category->id) }}"
                            class="category-edit"
                        >
                            Edit
                        </a>


                        <!-- HAPUS -->
                        <form
                            action="{{ route('admin.categories.destroy', $category->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->nama_kategori }}?')"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="category-delete"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="category-empty">

                    <h3>
                        Belum Ada Kategori
                    </h3>

                    <p>
                        Belum ada kategori produk yang tersedia.
                    </p>

                    <a
                        href="{{ route('admin.categories.create') }}"
                        class="add-category-button"
                    >
                        + Tambah Kategori
                    </a>

                </div>

            @endforelse


            <!-- TIDAK DITEMUKAN -->
            <div
                id="categoryNotFound"
                class="category-not-found"
                style="display: none;"
            >

                <h3>
                    Kategori tidak ditemukan
                </h3>

                <p>
                    Tidak ada kategori yang sesuai dengan pencarian.
                </p>

            </div>

        </div>


        <!-- TIPS KATEGORI -->
        <div class="category-tip">

            <div class="tip-title">
                TIPS KATEGORI
            </div>

            <p>
                Gunakan nama kategori yang singkat dan mudah dipahami
                agar pelanggan lebih mudah menemukan produk yang mereka
                inginkan.
            </p>

        </div>


    </main>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('categorySearch');

    const sortSelect =
        document.getElementById('sortCategory');

    const categoryList =
        document.getElementById('categoryList');

    const notFound =
        document.getElementById('categoryNotFound');


    function filterCategories() {

        const searchValue =
            searchInput.value.toLowerCase().trim();

        const cards =
            Array.from(
                document.querySelectorAll('.category-card')
            );

        let visibleCount = 0;


        cards.forEach(function (card) {

            const categoryName =
                card.dataset.name.toLowerCase();


            if (
                categoryName.includes(searchValue)
            ) {

                card.style.display = '';

                visibleCount++;

            } else {

                card.style.display = 'none';

            }

        });


        if (visibleCount === 0) {

            notFound.style.display = 'block';

        } else {

            notFound.style.display = 'none';

        }

    }


    function sortCategories() {

        const cards =
            Array.from(
                document.querySelectorAll('.category-card')
            );

        const sortValue =
            sortSelect.value;


        cards.sort(function (a, b) {

            if (sortValue === 'name') {

                return a.dataset.name.localeCompare(
                    b.dataset.name
                );

            }


            if (sortValue === 'product') {

                return (
                    Number(b.dataset.products) -
                    Number(a.dataset.products)
                );

            }


            return 0;

        });


        cards.forEach(function (card) {

            categoryList.appendChild(card);

        });


        filterCategories();

    }


    searchInput.addEventListener(
        'input',
        filterCategories
    );


    sortSelect.addEventListener(
        'change',
        sortCategories
    );

});

</script>
@endsection