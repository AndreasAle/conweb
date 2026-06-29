@extends('layouts.store-dashboard')
@section('title', 'Pesanan')

@section('content')
<div class="page-head">
  <div>
    <h1>Pesanan</h1>
    <p>{{ $orders->total() }} pesanan masuk.</p>
  </div>
</div>

<form method="GET" style="margin-bottom:18px;display:flex;gap:10px;flex-wrap:wrap">
  <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode / nama / no. HP" style="flex:1;min-width:200px;padding:11px 14px;border-radius:11px;border:1px solid var(--line-2);font-family:var(--sans)">
  <select name="status" style="padding:11px 14px;border-radius:11px;border:1px solid var(--line-2);font-family:var(--sans)">
    <option value="">Semua status</option>
    @foreach(\App\Models\StoreOrder::STATUSES as $st)
      <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
    @endforeach
  </select>
  <button class="btn btn-line">Filter</button>
</form>

<div class="card">
  @if($orders->isEmpty())
    <div class="empty">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <h3>Belum ada pesanan</h3>
      <p>Pesanan yang masuk lewat checkout WhatsApp akan tampil di sini.</p>
    </div>
  @else
    <div class="table-wrap">
      <table class="tbl">
        <thead><tr><th>Kode</th><th>Customer</th><th>Item</th><th>Total</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
        @foreach($orders as $o)
          <tr>
            <td><strong>{{ $o->order_code }}</strong></td>
            <td>{{ $o->customer_name }}<br><span style="font-size:12px;color:var(--muted)">{{ $o->customer_phone }}</span></td>
            <td>{{ $o->items_count }}</td>
            <td>{{ formatRupiah($o->total) }}</td>
            <td>@include('store.dashboard.partials.status-badge', ['status' => $o->status])</td>
            <td>{{ $o->created_at->format('d M Y H:i') }}</td>
            <td><a href="{{ route('store-dashboard.orders.show', $o) }}" class="btn btn-line btn-sm">Detail</a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

{{ $orders->links('store.partials.pagination') }}
@endsection
