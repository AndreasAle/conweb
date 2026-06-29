@extends('layouts.storefront')

@push('page-styles')
  .hero{position:relative;overflow:hidden;color:#fff;background:linear-gradient(150deg,var(--brand),var(--navy))}
  .hero.has-banner{background:none}
  .hero-banner{position:absolute;inset:0;z-index:0}
  .hero-banner img{width:100%;height:100%;object-fit:cover}
  .hero-banner::after{content:"";position:absolute;inset:0;background:linear-gradient(150deg,rgba(0,0,0,.62),rgba(0,0,0,.32))}
  .hero-in{position:relative;z-index:1;padding:64px 0;display:flex;align-items:center;gap:22px;flex-wrap:wrap}
  .hero-logo{width:92px;height:92px;border-radius:20px;object-fit:cover;border:3px solid rgba(255,255,255,.5);background:#fff;flex-shrink:0}
  .hero-txt h1{color:#fff;font-size:clamp(28px,5vw,42px);margin-bottom:8px}
  .hero-txt p{color:rgba(255,255,255,.9);font-size:16.5px;max-width:560px;margin-bottom:18px}
  .hero-cta{display:flex;gap:12px;flex-wrap:wrap}
  .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:14px}
  .cat-chip{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:16px 18px;border:1px solid var(--line);border-radius:13px;background:#fff;transition:.2s;font-family:var(--display);font-weight:600;color:var(--ink)}
  .cat-chip:hover{border-color:var(--brand);color:var(--brand);transform:translateY(-2px)}
  .cat-chip span{font-size:12px;color:var(--muted);font-weight:500}
  .mkt-row{display:flex;gap:12px;flex-wrap:wrap;margin-top:8px}
  .mkt-row a{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border:1px solid var(--line-2);border-radius:11px;font-family:var(--display);font-weight:600;font-size:13.5px;color:var(--ink-2)}
  .mkt-row a:hover{border-color:var(--brand);color:var(--brand)}
@endpush

@section('content')
<section class="hero {{ $store->banner ? 'has-banner' : '' }}">
  @if($store->banner)<div class="hero-banner"><img src="{{ $store->banner_url }}" alt=""></div>@endif
  <div class="wrap hero-in">
    @if($store->logo)<img src="{{ $store->logo_url }}" class="hero-logo" alt="{{ $store->name }}">@endif
    <div class="hero-txt">
      <h1>{{ $store->name }}</h1>
      @if($store->tagline)<p>{{ $store->tagline }}</p>@elseif($store->description)<p>{{ Str::limit(strip_tags($store->description),150) }}</p>@endif
      <div class="hero-cta">
        <a href="{{ route('store.products', $store->slug) }}" class="btn btn-primary">Lihat Produk</a>
        <a href="{{ $store->whatsapp_checkout_url }}" target="_blank" rel="noopener" class="btn btn-wa">Chat via WhatsApp</a>
      </div>
    </div>
  </div>
</section>

@if($categories->isNotEmpty())
<section class="sec">
  <div class="wrap">
    <div class="sec-head"><h2>Kategori</h2></div>
    <div class="cat-grid">
      @foreach($categories as $cat)
        <a href="{{ route('store.products', [$store->slug, 'category' => $cat->slug]) }}" class="cat-chip">
          {{ $cat->name }} <span>{{ $cat->products_count }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($featured->isNotEmpty())
<section class="sec" style="background:var(--soft)">
  <div class="wrap">
    <div class="sec-head"><h2>Produk Unggulan</h2><a href="{{ route('store.products', $store->slug) }}" class="btn btn-line btn-sm">Semua</a></div>
    <div class="prod-grid">
      @foreach($featured as $product)
        @include('store.storefront.partials.product-card')
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="sec">
  <div class="wrap">
    <div class="sec-head"><h2>{{ $featured->isNotEmpty() ? 'Produk Terbaru' : 'Produk Kami' }}</h2></div>
    @if($latest->isEmpty())
      <div class="empty-state">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
        <h3>Belum ada produk</h3>
        <p>Produk akan segera hadir. Hubungi kami via WhatsApp untuk info.</p>
      </div>
    @else
      <div class="prod-grid">
        @foreach($latest as $product)
          @include('store.storefront.partials.product-card')
        @endforeach
      </div>
    @endif
  </div>
</section>

@if($store->shopee_url || $store->tokopedia_url)
<section class="sec" style="padding-top:0">
  <div class="wrap">
    <div class="sec-head"><h2 style="font-size:20px">Temukan kami juga di</h2></div>
    <div class="mkt-row">
      @if($store->shopee_url)<a href="{{ $store->shopee_url }}" target="_blank" rel="noopener">Shopee</a>@endif
      @if($store->tokopedia_url)<a href="{{ $store->tokopedia_url }}" target="_blank" rel="noopener">Tokopedia</a>@endif
      @if($store->tiktok_url)<a href="{{ $store->tiktok_url }}" target="_blank" rel="noopener">TikTok Shop</a>@endif
    </div>
  </div>
</section>
@endif
@endsection
