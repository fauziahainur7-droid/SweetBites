@extends('layouts.app')

@section('content')

    <h2>Dashboard SweetBites</h2>

    <p>Selamat datang di aplikasi penjualan kue SweetBites.</p>

    <hr>

    <h3>Menu</h3>

    <ul>
        <li>
            <a href="{{ route('products.index') }}">
                Katalog Produk
            </a>
        </li>

        <li>
            <a href="{{ route('cart.index') }}">
                Keranjang
            </a>
        </li>

        <li>
            <a href="{{ route('orders.index') }}">
                Pesanan
            </a>
        </li>
    </ul>

    @auth
        <p>
            Login sebagai: <strong>{{ Auth::user()->name }}</strong>
        </p>
    @endauth

@endsection