@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

<div class="order-detail-page">

    {{-- Topbar --}}
    <header class="topbar">
        <div class="topbar-left">

            <a
                class="back-button"
                href="{{ route('admin.orders.index') }}"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Daftar Pesanan
            </a>

            <span class="divider">|</span>

            <div class="order-id-wrap">
                <span class="order-label">ORDER ID</span>

                <span class="order-id">
                    {{ $order->kode_pesanan }}
                </span>
            </div>

        </div>

        <div class="topbar-right">

            <span class="status-pill">
                <i></i>
                Status:
                {{ ucfirst($order->status) }}
            </span>

            <button
                class="icon-button"
                type="button"
                title="Refresh"
                onclick="window.location.reload()"
            >
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>

        </div>
    </header>


    <div class="content">

        {{-- Order Summary --}}
        <section class="order-summary card">

            <div class="customer">

                <div class="customer-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>

                    <div class="customer-name">

                        <h2>
                            {{ $order->user->name ?? 'Pelanggan' }}
                        </h2>

                        <span>
                            Pelanggan Terdaftar
                        </span>

                    </div>

                    <p>
                        <i class="fa-regular fa-clock"></i>

                        Dipesan:
                        {{ $order->created_at->format('d M Y, H:i') }}
                        WIB

                        <em>•</em>

                        <i class="fa-solid fa-truck-pickup"></i>

                        {{ $order->metode_pengiriman ?? 'Diantar' }}
                    </p>

                </div>

            </div>


            <div class="summary-right">

                <div class="summary-stat">

                    <small>Total Tagihan</small>

                    <strong>
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </strong>

                </div>

                <div class="vertical-line"></div>

                <div class="summary-stat payment">

                    <small>Metode Bayar</small>

                    <strong>

                        @if(strtolower($order->metode_pembayaran) === 'cod')

                            <i class="fa-solid fa-money-bill-wave"></i>
                            COD

                        @else

                            <i class="fa-solid fa-building-columns"></i>
                            {{ $order->metode_pembayaran }}

                        @endif

                    </strong>

                </div>

            </div>

        </section>


        {{-- Pembayaran --}}
        @if(strtolower($order->metode_pembayaran) === 'cod')

            {{-- COD langsung verifikasi --}}
            <section class="card cod-verification-card">

                <div class="cod-verification-content">

                    <div class="cod-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <div class="cod-info">

                        <h3>
                            Pembayaran COD
                        </h3>

                        <p>
                            Pesanan ini menggunakan metode
                            <strong>Cash on Delivery (COD)</strong>.
                            Tidak diperlukan bukti pembayaran.
                            Pesanan dapat langsung diteruskan ke dapur.
                        </p>

                    </div>

                    <div class="cod-action">

                        <form
                            action="{{ route('admin.orders.update', $order->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="status"
                                value="diproses"
                            >

                            <button
                                type="submit"
                                class="verify-button"
                            >
                                <i class="fa-solid fa-circle-check"></i>
                                Verifikasi Pesanan
                            </button>

                        </form>

                    </div>

                </div>

            </section>

        @else

            {{-- Transfer / pembayaran non COD --}}
            <div class="verification-grid">

                {{-- Bukti Pembayaran --}}
                <section class="left-column">

                    <div class="card proof-card">

                        <div class="card-header">

                            <div class="header-title">

                                <div class="mini-icon">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>

                                <div>

                                    <h3>
                                        Bukti Pembayaran Terunggah
                                    </h3>

                                    <p>
                                        File format: image.png
                                        (Diterima via web)
                                    </p>

                                </div>

                            </div>


                            @if($order->payment && $order->payment->bukti_pembayaran)

                                <div class="header-actions">

                                    <a
                                        href="{{ route('admin.payments.proof', $order->payment->id) }}"
                                        target="_blank"
                                    >
                                        <i class="fa-solid fa-up-right-from-square"></i>
                                        Buka Penuh
                                    </a>

                                    <a
                                        class="dark-btn"
                                        href="{{ route('admin.payments.proof', $order->payment->id) }}"
                                        download
                                    >
                                        <i class="fa-solid fa-download"></i>
                                        Unduh
                                    </a>

                                </div>

                            @endif

                        </div>


                        <div class="proof-preview">

                            <div class="proof-image-wrap">

                                @if($order->payment && $order->payment->bukti_pembayaran)

                                    <img
                                        src="{{ route('admin.payments.proof', $order->payment->id) }}"
                                        alt="Bukti Pembayaran"
                                    >

                                @else

                                    <div class="empty-proof">

                                        <i class="fa-regular fa-image"></i>

                                        <strong>
                                            Belum ada bukti pembayaran
                                        </strong>

                                        <span>
                                            Pelanggan belum mengunggah bukti pembayaran.
                                        </span>

                                    </div>

                                @endif

                            </div>

                        </div>


                        @if($order->payment)

                            <div class="bank-check">

                                <div class="check-head">

                                    <h4>
                                        DATA MUTASI & PARAMETER COCOK
                                    </h4>

                                    <span>
                                        <i class="fa-solid fa-circle-check"></i>
                                        Nominal Sesuai
                                    </span>

                                </div>


                                <div class="check-grid">

                                    <div class="check-item">

                                        <small>
                                            Bank Tujuan Toko
                                        </small>

                                        <strong>
                                            <i class="fa-solid fa-landmark"></i>
                                            BCA - 7820199201
                                        </strong>

                                        <p>
                                            a/n SweetBites Bakery Group
                                        </p>

                                    </div>


                                    <div class="check-item">

                                        <small>
                                            Nama Pengirim
                                        </small>

                                        <strong>
                                            <i class="fa-regular fa-user"></i>
                                            {{ $order->user->name ?? '-' }}
                                        </strong>

                                        <p>
                                            Data pembayaran pelanggan
                                        </p>

                                    </div>


                                    <div class="check-item">

                                        <small>
                                            Waktu Transfer
                                        </small>

                                        <strong>
                                            <i class="fa-regular fa-calendar-check"></i>

                                            {{ $order->payment->created_at
                                                ? $order->payment->created_at->format('d M Y, H:i')
                                                : '-'
                                            }}
                                            WIB
                                        </strong>

                                        <p>
                                            Waktu pembayaran tercatat
                                        </p>

                                    </div>


                                    <div class="check-item amount">

                                        <small>
                                            Nominal Tertera
                                        </small>

                                        <strong>
                                            <i class="fa-solid fa-coins"></i>

                                            Rp
                                            {{ number_format(
                                                $order->payment->total_bayar ?? $order->total_harga,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </strong>

                                        <p>
                                            <i class="fa-solid fa-check"></i>
                                            Nominal pembayaran
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- Tindakan Verifikasi --}}
                <section class="right-column">

                    <div class="card verify-card">

                        <div class="verify-head">

                            <h3>
                                Tindakan Verifikasi
                            </h3>
                            
                        </div>


                        @if($order->payment)

                            <form
                                class="verify-form"
                                action="{{ route('admin.payments.update-status', $order->payment->id) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PUT')


                                <label class="field-label">
                                    Pilih Status Baru
                                </label>


                                <label class="radio-card selected">

                                    <span class="radio-left">

                                        <input
                                            checked
                                            type="radio"
                                            name="status"
                                            value="lunas"
                                        >

                                        <span>

                                            <strong>
                                                Verifikasi & Terima
                                            </strong>

                                            <small>
                                                Dana valid, teruskan pesanan ke dapur
                                            </small>

                                        </span>

                                    </span>

                                    <i class="fa-solid fa-circle-check"></i>

                                </label>


                                <label class="radio-card">

                                    <span class="radio-left">

                                        <input
                                            type="radio"
                                            name="status"
                                            value="verifikasi"
                                        >

                                        <span>

                                            <strong>
                                                Bukti Tidak Jelas / Buram
                                            </strong>

                                            <small>
                                                Pembayaran masih perlu diperiksa
                                            </small>

                                        </span>

                                    </span>

                                    <i class="fa-solid fa-circle-question"></i>

                                </label>


                                <label class="radio-card reject">

                                    <span class="radio-left">

                                        <input
                                            type="radio"
                                            name="status"
                                            value="gagal"
                                        >

                                        <span>

                                            <strong>
                                                Tolak Pembayaran
                                            </strong>

                                            <small>
                                                Nominal salah atau bukti tidak valid
                                            </small>

                                        </span>

                                    </span>

                                    <i class="fa-solid fa-circle-xmark"></i>

                                </label>


                                <div class="notes">

                                    <label
                                        class="field-label"
                                        for="notes"
                                    >
                                        Catatan Internal Admin (Opsional)
                                    </label>

                                    <textarea
                                        id="notes"
                                        name="catatan"
                                        rows="3"
                                        placeholder="Tambahkan catatan jika diperlukan..."
                                    ></textarea>

                                </div>


                                <button
                                    class="verify-button"
                                    type="submit"
                                >
                                    <i class="fa-solid fa-stamp"></i>
                                    Verifikasi Pembayaran Valid
                                </button>

                            </form>

                        @else

                            <div class="empty-payment">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                <strong>
                                    Belum ada data pembayaran
                                </strong>

                                <span>
                                    Pesanan ini belum memiliki data pembayaran.
                                </span>

                            </div>

                        @endif

                    </div>

                </section>

            </div>

        @endif


        {{-- Rincian Item --}}
        <section class="card order-items">

            <div class="items-header">

                <div class="header-title">

                    <div class="mini-icon cake">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>

                    <div>

                        <h3>
                            Rincian Item Dipesan
                        </h3>

                        <p>
                            Daftar lengkap produk yang dipesan oleh pelanggan
                            dalam pesanan ini
                        </p>

                    </div>

                </div>


                <div class="items-actions">

                    <span class="ready">
                        <i class="fa-solid fa-check"></i>
                        Semua Bahan Siap
                    </span>

                    <button type="button">
                        <i class="fa-solid fa-circle-check"></i>
                        Verifikasi Item Pesanan
                    </button>

                </div>

            </div>


            <div class="table-wrap">

                <table>

                    <thead>

                        <tr>
                            <th>Produk & Varian</th>
                            <th class="center">Jumlah</th>
                            <th class="right">Harga Satuan</th>
                            <th class="right">Subtotal</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($order->orderDetails as $detail)

                            <tr>

                                <td>

                                    <div class="product">

                                        <span class="product-icon cake-bg">
                                            <i class="fa-solid fa-cake-candles"></i>
                                        </span>

                                        <span>

                                            <strong>
                                                {{ $detail->product->nama_kue ?? 'Produk' }}
                                            </strong>

                                            <small>
                                                Produk Pesanan
                                            </small>

                                        </span>

                                    </div>

                                </td>


                                <td class="center">
                                    {{ $detail->jumlah }}x
                                </td>


                                <td class="right">
                                    Rp
                                    {{ number_format($detail->harga, 0, ',', '.') }}
                                </td>


                                <td class="right total-cell">
                                    Rp
                                    {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="empty-items"
                                >
                                    Tidak ada item pesanan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Footer Item --}}
            <div class="items-footer">

                <div class="pickup-info">

                    <p>

                        <i class="fa-solid fa-truck-pickup"></i>

                        Metode Pengambilan:

                        <strong>
                            {{ $order->metode_pengiriman ?? 'Diantar' }}
                        </strong>

                    </p>

                    <small>
                        Waktu estimasi pengambilan mengikuti data pesanan.
                    </small>


                    <div class="status-row">

                        <strong>

                            <i class="fa-regular fa-calendar-check"></i>

                            Status Pesanan & Dapur:

                        </strong>


                        <form
                            class="status-controls"
                            action="{{ route('admin.orders.update', $order->id) }}"
                            method="POST"
                        >

                            @csrf
                            @method('PUT')

                            <select name="status">

                                <option
                                    value="menunggu"
                                    {{ $order->status === 'menunggu' ? 'selected' : '' }}
                                >
                                    Menunggu
                                </option>

                                <option
                                    value="diproses"
                                    {{ $order->status === 'diproses' ? 'selected' : '' }}
                                >
                                    Diproses
                                </option>

                                <option
                                    value="siap"
                                    {{ $order->status === 'siap' ? 'selected' : '' }}
                                >
                                    Siap
                                </option>

                                <option
                                    value="selesai"
                                    {{ $order->status === 'selesai' ? 'selected' : '' }}
                                >
                                    Selesai
                                </option>

                                <option
                                    value="batal"
                                    {{ $order->status === 'batal' ? 'selected' : '' }}
                                >
                                    Batal
                                </option>

                            </select>


                            <button type="submit">

                                <i class="fa-solid fa-arrows-rotate"></i>

                                Update Status Pesanan

                            </button>

                        </form>


                        <span class="sync">

                            <i class="fa-solid fa-circle-check"></i>

                            Tersinkron otomatis ke dapur

                        </span>

                    </div>

                </div>


                <div class="price-summary">

                    <div>

                        <span>
                            Subtotal Produk
                            ({{ $order->orderDetails->sum('jumlah') }} pcs)
                        </span>

                        <strong>
                            Rp
                            {{ number_format($order->total_harga, 0, ',', '.') }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Biaya Pengiriman
                        </span>

                        <strong class="free">
                            Gratis
                        </strong>

                    </div>


                    <div>

                        <span>
                            Pajak Resto
                        </span>

                        <strong>
                            Sudah Termasuk
                        </strong>

                    </div>


                    <div class="grand-total">

                        <span>
                            Total yang harus dibayar
                        </span>

                        <strong>
                            Rp
                            {{ number_format($order->total_harga, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

            </div>

        </section>

    </div>

</div>

@endsection