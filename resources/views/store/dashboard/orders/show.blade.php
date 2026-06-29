@extends('layouts.store-dashboard')
@section('title', 'Detail Pesanan')

@section('content')
<div class="page-head">
  <div>
    <h1>{{ $order->order_code }}</h1>
    <p>Dibuat {{ $order->created_at->format('d M Y, H:i') }}</p>
  </div>
  <a href="{{ route('store-dashboard.orders.index') }}" class="btn btn-line">Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:20px" class="order-grid">
  <div>
    <div class="card" style="margin-bottom:20px">
      <div class="card-pad"><h3 style="font-size:16px">Item Pesanan</h3></div>
      <div class="table-wrap">
        <table class="tbl">
          <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
          <tbody>
          @foreach($order->items as $it)
            <tr>
              <td><strong>{{ $it->product_name }}</strong></td>
              <td>{{ formatRupiah($it->product_price) }}</td>
              <td>{{ $it->quantity }}</td>
              <td>{{ formatRupiah($it->subtotal) }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-pad" style="border-top:1px solid var(--line)">
        <div style="display:flex;justify-content:space-between;margin-bottom:6px"><span>Subtotal</span><strong>{{ formatRupiah($order->subtotal) }}</strong></div>
        @if($order->discount_amount > 0)
          <div style="display:flex;justify-content:space-between;margin-bottom:6px;color:#15803d"><span>Diskon</span><strong>− {{ formatRupiah($order->discount_amount) }}</strong></div>
        @endif
        <div style="display:flex;justify-content:space-between;font-size:18px;margin-top:8px;padding-top:10px;border-top:1px dashed var(--line-2)"><strong>Total</strong><strong style="color:var(--brand-d)">{{ formatRupiah($order->total) }}</strong></div>
      </div>
    </div>

    <div class="card card-pad">
      <h3 style="font-size:16px;margin-bottom:14px">Data Customer</h3>
      <div style="display:grid;gap:10px;font-size:14px">
        <div><span style="color:var(--muted)">Nama:</span> <strong>{{ $order->customer_name }}</strong></div>
        <div><span style="color:var(--muted)">No. WA:</span> {{ $order->customer_phone }}</div>
        @if($order->customer_email)<div><span style="color:var(--muted)">Email:</span> {{ $order->customer_email }}</div>@endif
        @if($order->customer_address)<div><span style="color:var(--muted)">Alamat:</span> {{ $order->customer_address }}</div>@endif
        @if($order->customer_note)<div><span style="color:var(--muted)">Catatan:</span> {{ $order->customer_note }}</div>@endif
      </div>
      <a href="{{ whatsappUrl($order->customer_phone, 'Halo '.$order->customer_name.', terima kasih sudah order ('.$order->order_code.') di '.$store->name.'.') }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm" style="margin-top:16px">
        Chat Customer
      </a>
    </div>
  </div>

  <div>
    <div class="card card-pad">
      <h3 style="font-size:16px;margin-bottom:14px">Update Status</h3>
      <form method="POST" action="{{ route('store-dashboard.orders.status', $order) }}">
        @csrf @method('PATCH')
        <div class="form-row">
          <label>Status Pesanan</label>
          <select name="status">
            @foreach(\App\Models\StoreOrder::STATUSES as $st)
              <option value="{{ $st }}" @selected($order->status===$st)>{{ ucfirst($st) }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-row">
          <label>Status Pembayaran</label>
          <select name="payment_status">
            @foreach(\App\Models\StoreOrder::PAYMENT_STATUSES as $ps)
              <option value="{{ $ps }}" @selected($order->payment_status===$ps)>{{ str_replace('_',' ',ucfirst($ps)) }}</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-primary btn-block" style="width:100%">Simpan Status</button>
      </form>
    </div>
  </div>
</div>

@push('styles')<style>@media(max-width:860px){.order-grid{grid-template-columns:1fr!important}}</style>@endpush
@endsection
