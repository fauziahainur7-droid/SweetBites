@extends('layouts.app')

@section('content')

<h2>Selamat Datang di SweetBites</h2>

<p>
    Aplikasi Penjualan Kue SweetBites
</p>

<hr>

<h3>Menu</h3>

<p>
    Silakan lihat berbagai produk kue yang tersedia.
</p>

<a href="{{ route('products.index') }}">
    Lihat Produk
</a>

<br><br>

@guest
<a href="{{ route('login') }}">Login</a>
|
<a href="{{ route('register') }}">Daftar</a>
@endguest

@auth
<p>
    Selamat datang, {{ Auth::user()->name }}
</p>

<a href="{{ route('cart.index') }}">
    Lihat Keranjang
</a>
@endauth

@endsection