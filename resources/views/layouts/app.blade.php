<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SweetBites</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <header>
        <h1>SweetBites</h1>

        <nav>
            <a href="/">Home</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="{{ route('cart.index') }}">Keranjang</a>
            <a href="{{ route('orders.index') }}">Pesanan</a>

            @auth
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>