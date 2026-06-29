@extends('layouts.storefront')
@section('title', ($activeCategory?->name ?? 'Semua Produk').' — '.$store->name)

@push('page-styles')
  .shop-head{padding:36px 0 8px}
  .shop-head h1{font-size:clamp(24px,4vw,34px)}
  .filters{display:flex;gap:10px;flex-wrap:wrap;margin:22px 0 30px;align-items:center}
  .filters .chip{font-family:var(--display);font-size:13.5px;font-weight:600;padding:9px 15px;border-radius:99px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2)}
  .filters .chip.active,.filters .chip:hover{background:var(--brand);color:#fff;border-color:var(--brand)}
  .search-box{display:flex;gap:8px;margin-left:auto}
  .search-box input{padding:10px 14px;border-radius:11px;border:1px solid var(--line-2);font-family:var(--sans);font-size:14px;min-width:180px}
  @media(max-width:600px){.search-box{margin-left:0;width:100%}.search-box input{flex:1}}
@endpush

@section('content')
<div class="wrap shop-head">
  <h1>{{ $activeCategory?->name ?? 'Semua Produk' }}</h1>
  <div class="filters">
    <a href="{{ route('store.products', $store->slug) }}" class="chip {{ ! $activeCategory ? 'active' : '' }}">Semua</a>
    @foreach($categories as $cat)
      <a href="{{ route('store.products', [$store->slug, 'category' => $cat->slug]) }}" class="chip {{ $activeCategory?->id === $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
    @endforeach
    <form method="GET" class="search-box">
      @if($activeCategory)<input type="hidden" name="category" value="{{ $activeCategory->slug }}">@endif
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk...">
      <button class="btn btn-line btn-sm">Cari</button>
    </form>
  </div>
</div>

<div class="wrap" style="padding-bottom:50px">
  @if($products->isEmpty())
    <div class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      <h3>Produk tidak ditemukan</h3>
      <p>Coba kata kunci atau kategori lain.</p>
    </div>
  @else
    <div class="prod-grid">
      @foreach($products as $product)
        @include('store.storefront.partials.product-card')
      @endforeach
    </div>
    {{ $products->links('store.partials.pagination') }}
  @endif
</div>
@endsection
