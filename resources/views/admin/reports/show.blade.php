@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<a href="{{ route('admin.reports.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

<div class="card">
    <div class="card-body">
        <h3>{{ $report->judul }}</h3>
        <p><strong>Periode:</strong> {{ $report->periode_mulai }} - {{ $report->periode_selesai }}</p>
        <p><strong>Total Penjualan:</strong> Rp {{ number_format($report->total_penjualan, 0, ',', '.') }}</p>
        <p><strong>Dibuat:</strong> {{ $report->created_at->format('d/m/Y H:i') }}</p>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection