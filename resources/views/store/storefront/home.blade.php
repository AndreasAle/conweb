@extends('layouts.storefront')

@push('page-styles')
  /* Hero */
  .hero{position:relative;overflow:hidden;color:#fff;background:linear-gradient(150deg,var(--brand),var(--navy))}
  .hero.has-banner{background:none}
  .hero-banner{position:absolute;inset:0;z-index:0}
  .hero-banner img{width:100%;height:100%;object-fit:cover}
  .hero-banner::after{content:"";position:absolute;inset:0;background:linear-gradient(150deg,rgba(8,12,28,.74),rgba(8,12,28,.42))}
  .hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(circle at 80% -10%,rgba(255,255,255,.16),transparent 42%);pointer-events:none}
  .hero-in{position:relative;z-index:1;padding:68px 0 60px;display:flex;align-items:center;gap:26px;flex-wrap:wrap}
  .hero-logo{width:96px;height:96px;border-radius:22px;object-fit:cover;border:3px solid rgba(255,255,255,.55);background:#fff;flex-shrink:0;box-shadow:0 14px 36px rgba(0,0,0,.28)}
  .hero-txt{flex:1;min-width:280px}
  .badge-official{display:inline-flex;align-items:center;gap:7px;font-family:var(--display);font-weight:600;font-size:12px;letter-spacing:.04em;padding:6px 13px;border-radius:99px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.28);color:#fff;backdrop-filter:blur(6px);margin-bottom:14px}
  .badge-official svg{width:14px;height:14px}
  .hero-txt h1{color:#fff;font-size:clamp(29px,5vw,44px);margin-bottom:10px;line-height:1.1}
  .hero-txt p{color:rgba(255,255,255,.92);font-size:16.5px;max-width:580px;margin-bottom:22px}
  .hero-cta{display:flex;gap:12px;flex-wrap:wrap}
  /* Trust strip */
  .trust{border-bottom:1px solid var(--line);background:#fff}
  .trust-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;padding:0}
  .trust-card{display:flex;align-items:center;gap:13px;padding:22px 20px;border-right:1px solid var(--line)}
  .trust-card:last-child{border-right:none}
  .trust-ic{width:42px;height:42px;border-radius:12px;flex-shrink:0;display:grid;place-items:center;background:var(--soft);color:var(--brand)}
  .trust-ic svg{width:21px;height:21px}
  .trust-card b{display:block;font-family:var(--display);font-size:14px;color:var(--ink);line-height:1.25}
  .trust-card span{font-size:12.5px;color:var(--muted)}
  /* Categories — scroll horizontal di mobile */
  .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px}
  .cat-chip{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:17px 19px;border:1px solid var(--line);border-radius:14px;background:#fff;transition:.2s;font-family:var(--display);font-weight:600;color:var(--ink)}
  .cat-chip:hover{border-color:var(--brand);color:var(--brand);transform:translateY(-2px);box-shadow:var(--shadow-sm)}
  .cat-chip span{font-size:12px;color:var(--muted);font-weight:600;background:var(--soft);padding:2px 9px;border-radius:99px}
  .mkt-row{display:flex;gap:12px;flex-wrap:wrap;margin-top:8px}
  .mkt-row a{display:inline-flex;align-items:center;gap:8px;padding:11px 17px;border:1px solid var(--line-2);border-radius:12px;font-family:var(--display);font-weight:600;font-size:13.5px;color:var(--ink-2)}
  .mkt-row a:hover{border-color:var(--brand);color:var(--brand)}
  @media(max-width:860px){.trust-grid{grid-template-columns:1fr 1fr}.trust-card:nth-child(2){border-right:none}.trust-card{border-bottom:1px solid var(--line)}}
  @media(max-width:560px){
    .cat-grid{display:flex;overflow-x:auto;gap:11px;padding-bottom:6px;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch}
    .cat-grid::-webkit-scrollbar{display:none}
    .cat-chip{flex:0 0 auto;min-width:150px;scroll-snap-align:start}
  }
@endpush

@section('content')
<section class="hero {{ $store->banner ? 'has-banner' : '' }}">
  @if($store->banner)<div class="hero-banner"><img src="{{ $store->banner_url }}" alt=""></div>@endif
  <div class="wrap hero-in">
    @if($store->logo)<img src="{{ $store->logo_url }}" class="hero-logo" alt="{{ $store->name }}">@endif
    <div class="hero-txt">
      <span class="badge-official">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.4 8.5 8 10 4.6-1.5 8-5 8-10V5l-8-3Z"/><path d="m9 12 2 2 4-4"/></svg>
        Official Store
      </span>
      <h1>{{ $store->name }}</h1>
      @if($store->tagline)<p>{{ $store->tagline }}</p>@elseif($store->description)<p>{{ Str::limit(strip_tags($store->description),150) }}</p>@endif
      <div class="hero-cta">
        <a href="{{ route('store.products', $store->slug) }}" class="btn btn-primary">Lihat Produk</a>
        <a href="{{ $store->whatsapp_checkout_url }}" target="_blank" rel="noopener" class="btn btn-wa">Chat via WhatsApp</a>
      </div>
    </div>
  </div>
</section>

<section class="trust">
  <div class="wrap">
    <div class="trust-grid">
      <div class="trust-card">
        <span class="trust-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M9.5 9.5a2.5 2.5 0 0 1 4.5 1.5c0 1.5-2 2-2 3.5"/><path d="M12 17.5h.01"/></svg></span>
        <div><b>0% biaya admin</b><span>dari Conweb</span></div>
      </div>
      <div class="trust-card">
        <span class="trust-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.4 8.4 0 0 1-12.3 7.4L3 21l2.1-5.7A8.4 8.4 0 1 1 21 11.5Z"/></svg></span>
        <div><b>Order via WhatsApp</b><span>langsung ke owner</span></div>
      </div>
      <div class="trust-card">
        <span class="trust-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 12 2 2 4-4"/><path d="M12 2 4 5v6c0 5 3.4 8.5 8 10 4.6-1.5 8-5 8-10V5l-8-3Z"/></svg></span>
        <div><b>Produk original</b><span>asli dari UMKM</span></div>
      </div>
      <div class="trust-card">
        <span class="trust-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 3 14h7l-1 8 10-12h-7l1-8Z"/></svg></span>
        <div><b>Respon cepat</b><span>bisnis lokal terpercaya</span></div>
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

@if($store->shopee_url || $store->tokopedia_url || $store->tiktok_url)
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
