@extends('layouts.app')

@section('title', 'Katalog')

@section('content')

<h2>Katalog Kue</h2>

<form action="{{ route('catalog') }}" method="GET" class="row mb-3">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari kue..."
            value="{{ request('search') }}"
        >
    </div>

    <div class="col-md-4">
        <select name="category" class="form-control">

            <option value="">
                Semua Kategori
            </option>

            @foreach($categories ?? [] as $cat)

                <option
                    value="{{ $cat->id }}"
                    {{ request('category') == $cat->id ? 'selected' : '' }}
                >
                    {{ $cat->nama_kategori }}
                </option>

            @endforeach

        </select>
    </div>

    <div class="col-md-4">

        <button
            type="submit"
            class="btn btn-dark"
        >
            Cari
        </button>

        <a
            href="{{ route('catalog') }}"
            class="btn btn-secondary"
        >
            Reset
        </a>

    </div>

</form>


<div class="row">

    @forelse($products ?? [] as $product)

        <div class="col-md-3 mb-3">

            <div class="card h-100">

                <div class="card-body">

                    <h5>
                        {{ $product->nama_kue }}
                    </h5>

                    <p>
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>

                    <div class="d-flex gap-1 flex-wrap">

                        {{-- DETAIL --}}
                        <a
                            href="{{ route('products.show', $product->id) }}"
                            class="btn btn-dark btn-sm"
                        >
                            Detail
                        </a>


                        @auth

                            {{-- BELI --}}
                            <form
                                action="{{ route('cart.store') }}"
                                method="POST"
                                class="d-inline"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="{{ $product->id }}"
                                >

                                <input
                                    type="hidden"
                                    name="jumlah"
                                    value="1"
                                >

                                <input
                                    type="hidden"
                                    name="redirect_to"
                                    value="cart"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-success btn-sm"
                                    {{ $product->stok <= 0 ? 'disabled' : '' }}
                                >
                                    Beli
                                </button>

                            </form>


                            {{-- KERANJANG --}}
                            <form
                                action="{{ route('cart.store') }}"
                                method="POST"
                                class="d-inline"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="{{ $product->id }}"
                                >

                                <input
                                    type="hidden"
                                    name="jumlah"
                                    value="1"
                                >

                                <input
                                    type="hidden"
                                    name="redirect_to"
                                    value="catalog"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-secondary btn-sm"
                                    {{ $product->stok <= 0 ? 'disabled' : '' }}
                                >
                                    Keranjang
                                </button>

                            </form>

                        @else

                            {{-- BELUM LOGIN --}}
                            <a
                                href="{{ route('login') }}"
                                class="btn btn-success btn-sm"
                            >
                                Beli
                            </a>

                            <a
                                href="{{ route('login') }}"
                                class="btn btn-secondary btn-sm"
                            >
                                Keranjang
                            </a>

                        @endauth

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12 text-center">
            Tidak ada produk
        </div>

    @endforelse

</div>


{{ $products->links() ?? '' }}

@endsection

