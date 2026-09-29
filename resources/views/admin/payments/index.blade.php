@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<h2>Manajemen Pembayaran</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No.Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->order->kode_pesanan ?? '-' }}</td>
                        <td>{{ $payment->order->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $payment->status == 'lunas' ? 'success' : ($payment->status == 'gagal' ? 'danger' : 'warning') }}">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td>{{ $payment->metode_pembayaran }}</td>
                        <td>
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('admin.payments.update-status', $payment->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <select name="status" class="form-control-sm">
                                    <option value="menunggu">Menunggu</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                                <button type="submit" class="btn btn-dark btn-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection