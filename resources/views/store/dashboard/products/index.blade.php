@extends('layouts.store-dashboard')
@section('title', 'Produk')

@section('content')
<div class="page-head">
  <div>
    <h1>Produk</h1>
    <p>{{ $products->total() }} produk di toko Anda.</p>
  </div>
  <a href="{{ route('store-dashboard.products.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Tambah Produk
  </a>
</div>

<form method="GET" style="margin-bottom:18px;display:flex;gap:10px;max-width:420px">
  <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..." style="flex:1;padding:11px 14px;border-radius:11px;border:1px solid var(--line-2);font-family:var(--sans)">
  <button class="btn btn-line">Cari</button>
</form>

<div class="card">
  @if($products->isEmpty())
    <div class="empty">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
      <h3>Belum ada produk</h3>
      <p>Tambahkan produk pertama Anda untuk mulai berjualan.</p>
      <a href="{{ route('store-dashboard.products.create') }}" class="btn btn-primary" style="margin-top:14px">Tambah Produk</a>
    </div>
  @else
    <div class="table-wrap">
      <table class="tbl">
        <thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @foreach($products as $p)
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:12px">
                <img src="{{ $p->product_image_url }}" alt="" style="width:44px;height:44px;border-radius:9px;object-fit:cover;border:1px solid var(--line)">
                <div>
                  <strong>{{ $p->name }}</strong>
                  @if($p->is_featured)<span class="badge badge-blue" style="margin-left:6px">Unggulan</span>@endif
                </div>
              </div>
            </td>
            <td>{{ $p->category?->name ?? '—' }}</td>
            <td>
              {{ formatRupiah($p->price) }}
              @if($p->is_on_sale)<br><span style="font-size:12px;color:var(--muted);text-decoration:line-through">{{ formatRupiah($p->compare_price) }}</span>@endif
            </td>
            <td>{{ $p->stock === null ? '∞' : $p->stock }}</td>
            <td>
              @if($p->is_active)<span class="badge badge-green">Aktif</span>@else<span class="badge badge-gray">Nonaktif</span>@endif
            </td>
            <td>
              <div style="display:flex;gap:6px;justify-content:flex-end">
                <a href="{{ route('store-dashboard.products.edit', $p) }}" class="btn btn-line btn-sm">Edit</a>
                <form method="POST" action="{{ route('store-dashboard.products.destroy', $p) }}" onsubmit="return confirm('Hapus produk ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

{{ $products->links('store.partials.pagination') }}
@endsection
