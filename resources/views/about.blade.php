@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<!-- Tentang Kami -->
<section class="about-section">
    <div class="container">
        <div class="about-box text-center">

            <span class="about-badge">
                Kenali Kami Lebih Dekat
            </span>

            <h2 class="about-title">
                TENTANG KAMI
            </h2>

            <p class="about-tagline">
                "Membuat Setiap Momen Lebih Manis"
            </p>

            <p class="about-description mx-auto">
                SweetBites hadir untuk mengubah setiap gigitan menjadi kenangan indah.
                Berawal dari dapur kecil, kami tumbuh dengan satu misi:
                menyajikan kue berkualitas tinggi yang dibuat dengan cinta.
            </p>

        </div>
    </div>

    <div class="about-zigzag"></div>
</section>


<!-- VISI & MISI -->
<section class="visi-misi">

    <div class="visi-misi-container">

        <!-- BAGIAN KIRI : VISI -->
        <div class="visi-box">

            <h2>
                Visi Kami
            </h2>

            <p class="visi-description">
                Menjadi toko kue terbaik yang menyajikan kebahagiaan
                melalui setiap gigitan kue yang kami buat dengan penuh cinta.
            </p>

            <!-- COLLAGE FOTO -->
            <div class="visi-photo-collage">

                <!-- FOTO KIRI -->
                <div class="visi-photo photo-left">
                    <img src="{{ asset('images/visi-kue-1.jpg') }}"
                         alt="Kue SweetBites">
                </div>

                <!-- FOTO UTAMA -->
                <div class="visi-photo photo-main">
                    <img src="{{ asset('images/visi-kue-2.jpg') }}"
                         alt="Produk SweetBites">
                </div>

                <!-- FOTO KANAN -->
                <div class="visi-photo photo-right">
                    <img src="{{ asset('images/visi-kue-3.jpg') }}"
                         alt="Aneka Kue SweetBites">
                </div>

            </div>

        </div>


        <!-- BAGIAN KANAN : MISI -->
        <div class="misi-box">

            <h2>
                Misi Kami
            </h2>

            <div class="misi-list">

                <!-- MISI 1 -->
                <div class="misi-item">

                    <div class="misi-number">
                        01
                    </div>

                    <div class="misi-detail">

                        <h4>KUALITAS TINGGI</h4>

                        <p>
                            Menyediakan kue berkualitas tinggi
                            dengan bahan-bahan terbaik.
                        </p>

                    </div>

                </div>


                <!-- MISI 2 -->
                <div class="misi-item">

                    <div class="misi-number">
                        02
                    </div>

                    <div class="misi-detail">

                        <h4>PELAYANAN RAMAH</h4>

                        <p>
                            Memberikan pelayanan yang ramah
                            dan memuaskan kepada setiap pelanggan.
                        </p>

                    </div>

                </div>


                <!-- MISI 3 -->
                <div class="misi-item">

                    <div class="misi-number">
                        03
                    </div>

                    <div class="misi-detail">

                        <h4>KEBERSIHAN & AMAN</h4>

                        <p>
                            Menjaga kebersihan dan keamanan
                            dalam setiap proses pembuatan produk.
                        </p>

                    </div>

                </div>


                <!-- MISI 4 -->
                <div class="misi-item">

                    <div class="misi-number">
                        04
                    </div>

                    <div class="misi-detail">

                        <h4>INOVASI RASA</h4>

                        <p>
                            Menciptakan inovasi rasa baru untuk
                            memberikan pengalaman berbeda.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- CARA PEMBELIAN -->
<section class="cara-pembelian">

    <div class="container">

        <div class="cara-header">

            <div>
                <span class="cara-label">SWEETBITES</span>
                <h2>Cara Pemesanan</h2>
            </div>

        </div>


        <div class="cara-steps">

            <!-- STEP 1 -->
            <div class="cara-step">

                <div class="step-number">01</div>

                <div class="step-icon">
                    <img src="{{ asset('images/icons/pilih-kue.png') }}"
                         alt="Pilih Kue">
                </div>

                <h3>Pilih Kue</h3>

                <p>
                    Kunjungi halaman katalog dan pilih
                    kue favoritmu.
                </p>

            </div>


            <!-- STEP 2 -->
            <div class="cara-step">

                <div class="step-number">02</div>

                <div class="step-icon">
                    <img src="{{ asset('images/icons/keranjang.png') }}"
                         alt="Keranjang">
                </div>

                <h3>Tambah ke Keranjang</h3>

                <p>
                    Klik "Tambah ke Keranjang"
                    atau "Beli Langsung".
                </p>

            </div>


            <!-- STEP 3 -->
            <div class="cara-step">

                <div class="step-number">03</div>

                <div class="step-icon">
                    <img src="{{ asset('images/icons/pembayaran.png') }}"
                         alt="Pembayaran">
                </div>

                <h3>Checkout & Bayar</h3>

                <p>
                    Isi alamat pengiriman dan pilih
                    metode pembayaran.
                </p>

            </div>


            <!-- STEP 4 -->
            <div class="cara-step">

                <div class="step-number">04</div>

                <div class="step-icon">
                    <img src="{{ asset('images/icons/pengiriman.png') }}"
                         alt="Pengiriman">
                </div>

                <h3>Pesanan Diantar</h3>

                <p>
                    Tim SweetBites akan memproses
                    dan mengantar pesanan Anda.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- Jam Operasional -->
<section class="jam-operasional-section">

    <div class="container">

        <!-- Judul -->
        <div class="jam-header">
            <h2>JAM OPERASIONAL</h2>
        </div>


        <!-- List Jam -->
        <div class="jam-list">

            <div class="jam-row">
                <span class="jam-hari">SENIN</span>
                <span class="jam-waktu">TUTUP</span>
            </div>

            <div class="jam-row">
                <span class="jam-hari">SELASA</span>
                <span class="jam-waktu">08.00 - 19.00</span>
            </div>

            <div class="jam-row">
                <span class="jam-hari">RABU</span>
                <span class="jam-waktu">08.00 - 19.00</span>
            </div>

            <div class="jam-row">
                <span class="jam-hari">KAMIS</span>
                <span class="jam-waktu">08.00 - 19.00</span>
            </div>

            <div class="jam-row">
                <span class="jam-hari">JUM'AT</span>
                <span class="jam-waktu">08.00 - 19.00</span>
            </div>

            <div class="jam-row">
                <span class="jam-hari">SABTU</span>
                <span class="jam-waktu">08.00 - 20.00</span>
            </div>

            <div class="jam-row">
                <span class="jam-hari">MINGGU</span>
                <span class="jam-waktu">08.00 - 21.00</span>
            </div>

        </div>


        <!-- Catatan -->
        <div class="jam-catatan">

            <p><strong>Catatan:</strong></p>

            <ul>
                <li>Pesanan custom minimal H-2 sebelum pengiriman.</li>
                <li>Pengiriman terakhir 1 jam sebelum tutup.</li>
                <li>Hari libur nasional tetap buka dengan jam berbeda.</li>
            </ul>

        </div>

    </div>

</section>

<!-- CTA Penutup -->
<section class="cta-banner-section">

    <div class="container">

        <div class="cta-banner">

            <!-- KIRI: GAMBAR -->
            <div class="cta-banner-image">

                <img src="{{ asset('images/about.jpg') }}"
                     alt="Kue SweetBites">

            </div>


            <!-- KANAN: TEKS -->
            <div class="cta-banner-content">

                <span class="cta-label">
                    SWEETBITES
                </span>

                <h2>
                    Siap Memesan Kue Lezat?
                </h2>

                <p>
                    Pesan sekarang dan rasakan kebahagiaan
                    di setiap gigitan.
                </p>

                <div class="cta-buttons">

                    <a href="{{ url('/catalog') }}"
                       class="cta-btn-primary">
                        Lihat Katalog
                    </a>

                    <a href="{{ url('/contact') }}"
                       class="cta-btn-secondary">
                        Hubungi Kami
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>
@endsection