@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

<a href="{{ route('catalog') }}"
   class="btn btn-secondary mb-3">
     Kembali ke Katalog
</a>

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-md-5">

                @if($product->gambar)
                    <img
                        src="{{ asset('storage/products/' . $product->gambar) }}"
                        class="img-fluid rounded"
                        alt="{{ $product->nama_kue }}"
                    >

                @else

                    <div class="bg-light p-5 text-center">
                        Tidak ada gambar
                    </div>

                @endif

            </div>

            <div class="col-md-7">

                <h2>{{ $product->nama_kue }}</h2>

                <p>
                    <strong>Kategori:</strong>
                    {{ $product->category->nama_kategori ?? '-' }}
                </p>

                <h4>
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </h4>

                <p>
                    <strong>Stok:</strong>
                    {{ $product->stok }}
                </p>

                <p>
                    {{ $product->deskripsi }}
                </p>


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
                                class="mt-3"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="{{ $product->id }}"
                                >

                                <label class="form-label">
                                    Jumlah
                                </label>

                                <input
                                    type="number"
                                    name="jumlah"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stok }}"
                                    class="form-control mb-3"
                                    style="max-width:150px;"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-dark"
                                >
                                    Tambah ke Keranjang
                                </button>

                            </form>

                        @else

                            <button
                                class="btn btn-secondary"
                                disabled
                            >
                                Stok Habis
                            </button>

                        @endif

                    @endif

                @else

                    <a
                        href="{{ route('login') }}"
                        class="btn btn-dark mt-3"
                    >
                        Login untuk Beli
                    </a>

                @endauth

            </div>

        </div>

    </div>

</div>


<hr class="mt-5">

<h4 class="mb-4">
    Ulasan Pelanggan
</h4>


@if($reviews->count() > 0)

    @foreach($reviews as $review)

        <div class="card mb-3">

            <div class="card-body">

                <h6>
                    {{ $review->user->name }}
                </h6>


                <div class="mb-2">

                    @for($i = 1; $i <= 5; $i++)

                        @if($i <= $review->rating)

                            <span>★</span>

                        @else

                            <span>☆</span>

                        @endif

                    @endfor

                </div>


                @if($review->komentar)

                    <p class="mb-2">
                        {{ $review->komentar }}
                    </p>

                @endif


                <small class="text-muted">

                    {{ $review->created_at->format('d/m/Y') }}

                </small>

            </div>

        </div>

    @endforeach

@else

    <div class="alert alert-secondary">

        Belum ada ulasan untuk produk ini.

    </div>

@endif

@endsection