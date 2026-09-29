@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<h2>Manajemen Pesanan</h2>

<div class="row mb-3">
    <div class="col-md-3">
        <select class="form-control">
            <option>Semua Status</option>
            <option>Menunggu</option>
            <option>Diproses</option>
            <option>Siap</option>
            <option>Selesai</option>
            <option>Batal</option>
        </select>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Cari Pesanan...">
    </div>
</div>

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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->kode_pesanan }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'batal' ? 'danger' : 'warning') }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-dark btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</div>
@endsection