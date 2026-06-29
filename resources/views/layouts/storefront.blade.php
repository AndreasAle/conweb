<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @php
    $cartCount = app(\App\Services\Store\CartService::class)->count($store);
    $primary = $store->primary_color ?: '#2563eb';
    $secondary = $store->secondary_color ?: '#0a1530';
    $metaTitle = trim($store->meta_title) ?: ($store->name.($store->tagline ? ' — '.$store->tagline : ''));
    $metaDesc = trim($store->meta_description) ?: \Illuminate\Support\Str::limit(strip_tags($store->description ?? ''), 155) ?: ('Toko online '.$store->name.'. Pesan langsung via WhatsApp.');
    $canonical = url('/store/'.$store->slug);
  @endphp
  <title>@yield('title', $metaTitle)</title>
  <meta name="description" content="@yield('description', $metaDesc)">
  <link rel="canonical" href="{{ $canonical }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ $store->name }}">
  <meta property="og:title" content="@yield('title', $metaTitle)">
  <meta property="og:description" content="@yield('description', $metaDesc)">
  <meta property="og:url" content="{{ $canonical }}">
  @if($store->logo)<meta property="og:image" content="{{ $store->logo_url }}">@endif
  <meta name="twitter:card" content="summary">
  @if($store->logo)<link rel="icon" href="{{ $store->logo_url }}" sizes="any">@endif
  @stack('head')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root{
      --brand:{{ $primary }};--navy:{{ $secondary }};
      --ink:#0a1633;--ink-2:#1c2a4a;--body:#4b5a78;--muted:#8190ab;--line:#e9eef7;--line-2:#dde5f2;
      --bg:#fff;--soft:#f6f8fc;--ok:#22c55e;--danger:#ef4444;
      --shadow-sm:0 1px 2px rgba(13,30,70,.06),0 2px 8px rgba(13,30,70,.05);
      --shadow:0 14px 36px rgba(13,30,70,.1),0 2px 8px rgba(13,30,70,.05);
      --radius:16px;--radius-sm:11px;--container:1140px;--nav-h:70px;
      --display:'Space Grotesk',sans-serif;--sans:'Plus Jakarta Sans',sans-serif;
    }
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{font-family:var(--sans);color:var(--body);background:var(--bg);line-height:1.65;-webkit-font-smoothing:antialiased;overflow-x:hidden}
    a{color:inherit;text-decoration:none}
    button{font:inherit;border:none;background:none;cursor:pointer;color:inherit}
    img,svg{display:block;max-width:100%}
    h1,h2,h3,h4{font-family:var(--display);color:var(--ink);font-weight:700;line-height:1.18;letter-spacing:-.02em}
    .wrap{width:min(100% - 36px,var(--container));margin-inline:auto}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;font-family:var(--display);font-weight:600;font-size:14.5px;padding:12px 20px;border-radius:12px;transition:.25s;white-space:nowrap}
    .btn svg{width:18px;height:18px}
    .btn-primary{background:var(--brand);color:#fff;box-shadow:0 10px 22px rgba(0,0,0,.13)}
    .btn-primary:hover{filter:brightness(.94);transform:translateY(-2px)}
    .btn-line{background:#fff;color:var(--ink);border:1px solid var(--line-2)}
    .btn-line:hover{border-color:var(--brand);color:var(--brand)}
    .btn-wa{background:#25d366;color:#fff}
    .btn-wa:hover{filter:brightness(.95);transform:translateY(-2px)}
    .btn-block{width:100%}
    .btn-sm{padding:9px 14px;font-size:13px;border-radius:10px}
    .badge{display:inline-flex;align-items:center;font-family:var(--display);font-size:11.5px;font-weight:700;padding:4px 9px;border-radius:7px}
    .badge-sale{background:var(--danger);color:#fff}
    /* Nav */
    .nav{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.92);backdrop-filter:blur(14px);border-bottom:1px solid var(--line)}
    .nav-in{height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;gap:16px}
    .brand{display:flex;align-items:center;gap:11px;font-family:var(--display);font-weight:700;color:var(--ink);font-size:18px}
    .brand img{width:40px;height:40px;border-radius:11px;object-fit:cover;border:1px solid var(--line)}
    .brand .mk{width:40px;height:40px;border-radius:11px;display:grid;place-items:center;background:var(--brand);color:#fff;font-family:var(--display);font-weight:700;flex-shrink:0}
    .nav-links{display:flex;align-items:center;gap:22px}
    .nav-links a{font-size:14.5px;font-weight:500;color:var(--ink-2)}
    .nav-links a:hover,.nav-links a.active{color:var(--brand)}
    .nav-right{display:flex;align-items:center;gap:12px}
    .cart-btn{position:relative;width:44px;height:44px;border-radius:12px;border:1px solid var(--line-2);display:grid;place-items:center;color:var(--ink)}
    .cart-btn:hover{border-color:var(--brand);color:var(--brand)}
    .cart-btn svg{width:21px;height:21px}
    .cart-count{position:absolute;top:-6px;right:-6px;min-width:20px;height:20px;padding:0 5px;border-radius:99px;background:var(--brand);color:#fff;font-family:var(--display);font-size:11px;font-weight:700;display:grid;place-items:center}
    .nav-links-m{display:none}
    /* Footer */
    .sf-foot{background:var(--navy);color:rgba(255,255,255,.72);padding:48px 0 26px;margin-top:60px}
    .sf-foot-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr;gap:34px;padding-bottom:32px;border-bottom:1px solid rgba(255,255,255,.12)}
    .sf-foot h4{color:#fff;font-size:15px;margin-bottom:14px}
    .sf-foot p{font-size:14px;max-width:320px}
    .sf-foot a{font-size:14px;color:rgba(255,255,255,.72);display:block;padding:4px 0}
    .sf-foot a:hover{color:#fff}
    .sf-social{display:flex;gap:10px;margin-top:14px}
    .sf-social a{width:40px;height:40px;border-radius:11px;background:rgba(255,255,255,.08);display:grid;place-items:center;padding:0}
    .sf-social a svg{width:18px;height:18px}
    .sf-social a:hover{background:var(--brand)}
    .sf-bottom{padding-top:20px;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;font-size:13px;color:rgba(255,255,255,.55)}
    .sf-bottom a{color:#fff;font-weight:600}
    /* Alerts */
    .flash{position:fixed;top:84px;left:50%;transform:translateX(-50%);z-index:60;padding:13px 20px;border-radius:12px;font-size:14px;font-weight:500;box-shadow:var(--shadow);max-width:90vw}
    .flash-success{background:#ecfdf3;border:1px solid #abefc6;color:#067647}
    .flash-error{background:#fef3f2;border:1px solid #fecdca;color:#b42318}
    /* Generic cards/grids reused by pages */
    .sec{padding:48px 0}
    .sec-head{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:26px}
    .sec-head h2{font-size:clamp(22px,3vw,30px)}
    .prod-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
    .pcard{background:#fff;border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;transition:.25s;display:flex;flex-direction:column}
    .pcard:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:var(--line-2)}
    .pcard .thumb{aspect-ratio:1;background:var(--soft);position:relative;overflow:hidden}
    .pcard .thumb img{width:100%;height:100%;object-fit:cover}
    .pcard .thumb .badge-sale{position:absolute;top:10px;left:10px}
    .pcard .body{padding:14px 15px 16px;display:flex;flex-direction:column;flex:1}
    .pcard h3{font-size:15px;margin-bottom:6px;line-height:1.35}
    .pcard .price{font-family:var(--display);font-weight:700;color:var(--ink);font-size:16px}
    .pcard .price s{color:var(--muted);font-weight:500;font-size:13px;margin-left:6px}
    .pcard .acts{margin-top:auto;padding-top:12px;display:flex;gap:8px}
    .empty-state{text-align:center;padding:60px 20px;color:var(--muted)}
    .empty-state svg{width:54px;height:54px;margin:0 auto 16px;color:var(--line-2)}
    .empty-state h3{color:var(--ink-2);font-size:19px;margin-bottom:6px}
    .pagination{display:flex;gap:6px;flex-wrap:wrap;margin-top:28px;justify-content:center}
    .pagination span,.pagination a{font-family:var(--display);font-size:13.5px;font-weight:600;padding:9px 14px;border-radius:10px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2)}
    .pagination .active span{background:var(--brand);color:#fff;border-color:var(--brand)}
    .pagination [aria-disabled] span{opacity:.4}
    @media(max-width:900px){.prod-grid{grid-template-columns:repeat(3,1fr)}.sf-foot-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:700px){.nav-links{display:none}.prod-grid{grid-template-columns:repeat(2,1fr)}.sf-foot-grid{grid-template-columns:1fr;gap:24px}}
    @media(max-width:420px){.prod-grid{grid-template-columns:1fr 1fr;gap:12px}}
    @stack('page-styles')
  </style>
</head>
<body>
  <nav class="nav">
    <div class="wrap nav-in">
      <a href="{{ route('store.home', $store->slug) }}" class="brand">
        @if($store->logo)
          <img src="{{ $store->logo_url }}" alt="{{ $store->name }}">
        @else
          <span class="mk">{{ strtoupper(substr($store->name,0,1)) }}</span>
        @endif
        <span>{{ Str::limit($store->name, 22) }}</span>
      </a>
      <div class="nav-links">
        <a href="{{ route('store.home', $store->slug) }}" class="{{ request()->routeIs('store.home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('store.products', $store->slug) }}" class="{{ request()->routeIs('store.products') || request()->routeIs('store.product') ? 'active' : '' }}">Produk</a>
      </div>
      <div class="nav-right">
        <a href="{{ $store->whatsapp_checkout_url }}" target="_blank" rel="noopener" class="btn btn-wa btn-sm" style="display:none" id="wa-nav">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
          WhatsApp
        </a>
        <a href="{{ route('store.cart', $store->slug) }}" class="cart-btn" aria-label="Keranjang">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
          @if($cartCount > 0)<span class="cart-count">{{ $cartCount }}</span>@endif
        </a>
      </div>
    </div>
  </nav>

  @if(session('success'))<div class="flash flash-success" id="flash">{{ session('success') }}</div>@endif
  @if(session('error'))<div class="flash flash-error" id="flash">{{ session('error') }}</div>@endif

  @yield('content')

  <footer class="sf-foot">
    <div class="wrap">
      <div class="sf-foot-grid">
        <div>
          <h4>{{ $store->name }}</h4>
          @if($store->description)<p>{{ Str::limit(strip_tags($store->description), 160) }}</p>@endif
          <div class="sf-social">
            @if($store->instagram_url)<a href="{{ $store->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/></svg></a>@endif
            @if($store->tiktok_url)<a href="{{ $store->tiktok_url }}" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.6 6.3a5 5 0 0 1-3.8-3.1V2h-3v13.8a2.6 2.6 0 1 1-2.6-2.6c.2 0 .4 0 .6.1V10a5.6 5.6 0 1 0 5 5.6V8.5a8 8 0 0 0 3.8 1V6.3z"/></svg></a>@endif
            @if($store->shopee_url)<a href="{{ $store->shopee_url }}" target="_blank" rel="noopener" aria-label="Shopee"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h18l-1.5 13a2 2 0 0 1-2 1.8H6.5a2 2 0 0 1-2-1.8L3 7z"/><path d="M8 7a4 4 0 0 1 8 0"/></svg></a>@endif
            @if($store->tokopedia_url)<a href="{{ $store->tokopedia_url }}" target="_blank" rel="noopener" aria-label="Tokopedia"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h18l-1.5 13a2 2 0 0 1-2 1.8H6.5a2 2 0 0 1-2-1.8L3 7z"/><path d="M8 7a4 4 0 0 1 8 0"/></svg></a>@endif
          </div>
        </div>
        <div>
          <h4>Navigasi</h4>
          <a href="{{ route('store.home', $store->slug) }}">Beranda</a>
          <a href="{{ route('store.products', $store->slug) }}">Semua Produk</a>
          <a href="{{ route('store.cart', $store->slug) }}">Keranjang</a>
        </div>
        <div>
          <h4>Kontak</h4>
          @if($store->address)<p style="margin-bottom:8px">{{ $store->address }}{{ $store->city ? ', '.$store->city : '' }}</p>@endif
          <a href="{{ $store->whatsapp_checkout_url }}" target="_blank" rel="noopener">WhatsApp: {{ $store->whatsapp_number }}</a>
          @if($store->email)<a href="mailto:{{ $store->email }}">{{ $store->email }}</a>@endif
        </div>
      </div>
      <div class="sf-bottom">
        <span>© {{ date('Y') }} {{ $store->name }}. Semua hak dilindungi.</span>
        <span>Powered by <a href="{{ url('/') }}" target="_blank" rel="noopener">E-commerce by Conweb</a></span>
      </div>
    </div>
  </footer>

  <script>
    // sembunyikan tombol WA nav jika nomor tak valid
    (function(){ var w=document.getElementById('wa-nav'); if(w && w.getAttribute('href')!=='#'){ w.style.display='inline-flex'; } })();
    var f=document.getElementById('flash'); if(f){ setTimeout(function(){ f.style.transition='opacity .4s'; f.style.opacity='0'; setTimeout(function(){f.remove();},400); }, 3500); }
  </script>
  @stack('scripts')
</body>
</html>
