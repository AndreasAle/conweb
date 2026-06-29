@extends('layouts.store-dashboard')
@section('title', 'Overview')

@section('content')
<div class="page-head">
  <div>
    <h1>Halo, {{ $store->name }} 👋</h1>
    <p>Ringkasan toko Anda hari ini.</p>
  </div>
  <a href="{{ route('store-dashboard.products.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Tambah Produk
  </a>
</div>

<div class="stat-grid">
  <div class="stat">
    <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></div>
    <b>{{ $stats['products'] }}</b>
    <span>Total Produk</span>
  </div>
  <div class="stat">
    <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div>
    <b>{{ $stats['orders'] }}</b>
    <span>Total Pesanan</span>
  </div>
  <div class="stat">
    <div class="ic" style="background:rgba(245,158,11,.13);color:#b45309"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
    <b>{{ $stats['pending'] }}</b>
    <span>Pesanan Pending</span>
  </div>
  <div class="stat">
    <div class="ic" style="background:rgba(34,197,94,.12);color:#15803d"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
    <b style="font-size:21px">{{ formatRupiah($stats['revenue']) }}</b>
    <span>Estimasi Omzet</span>
  </div>
</div>

<div class="card">
  <div class="card-pad" style="display:flex;align-items:center;justify-content:space-between">
    <h3 style="font-size:17px">Pesanan Terbaru</h3>
    <a href="{{ route('store-dashboard.orders.index') }}" class="btn btn-line btn-sm">Lihat Semua</a>
  </div>
  @if($recentOrders->isEmpty())
    <div class="empty">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <h3>Belum ada pesanan</h3>
      <p>Pesanan dari customer akan tampil di sini.</p>
    </div>
  @else
    <div class="table-wrap">
      <table class="tbl">
        <thead><tr><th>Kode</th><th>Customer</th><th>Total</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
        @foreach($recentOrders as $o)
          <tr>
            <td><strong>{{ $o->order_code }}</strong></td>
            <td>{{ $o->customer_name }}</td>
            <td>{{ formatRupiah($o->total) }}</td>
            <td>@include('store.dashboard.partials.status-badge', ['status' => $o->status])</td>
            <td>{{ $o->created_at->format('d M Y') }}</td>
            <td><a href="{{ route('store-dashboard.orders.show', $o) }}" class="btn btn-line btn-sm">Detail</a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
