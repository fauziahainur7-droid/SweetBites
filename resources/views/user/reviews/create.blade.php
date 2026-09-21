@extends('layouts.app')

@section('title', 'Beri Ulasan')

@section('content')

<div class="container mt-4 mb-5">

    <h2>Beri Ulasan</h2>

    <p>
        No. Pesanan:
        <strong>{{ $order->kode_pesanan }}</strong>
    </p>

    <hr>


    @foreach($order->orderDetails as $detail)

        <div class="card mb-4">

            <div class="card-body">

                <h5 class="mb-3">
                    {{ $detail->product->nama_kue }}
                </h5>


                @if(in_array($detail->produk_id, $reviewedProducts))

                    <div class="alert alert-success mb-0">

                        Produk ini sudah kamu ulas.

                    </div>

                @else

                    <form
                        action="{{ route('reviews.store') }}"
                        method="POST"
                    >

                        @csrf


                        <input
                            type="hidden"
                            name="order_id"
                            value="{{ $order->id }}"
                        >


                        <input
                            type="hidden"
                            name="produk_id"
                            value="{{ $detail->produk_id }}"
                        >


                        <div class="mb-3">

                            <label class="form-label">
                                Rating
                            </label>

                            <select
                                name="rating"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Pilih Rating
                                </option>

                                <option value="5">
                                    5 - Sangat Puas
                                </option>

                                <option value="4">
                                    4 - Puas
                                </option>

                                <option value="3">
                                    3 - Cukup
                                </option>

                                <option value="2">
                                    2 - Kurang
                                </option>

                                <option value="1">
                                    1 - Tidak Puas
                                </option>

                            </select>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Komentar
                            </label>

                            <textarea
                                name="komentar"
                                class="form-control"
                                rows="4"
                                placeholder="Tulis ulasan kamu..."
                            ></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            Kirim Ulasan
                        </button>

                    </form>

                @endif

            </div>

        </div>

    @endforeach


    <a
        href="{{ route('orders.index') }}"
        class="btn btn-secondary"
    >
        Kembali
    </a>

</div>

@endsection