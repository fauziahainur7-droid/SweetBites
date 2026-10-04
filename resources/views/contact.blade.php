@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<!-- hero kontak -->
<section class="kontak-hero">
    <div class="container">
        <div class="kontak-hero-content">
            <span class="kontak-label">HUBUNGI KAMI</span>
            <h1>Ada Pertanyaan?</h1>
            <p>Kami siap membantu Anda. Hubungi kami kapan saja.</p>
        </div>
    </div>
</section>

<!-- info contak dan denah -->
<section class="kontak-quote-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            <!-- KIRI: INFO KONTAK + FOTO -->
            <div class="col-lg-6">
                <div class="kontak-info-box">

                    <h2 class="info-title">Hubungi Kami</h2>

                    <p class="info-desc">
                        Kami siap membantu Anda. Hubungi kami kapan saja
                        untuk pertanyaan, pesanan, atau kerja sama.
                    </p>

                    <div class="info-list">

                        <!-- Telepon -->
                        <div class="info-item">
                            <div class="info-icon">
                                <img src="{{ asset('images/icon-phone.png') }}" alt="Telepon">
                            </div>

                            <div class="info-text">
                                <span class="info-label">Telepon</span>
                                <strong>+62 857 137 244 94</strong>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="info-item">
                            <div class="info-icon">
                                <img src="{{ asset('images/icon-email.png') }}" alt="Email">
                            </div>

                            <div class="info-text">
                                <span class="info-label">Email</span>
                                <strong>hello@sweetbites.id</strong>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="info-item">
                            <div class="info-icon">
                                <img src="{{ asset('images/icon-address.png') }}" alt="Alamat">
                            </div>

                            <div class="info-text">
                                <span class="info-label">Alamat</span>
                                <strong>Jl. Raya Purbalingga No. 123, Jawa Tengah</strong>
                            </div>
                        </div>

                    </div>

                    <!-- FOTO SENDIRI -->
                    <div class="info-image-box">
                        <img src="{{ asset('images/sweetbites.jpg') }}" alt="SweetBites">
                    </div>

                </div>
            </div>


            <!-- KANAN: DENAH -->
            <div class="col-lg-6">
                <div class="kontak-denah-box">

                    <h2 class="denah-title">Denah Lokasi</h2>

                    <div class="denah-gambar">
                        <img src="{{ asset('images/denah-sweetbites.png') }}"
                             alt="Denah Lokasi SweetBites">
                    </div>

                    <div class="denah-patokan">
                        <strong>Patokan:</strong>
                        <span>
                            Dekat Alun-Alun Purbalingga, kawasan pusat kota.
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- SOSIAL MEDIA -->
<section class="kontak-sosmed-section">
    <div class="container">

        <div class="kontak-sosmed-list">

            <!-- TikTok -->
            <a href="https://tiktok.com/@sweetbites.id" target="_blank" class="sosmed-card">
                <div class="sosmed-icon">
                    <img src="{{ asset('images/icon-tiktok.png') }}" alt="TikTok">
                </div>
                <div class="sosmed-text">
                    <span class="sosmed-label">TikTok</span>
                    <strong>@sweetbites.id</strong>
                </div>
            </a>

            <!-- Instagram -->
            <a href="https://instagram.com/sweetbites.id" target="_blank" class="sosmed-card">
                <div class="sosmed-icon">
                    <img src="{{ asset('images/icon-instagram.png') }}" alt="Instagram">
                </div>
                <div class="sosmed-text">
                    <span class="sosmed-label">Instagram</span>
                    <strong>@sweetbites.id</strong>
                </div>
            </a>

            <!-- Facebook -->
            <a href="https://facebook.com/sweetbites.id" target="_blank" class="sosmed-card">
                <div class="sosmed-icon">
                    <img src="{{ asset('images/icon-facebook.png') }}" alt="Facebook">
                </div>
                <div class="sosmed-text">
                    <span class="sosmed-label">Facebook</span>
                    <strong>SweetBites</strong>
                </div>
            </a>

            <!-- Twitter -->
            <a href="https://twitter.com/sweetbites.id" target="_blank" class="sosmed-card">
                <div class="sosmed-icon">
                    <img src="{{ asset('images/icon-twitter.png') }}" alt="Twitter">
                </div>
                <div class="sosmed-text">
                    <span class="sosmed-label">Twitter</span>
                    <strong>@sweetbites.id</strong>
                </div>
            </a>

        </div>

    </div>
</section>

@endsection