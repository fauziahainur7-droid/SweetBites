@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')

<a href="{{ route('admin.payments.index') }}"
   class="btn btn-secondary mb-3">
    ← Kembali
</a>

<div class="card">

    <div class="card-body">

        <h2>Detail Pembayaran</h2>

        <p>
            <strong>Order:</strong>
            {{ $payment->order->kode_pesanan ?? '-' }}
        </p>

        <p>
            <strong>Pelanggan:</strong>
            {{ $payment->order->user->name ?? '-' }}
        </p>

        <p>
            <strong>Metode:</strong>
            {{ $payment->metode_pembayaran }}
        </p>

        <p>
            <strong>Total Bayar:</strong>
            Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}
        </p>

        <p>
            <strong>Status:</strong>

            @if($payment->status === 'lunas')

                <span class="badge bg-success">
                    Lunas
                </span>

            @elseif($payment->status === 'verifikasi')

                <span class="badge bg-primary">
                    Verifikasi
                </span>

            @elseif($payment->status === 'gagal')

                <span class="badge bg-danger">
                    Gagal
                </span>

            @else

                <span class="badge bg-warning text-dark">
                    Menunggu
                </span>

            @endif

        </p>

        <hr>

        <h2>
            Bukti Pembayaran
        </h2>

        @if($payment->bukti_pembayaran)

            <div class="mt-3">

                <img
                    src="{{ route('admin.payments.proof', ['id' => $payment->id]) }}"
                    alt="Bukti Pembayaran"
                    class="img-fluid rounded border"
                    style="max-width: 600px; max-height: 700px; object-fit: contain;"
                >

            </div>

        @else

            <div class="alert alert-secondary">
                Belum ada bukti pembayaran.
            </div>

        @endif

        <hr>

        <h2>
            Verifikasi Pembayaran
        </h2>

        <form
            action="{{ route('admin.payments.update-status', $payment->id) }}"
            method="POST"
            class="mt-3"
        >

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">

                    <label class="form-label">
                        Status Pembayaran
                    </label>

                    <select
                        name="status"
                        class="form-control"
                        required
                    >

                        <option
                            value="menunggu"
                            {{ $payment->status === 'menunggu' ? 'selected' : '' }}
                        >
                            Menunggu
                        </option>

                        <option
                            value="verifikasi"
                            {{ $payment->status === 'verifikasi' ? 'selected' : '' }}
                        >
                            Verifikasi
                        </option>

                        <option
                            value="lunas"
                            {{ $payment->status === 'lunas' ? 'selected' : '' }}
                        >
                            Lunas
                        </option>

                        <option
                            value="gagal"
                            {{ $payment->status === 'gagal' ? 'selected' : '' }}
                        >
                            Gagal
                        </option>

                    </select>

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-dark"
                    >
                        Update Status
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection