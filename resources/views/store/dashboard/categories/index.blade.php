@extends('layouts.store-dashboard')
@section('title', 'Kategori')

@section('content')
<div class="page-head">
  <div>
    <h1>Kategori Produk</h1>
    <p>Kelompokkan produk agar mudah dicari customer.</p>
  </div>
  <a href="{{ route('store-dashboard.categories.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Tambah Kategori
  </a>
</div>

<div class="card">
  @if($categories->isEmpty())
    <div class="empty">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      <h3>Belum ada kategori</h3>
      <p>Buat kategori pertama untuk menata produk Anda.</p>
      <a href="{{ route('store-dashboard.categories.create') }}" class="btn btn-primary" style="margin-top:14px">Tambah Kategori</a>
    </div>
  @else
    <div class="table-wrap">
      <table class="tbl">
        <thead><tr><th>Nama</th><th>Jumlah Produk</th><th>Urutan</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @foreach($categories as $c)
          <tr>
            <td><strong>{{ $c->name }}</strong></td>
            <td><span class="badge badge-gray">{{ $c->products_count }}</span></td>
            <td>{{ $c->sort_order }}</td>
            <td>@if($c->is_active)<span class="badge badge-green">Aktif</span>@else<span class="badge badge-gray">Nonaktif</span>@endif</td>
            <td>
              <div style="display:flex;gap:6px;justify-content:flex-end">
                <a href="{{ route('store-dashboard.categories.edit', $c) }}" class="btn btn-line btn-sm">Edit</a>
                <form method="POST" action="{{ route('store-dashboard.categories.destroy', $c) }}" onsubmit="return confirm('Hapus kategori ini? Produk terkait tidak ikut terhapus.')">
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

{{ $categories->links('store.partials.pagination') }}
@endsection
