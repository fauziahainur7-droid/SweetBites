@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- HERO -->
<div class="sweet-hero">

    <div class="sweet-hero-text">

        <div class="sweet-label">
            SWEETBITES PÂTISSERIE & COOKIES BAR
        </div>

        <h1>SweetBites</h1>

        <p class="sweet-description">
            SweetBites adalah toko kue homemade yang menyajikan berbagai macam kue kekinian.
            Mulai dari cookies renyah, brownies fudgy, pastry artisan,
            dessert box estetik, hingga cupcake lembut — semuanya dibuat fresh setiap hari dengan
            penuh cinta. Temukan kebahagiaan kecil di setiap gigitan!
        </p>

        <div class="sweet-buttons">
            <a href="{{ route('catalog') }}" class="sweet-btn-primary">
                Lihat Menu
            </a>

            <a href="{{ route('about') }}" class="sweet-btn-secondary">
                Cara Pesan
            </a>

        </div>

    </div>


    <div class="sweet-hero-image">

        <img src="{{ asset('images/hero.jpg') }}" alt="SweetBites">

        <div class="sweet-floating-card card-one">
            <img src="{{ asset('images/kue1.jpg') }}" alt="Kue">
            <div>
                <strong>Fresh Cake</strong>
                <small>Kue pilihan</small>
            </div>
        </div>

        <div class="sweet-floating-card card-two">
            <img src="{{ asset('images/kue2.jpg') }}" alt="Kue">
            <div>
                <strong>Best Seller</strong>
                <small>Paling disukai</small>
            </div>
        </div>

        <div class="sweet-floating-card card-three">
            <img src="{{ asset('images/kue3.jpg') }}" alt="Kue">
            <div>
                <strong>Homemade</strong>
                <small>Dibuat fresh</small>
            </div>
        </div>

    </div>
    <!-- Gelombang putih -->
    <div class="sweet-wave">
        <svg viewBox="0 0 1440 180" preserveAspectRatio="none">
            <path d="
            M0,80
            C180,160 360,160 540,80
            C720,0 900,0 1080,80
            C1260,160 1350,160 1440,80
            L1440,180
            L0,180
            Z">
            </path>
        </svg>
    </div>

</div>



<!-- KATEGORI POPULER -->
<section class="kategori">
    <div class="kategori-list">
        <div class="kategori-item">
            <div class="kategori-icon">
                <img src="{{ asset('images/cookies.png') }}" alt="Cookies">
            </div>
            <h3>Cookies</h3>
            <p>Cookies homemade</p>
        </div>

        <div class="kategori-item">
            <div class="kategori-icon">
                <img src="{{ asset('images/chest.png') }}" alt="Brownies">
            </div>
            <h3>Brownies</h3>
            <p>Brownies lembut & enak</p>
        </div>

        <div class="kategori-item">
            <div class="kategori-icon">
                <img src="{{ asset('images/croissant.png') }}" alt="Pastry">
            </div>
            <h3>Pastry</h3>
            <p>Pastry fresh setiap hari</p>
        </div>

        <div class="kategori-item">
            <div class="kategori-icon">
                <img src="{{ asset('images/box.png') }}" alt="Dessert Box">
            </div>
            <h3>Dessert Box</h3>
            <p>Dessert untuk semua</p>
        </div>

        <div class="kategori-item">
            <div class="kategori-icon">
                <img src="{{ asset('images/cupcake.png') }}" alt="Cupcake">
            </div>
            <h3>Cupcake</h3>
            <p>Manis dan lembut</p>
        </div>
    </div>
</section>

<!-- PRODUK UNGGULAN -->
<section class="produk-unggulan">

    <div class="container">

        <div class="produk-heading">
            <h2>Produk Unggulan</h2>
            <p>Temukan cookies favorit dari SweetBites</p>
        </div>

        <div id="produkCarousel"
            class="carousel slide"
            data-bs-ride="carousel"
            data-bs-interval="4000">

            <div class="carousel-inner">

                <!-- SLIDE 1 -->
                <div class="carousel-item active">
                    <div class="row justify-content-center align-items-center">

                        <!-- KIRI -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/lotus.jpg') }}"
                                        alt="Nutella Stuffed Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Biscoff Lotus Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 72.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- TENGAH -->
                        <div class="col-md-5">
                            <div class="produk-card produk-tengah">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/cokie.jpg') }}"
                                        alt="Choco Chip Sea Salt Cookies">
                                </div>

                                <div class="produk-info">
                                    <h4>Choco Chip Sea Salt Cookies</h4>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 65.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/matcha.jpg') }}"
                                        alt="Matcha Almond Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Matcha Almond Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 70.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <!-- SLIDE 2 -->
                <div class="carousel-item">
                    <div class="row justify-content-center align-items-center">

                        <!-- KIRI -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/cokie.jpg') }}"
                                        alt="Choco Chip Sea Salt Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Choco Chip Sea Salt Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 65.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- TENGAH -->
                        <div class="col-md-5">
                            <div class="produk-card produk-tengah">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/matcha.jpg') }}"
                                        alt="Matcha Almond Cookies">
                                </div>

                                <div class="produk-info">
                                    <h4>Matcha Almond Cookies</h4>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 70.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/redvelvet.jpg') }}"
                                        alt="Red Velvet Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Red Velvet Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 72.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <!-- SLIDE 3 -->
                <div class="carousel-item">
                    <div class="row justify-content-center align-items-center">

                        <!-- KIRI -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/matcha.jpg') }}"
                                        alt="Matcha Almond Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Matcha Almond Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 70.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- TENGAH -->
                        <div class="col-md-5">
                            <div class="produk-card produk-tengah">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/redvelvet.jpg') }}"
                                        alt="Red Velvet Cookies">
                                </div>

                                <div class="produk-info">
                                    <h4>Red Velvet Cookies</h4>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 72.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/lotus.jpg') }}"
                                        alt="Biscoff Lotus Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Biscoff Lotus Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 72.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <!-- SLIDE 4 -->
                <div class="carousel-item">
                    <div class="row justify-content-center align-items-center">

                        <!-- KIRI -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/redvelvet.jpg') }}"
                                        alt="Red Velvet Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Red Velvet Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 72.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- TENGAH -->
                        <div class="col-md-5">
                            <div class="produk-card produk-tengah">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/lotus.jpg') }}"
                                        alt="Biscoff Lotus Cookies">
                                </div>

                                <div class="produk-info">
                                    <h4>Biscoff Lotus Cookies</h4>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 72.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="col-md-3">
                            <div class="produk-card produk-samping">

                                <div class="produk-image">
                                    <img src="{{ asset('images/products/cokie.jpg') }}"
                                        alt="Choco Chip Sea Salt Cookies">
                                </div>

                                <div class="produk-info">
                                    <h5>Choco Chip Sea Salt Cookies</h5>
                                    <p class="rating">⭐ 4.5 (0)</p>
                                    <p class="harga">Rp 65.000</p>

                                    <a href="#" class="btn-beli">
                                        Beli
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>


            <!-- PANAH KIRI -->
            <button class="carousel-control-prev produk-control"
                type="button"
                data-bs-target="#produkCarousel"
                data-bs-slide="prev">

                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>

            </button>


            <!-- PANAH KANAN -->
            <button class="carousel-control-next produk-control"
                type="button"
                data-bs-target="#produkCarousel"
                data-bs-slide="next">

                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>

            </button>


            <!-- TITIK -->
            <div class="carousel-indicators produk-indicators">

                <button type="button"
                    data-bs-target="#produkCarousel"
                    data-bs-slide-to="0"
                    class="active">
                </button>

                <button type="button"
                    data-bs-target="#produkCarousel"
                    data-bs-slide-to="1">
                </button>

                <button type="button"
                    data-bs-target="#produkCarousel"
                    data-bs-slide-to="2">
                </button>

                <button type="button"
                    data-bs-target="#produkCarousel"
                    data-bs-slide-to="3">
                </button>

            </div>

        </div>

    </div>

</section>

<!-- KENAPA MEMILIH KAMI -->
<section class="kenapa-memilih">

    <div class="container">

        <!-- JUDUL -->
        <div class="kenapa-heading">

            <h2>Kenapa Memilih Kami?</h2>

            <p>
                Kualitas yang kami berikan untuk pengalaman terbaikmu.
            </p>

        </div>


        <!-- KEUNGGULAN -->
        <div class="kenapa-list">

            <!-- 1 -->
            <div class="kenapa-item">

                <div class="kenapa-icon">
                    <span>01</span>
                </div>

                <div class="kenapa-content">

                    <h3>HOMEMADE PREMIUM</h3>

                    <div class="kenapa-small-line"></div>

                    <p>
                        Semua kue dibuat dengan cinta dan resep
                        pilihan SweetBites. Dipanggang fresh
                        setiap hari.
                    </p>

                </div>

            </div>


            <!-- 2 -->
            <div class="kenapa-item">

                <div class="kenapa-icon">
                    <span>02</span>
                </div>

                <div class="kenapa-content">

                    <h3>BAHAN BERKUALITAS</h3>

                    <div class="kenapa-small-line"></div>

                    <p>
                        Menggunakan bahan pilihan berkualitas
                        tinggi untuk menghasilkan rasa terbaik
                        pada setiap produk.
                    </p>

                </div>

            </div>


            <!-- 3 -->
            <div class="kenapa-item">

                <div class="kenapa-icon">
                    <span>03</span>
                </div>

                <div class="kenapa-content">

                    <h3>GRATIS ONGKIR</h3>

                    <div class="kenapa-small-line"></div>

                    <p>
                        Pesanan diantar dengan aman oleh tim
                        SweetBites tanpa biaya tambahan*.
                    </p>

                </div>

            </div>

        </div>


        <p class="kenapa-catatan">
            *Syarat dan ketentuan berlaku untuk area pengiriman tertentu.
        </p>

    </div>

</section>

<!-- Section Pengalaman / Stats -->
<section class="pengalaman-section">

    <!-- FOTO ARCH -->
    <div class="pengalaman-wrapper">
        <div class="pengalaman-photos">
            <div class="arch-photo">
                <img src="{{ asset('images/pengalaman-1.jpg') }}" alt="SweetBites 1">
            </div>
            <div class="arch-photo">
                <img src="{{ asset('images/pengalaman-2.jpg') }}" alt="SweetBites 2">
            </div>
            <div class="arch-photo">
                <img src="{{ asset('images/pengalaman-3.jpg') }}" alt="SweetBites 3">
            </div>
            <div class="arch-photo">
                <img src="{{ asset('images/pengalaman-4.jpg') }}" alt="SweetBites 4">
            </div>
            <div class="arch-photo">
                <img src="{{ asset('images/pengalaman-5.jpg') }}" alt="SweetBites 5">
            </div>
        </div>
    </div>

    <!-- KOTAK HIJAU - FULL WIDTH -->
    <div class="pengalaman-content">
        <div class="container content-inner">
            
            <h2 class="pengalaman-title">
                Dengan pengalaman kami,<br>
                kami siap melayani Anda
            </h2>

            <div class="pengalaman-stats">
                <div class="stat-item">
                    <strong>Fresh</strong>
                    <span>Dipanggang Harian</span>
                </div>
                <div class="stat-item">
                    <strong>25</strong>
                    <span>Varian Kue</span>
                </div>
                <div class="stat-item">
                    <strong>100%</strong>
                    <span>Homemade</span>
                </div>
            </div>

        </div>
    </div>

</section>

@endsection