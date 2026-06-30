<!DOCTYPE html>
<html lang="{{ site_locale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @php
    $seoDescDefault = $s['site.description'] ?? 'ConWeb ID membantu UMKM, startup, dan bisnis membuat website, landing page, aplikasi, dashboard, sistem custom, dan otomatisasi digital profesional.';
    $seoTitleDefault = $s['site.title'] ?? 'ConWeb ID — Jasa Pembuatan Website, Aplikasi & Sistem Custom';
    $canonicalBase = rtrim(config('app.url', url('/')), '/');
    $reqPath = request()->path();
    $seoUrl = $canonicalBase.($reqPath === '/' ? '/' : '/'.$reqPath);
    $seoImage = ! empty($s['site.logo']) ? asset('storage/'.$s['site.logo']) : (! empty($s['site.favicon']) ? asset('storage/'.$s['site.favicon']) : url('/favicon.ico'));
    $brandName = ($s['brand.name'] ?? 'ConWeb').' '.($s['brand.suffix'] ?? 'ID');
    $siteEmail = $s['site.email'] ?? 'hello@conweb.id';
    $ldOrg = json_encode(['@context' => 'https://schema.org', '@type' => 'Organization', 'name' => $brandName, 'url' => url('/'), 'logo' => $seoImage, 'email' => $siteEmail, 'description' => $seoDescDefault], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $ldSite = json_encode(['@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => $brandName, 'url' => url('/')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  @endphp
  <title>@yield('title', $seoTitleDefault)</title>
  <meta name="description" content="@yield('description', $seoDescDefault)">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{{ $seoUrl }}">
  @if(! empty($s['site.favicon']))
  <link rel="icon" href="{{ asset('storage/'.$s['site.favicon']) }}" sizes="any">
  <link rel="apple-touch-icon" href="{{ asset('storage/'.$s['site.favicon']) }}">
  @endif

  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ $brandName }}">
  <meta property="og:title" content="@yield('title', $seoTitleDefault)">
  <meta property="og:description" content="@yield('description', $seoDescDefault)">
  <meta property="og:url" content="{{ $seoUrl }}">
  <meta property="og:image" content="{{ $seoImage }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('title', $seoTitleDefault)">
  <meta name="twitter:description" content="@yield('description', $seoDescDefault)">
  <meta name="twitter:image" content="{{ $seoImage }}">

  <script type="application/ld+json">{!! $ldOrg !!}</script>
  <script type="application/ld+json">{!! $ldSite !!}</script>
  @stack('head')
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root{
      --ink:#0a1633;--ink-2:#1c2a4a;--body:#4b5a78;--muted:#8190ab;--line:#e6ecf7;--line-2:#d9e2f2;
      --bg:#ffffff;--soft:#f5f8ff;--soft-2:#eef3fe;--brand:#2563eb;--brand-d:#1d4ed8;--brand-l:#3b82f6;
      --brand-tint:rgba(37,99,235,.08);--brand-tint-2:rgba(37,99,235,.14);--sky:#38bdf8;--navy:#0a1530;--navy-2:#0f1d3d;--ok:#22c55e;
      --shadow-sm:0 1px 2px rgba(13,30,70,.06), 0 2px 8px rgba(13,30,70,.05);
      --shadow:0 12px 32px rgba(13,30,70,.08), 0 2px 8px rgba(13,30,70,.04);
      --shadow-lg:0 28px 64px rgba(13,30,70,.14);
      --radius:18px;--radius-lg:26px;--radius-sm:12px;--container:1200px;--nav-h:76px;
      --ease:cubic-bezier(.22,1,.36,1);--t:.4s var(--ease);
      --display:'Space Grotesk', sans-serif;--sans:'Plus Jakarta Sans', sans-serif;
    }
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{font-family:var(--sans);color:var(--body);background:var(--bg);line-height:1.65;-webkit-font-smoothing:antialiased;overflow-x:hidden}
    body.lock{overflow:hidden}
    img,svg{display:block;max-width:100%}
    a{color:inherit;text-decoration:none}
    button{font:inherit;border:none;background:none;cursor:pointer;color:inherit}
    ul{list-style:none}
    ::selection{background:var(--brand);color:#fff}
    ::-webkit-scrollbar{width:10px}
    ::-webkit-scrollbar-track{background:var(--soft)}
    ::-webkit-scrollbar-thumb{background:#c3d0e8;border-radius:99px;border:2px solid var(--soft)}
    ::-webkit-scrollbar-thumb:hover{background:var(--brand-l)}
    .wrap{width:min(100% - 40px, var(--container));margin-inline:auto}
    .section{padding:104px 0}
    h1,h2,h3,h4{font-family:var(--display);color:var(--ink);font-weight:700;line-height:1.12;letter-spacing:-.02em}
    .eyebrow{display:inline-flex;align-items:center;gap:9px;font-family:var(--display);font-weight:600;font-size:12.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--brand-d);padding:7px 14px;border-radius:99px;background:var(--brand-tint);border:1px solid var(--brand-tint-2);margin-bottom:20px}
    .eyebrow svg{width:15px;height:15px}
    .heading{font-size:clamp(30px,4.2vw,46px);margin-bottom:16px}
    .lead{font-size:clamp(16px,1.5vw,17.5px);color:var(--body);max-width:600px}
    .center{text-align:center}
    .center .lead{margin-inline:auto}
    .sec-head{max-width:640px;margin-bottom:54px}
    .sec-head.center{margin-inline:auto}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;font-family:var(--display);font-weight:600;font-size:15px;padding:14px 24px;border-radius:13px;transition:var(--t);white-space:nowrap;position:relative;cursor:pointer}
    .btn svg{width:18px;height:18px;transition:transform var(--t)}
    .btn-primary{background:var(--brand);color:#fff;box-shadow:0 10px 24px rgba(37,99,235,.28)}
    .btn-primary:hover{background:var(--brand-d);transform:translateY(-2px);box-shadow:0 16px 32px rgba(37,99,235,.34)}
    .btn-primary:hover svg{transform:translateX(3px)}
    .btn-line{background:#fff;color:var(--ink);border:1px solid var(--line-2);box-shadow:var(--shadow-sm)}
    .btn-line:hover{border-color:var(--brand-l);color:var(--brand-d);transform:translateY(-2px)}
    .btn-ghost{color:var(--ink);padding-inline:6px}
    .btn-ghost:hover{color:var(--brand-d)}
    .btn-ghost:hover svg{transform:translateX(3px)}
    .btn-light{background:#fff;color:var(--ink)}
    .btn-light:hover{transform:translateY(-2px);box-shadow:0 16px 32px rgba(0,0,0,.22)}
    .btn-outline-light{border:1px solid rgba(255,255,255,.28);color:#fff;background:rgba(255,255,255,.04)}
    .btn-outline-light:hover{background:rgba(255,255,255,.1);transform:translateY(-2px)}
    .btn-sm{padding:10px 16px;font-size:13.5px;border-radius:10px}
    .btn-block{width:100%}
    .tag{display:inline-flex;align-items:center;gap:7px;font-family:var(--display);font-size:12.5px;font-weight:500;padding:6px 12px;border-radius:99px;background:var(--soft-2);color:var(--ink-2);border:1px solid var(--line)}
    .dot{width:7px;height:7px;border-radius:50%;background:var(--ok);box-shadow:0 0 0 4px rgba(34,197,94,.18)}
    .nav{position:fixed;inset:0 0 auto 0;z-index:100;transition:var(--t);background:rgba(255,255,255,.82);backdrop-filter:blur(16px);border-bottom:1px solid var(--line);box-shadow:0 2px 20px rgba(13,30,70,.04)}
    .nav.scrolled{background:rgba(255,255,255,.94)}
    .nav-in{height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;gap:20px}
    .logo{display:flex;align-items:center;gap:11px;font-family:var(--display);font-weight:700;font-size:19px;color:var(--ink);letter-spacing:-.02em;flex-shrink:0}
    .logo-mark{width:42px;height:42px;border-radius:14px;display:grid;place-items:center;flex-shrink:0;background:transparent;overflow:hidden}
    .logo-mark img{width:100%;height:100%;object-fit:contain;display:block}
    .logo-mark svg{width:21px;height:21px;color:var(--brand)}
    .logo b{color:var(--brand)}
    .nav-links{display:flex;align-items:center;gap:26px}
    .nav-links > a,.nav-dd-trigger{font-size:14px;font-weight:500;color:var(--ink-2);position:relative;transition:var(--t)}
    .nav-links > a::after{content:"";position:absolute;left:0;bottom:-5px;height:2px;width:0;background:var(--brand);border-radius:2px;transition:var(--t)}
    .nav-links > a:hover,.nav-links > a.active{color:var(--brand-d)}
    .nav-links > a:hover::after,.nav-links > a.active::after{width:100%}
    /* dropdown */
    .nav-item{position:relative;display:flex;align-items:center}
    .nav-dd-trigger{display:inline-flex;align-items:center;gap:5px;cursor:pointer;background:none;border:0;font-family:inherit}
    .nav-dd-trigger svg{width:14px;height:14px;transition:transform var(--t)}
    .nav-item:hover .nav-dd-trigger,.nav-item:focus-within .nav-dd-trigger,.nav-dd-trigger.active{color:var(--brand-d)}
    .nav-item:hover .nav-dd-trigger svg,.nav-item:focus-within .nav-dd-trigger svg{transform:rotate(180deg)}
    .nav-dd{position:absolute;top:calc(100% + 16px);left:50%;transform:translateX(-50%) translateY(8px);min-width:248px;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 18px 50px rgba(13,30,70,.14);padding:8px;opacity:0;visibility:hidden;transition:var(--t);z-index:60}
    .nav-dd::before{content:"";position:absolute;top:-16px;left:0;right:0;height:16px}
    .nav-item:hover .nav-dd,.nav-item:focus-within .nav-dd{opacity:1;visibility:visible;transform:translateX(-50%) translateY(0)}
    .nav-dd a{display:flex;flex-direction:column;gap:2px;padding:11px 13px;border-radius:11px;transition:var(--t)}
    .nav-dd a::after{display:none}
    .nav-dd a:hover{background:var(--soft-2)}
    .nav-dd a strong{font-family:var(--display);font-size:14px;font-weight:600;color:var(--ink);transition:var(--t)}
    .nav-dd a span{font-size:12px;color:var(--muted);font-weight:400;line-height:1.4}
    .nav-dd a:hover strong{color:var(--brand-d)}
    .nav-right{display:flex;align-items:center;gap:14px}
    .lang{display:flex;align-items:center;gap:2px;padding:4px;border-radius:99px;background:var(--soft-2);border:1px solid var(--line)}
    .lang a{font-family:var(--display);font-size:12px;font-weight:600;color:var(--muted);padding:6px 11px;border-radius:99px;transition:var(--t);display:block}
    .lang a.active{background:#fff;color:var(--brand-d);box-shadow:var(--shadow-sm)}
    .burger{display:none;width:44px;height:44px;border-radius:12px;border:1px solid var(--line-2);background:#fff;place-items:center;color:var(--ink)}
    .burger svg{width:22px;height:22px}
    .drawer{position:fixed;inset:var(--nav-h) 0 auto 0;z-index:99;background:#fff;border-bottom:1px solid var(--line);padding:18px 20px 26px;display:none;flex-direction:column;gap:6px;box-shadow:var(--shadow)}
    .drawer.open{display:flex;animation:slide .3s var(--ease)}
    @keyframes slide{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}
    .drawer a{padding:13px 14px;border-radius:12px;font-weight:600;color:var(--ink-2);transition:var(--t)}
    .drawer a:hover{background:var(--soft-2);color:var(--brand-d)}
    .drawer-label{font-family:var(--display);font-size:11px;font-weight:700;letter-spacing:.13em;text-transform:uppercase;color:var(--muted);padding:14px 14px 2px}
    .drawer-group{display:flex;flex-direction:column;gap:2px}
    .drawer-group + a,.drawer-group + .drawer-group{margin-top:4px}
    .drawer .btn{margin-top:10px}
    .drawer-lang{display:flex;gap:10px;margin-top:8px}
    .drawer-lang a{flex:1;padding:11px;border-radius:12px;border:1px solid var(--line-2);font-family:var(--display);font-weight:600;color:var(--ink-2);text-align:center}
    .drawer-lang a.active{background:var(--brand);color:#fff;border-color:var(--brand)}
    .page-hero{position:relative;padding:calc(var(--nav-h) + 64px) 0 64px;overflow:hidden}
    .page-hero::before{content:"";position:absolute;inset:0;z-index:-2;background:radial-gradient(900px 480px at 78% -8%, rgba(56,189,248,.16), transparent 60%),radial-gradient(760px 520px at 8% 0%, rgba(37,99,235,.12), transparent 58%),linear-gradient(180deg,var(--soft) 0%, #fff 64%)}
    .page-hero h1{font-size:clamp(32px,4.6vw,48px);letter-spacing:-.03em;margin-bottom:14px}
    .page-hero p{font-size:16.5px;max-width:620px}
    .breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted);margin-bottom:18px}
    .breadcrumb a{color:var(--brand-d);font-weight:600}
    .hero{position:relative;padding-top:calc(var(--nav-h) + 70px);padding-bottom:90px;overflow:hidden}
    .hero::before{content:"";position:absolute;inset:0;z-index:-2;background:radial-gradient(900px 480px at 78% -8%, rgba(56,189,248,.16), transparent 60%),radial-gradient(760px 520px at 8% 0%, rgba(37,99,235,.12), transparent 58%),linear-gradient(180deg,var(--soft) 0%, #fff 64%)}
    .hero::after{content:"";position:absolute;inset:0;z-index:-1;opacity:.5;background-image:linear-gradient(var(--line) 1px,transparent 1px),linear-gradient(90deg,var(--line) 1px,transparent 1px);background-size:46px 46px;mask-image:radial-gradient(720px 460px at 70% 20%,#000,transparent 75%);-webkit-mask-image:radial-gradient(720px 460px at 70% 20%,#000,transparent 75%)}
    .hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:54px;align-items:center}
    .hero h1{font-size:clamp(36px,5.4vw,60px);letter-spacing:-.035em;margin-bottom:22px}
    .hero h1 .grad{background:linear-gradient(120deg,var(--brand) 10%,var(--sky));-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
    .hero p.desc{font-size:17.5px;max-width:540px;margin-bottom:30px}
    .hero-cta{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:34px}
    .hero-trust{display:flex;align-items:center;gap:22px;flex-wrap:wrap}
    .avatars{display:flex}
    .avatars span{width:40px;height:40px;border-radius:50%;border:2.5px solid #fff;margin-left:-12px;display:grid;place-items:center;font-family:var(--display);font-weight:700;font-size:14px;color:#fff}
    .avatars span:first-child{margin-left:0}
    .avatars span:nth-child(1){background:linear-gradient(135deg,#3b82f6,#1d4ed8)}
    .avatars span:nth-child(2){background:linear-gradient(135deg,#38bdf8,#0ea5e9)}
    .avatars span:nth-child(3){background:linear-gradient(135deg,#6366f1,#4338ca)}
    .avatars span:nth-child(4){background:linear-gradient(135deg,#0a1530,#28406e);font-size:12px}
    .trust-text strong{display:block;font-family:var(--display);color:var(--ink);font-size:15px}
    .trust-text span{font-size:13px;color:var(--muted)}
    .stars{color:#f5b50a;letter-spacing:2px;font-size:13px}
    .hero-vis{position:relative}
    .window{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);box-shadow:var(--shadow-lg);overflow:hidden;position:relative}
    .win-bar{display:flex;align-items:center;gap:7px;padding:14px 18px;border-bottom:1px solid var(--line);background:var(--soft)}
    .win-bar i{width:11px;height:11px;border-radius:50%;background:#dbe3f2}
    .win-bar i:nth-child(1){background:#ff6058}
    .win-bar i:nth-child(2){background:#febc2e}
    .win-bar i:nth-child(3){background:#28c840}
    .win-url{margin-left:12px;font-family:var(--display);font-size:12px;color:var(--muted);background:#fff;border:1px solid var(--line);border-radius:8px;padding:5px 12px}
    .win-body{padding:22px}
    .win-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
    .win-row h4{font-size:16px}
    .win-pill{font-family:var(--display);font-size:11px;font-weight:600;color:var(--ok);background:rgba(34,197,94,.1);padding:5px 11px;border-radius:99px}
    .win-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .win-stat{background:var(--soft);border:1px solid var(--line);border-radius:14px;padding:14px}
    .win-stat span{font-family:var(--display);font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em}
    .win-stat b{display:block;font-family:var(--display);font-size:22px;color:var(--ink);margin-top:4px}
    .win-stat b em{font-style:normal;font-size:13px;color:var(--ok);margin-left:4px}
    .win-chart{display:flex;align-items:flex-end;gap:9px;height:118px;padding:16px;background:var(--soft);border:1px solid var(--line);border-radius:16px}
    .win-chart i{flex:1;border-radius:6px 6px 3px 3px;background:linear-gradient(180deg,var(--brand-l),var(--brand-d));opacity:.85;animation:rise 1s var(--ease) backwards}
    .win-chart i:nth-child(odd){background:linear-gradient(180deg,#cfe0ff,#9cbcf5)}
    @keyframes rise{from{height:0!important;opacity:0}}
    .float-card{position:absolute;background:#fff;border:1px solid var(--line);border-radius:16px;padding:14px 16px;box-shadow:var(--shadow);display:flex;align-items:center;gap:12px;animation:floaty 5s ease-in-out infinite}
    .float-card .ic{width:40px;height:40px;border-radius:11px;display:grid;place-items:center;flex-shrink:0}
    .float-card .ic svg{width:20px;height:20px}
    .float-card strong{display:block;font-family:var(--display);font-size:14px;color:var(--ink);line-height:1.2}
    .float-card span{font-size:12px;color:var(--muted)}
    .float-a{top:-22px;left:-26px;animation-delay:0s}
    .float-a .ic{background:var(--brand-tint);color:var(--brand-d)}
    .float-b{bottom:-24px;right:-22px;animation-delay:1.2s}
    .float-b .ic{background:rgba(34,197,94,.12);color:var(--ok)}
    @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    .logos{padding:36px 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:var(--soft)}
    .logos p{text-align:center;font-family:var(--display);font-size:12.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:22px}
    .logos-row{display:flex;flex-wrap:wrap;justify-content:center;align-items:center;gap:14px 38px}
    .logos-row span{font-family:var(--display);font-weight:700;font-size:19px;color:#a8b6cf;letter-spacing:-.02em;transition:var(--t)}
    .logos-row span:hover{color:var(--brand)}
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
    .stat{text-align:center;padding:8px}
    .stat b{display:block;font-family:var(--display);font-size:clamp(34px,4.6vw,52px);color:var(--brand);letter-spacing:-.04em;line-height:1}
    .stat span{font-size:14px;color:var(--body);margin-top:8px;display:block;font-weight:500}
    .stat-div{position:relative}
    .stat-div::after{content:"";position:absolute;right:-12px;top:14%;height:72%;width:1px;background:var(--line-2)}
    .services{background:var(--soft)}
    .svc-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px}
    .svc-grid.cols-4{grid-template-columns:repeat(4,1fr)}
    .svc{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px;box-shadow:var(--shadow-sm);transition:var(--t);position:relative;overflow:hidden}
    .svc::before{content:"";position:absolute;inset:0 0 auto 0;height:3px;background:linear-gradient(90deg,var(--brand),var(--sky));transform:scaleX(0);transform-origin:left;transition:transform .45s var(--ease)}
    .svc:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg);border-color:var(--line-2)}
    .svc:hover::before{transform:scaleX(1)}
    .svc-ic{width:56px;height:56px;border-radius:15px;display:grid;place-items:center;margin-bottom:20px;background:var(--brand-tint);color:var(--brand-d);border:1px solid var(--brand-tint-2)}
    .svc-ic svg{width:26px;height:26px}
    .svc h3{font-size:21px;margin-bottom:10px}
    .svc p{font-size:14.5px;margin-bottom:20px}
    .svc ul{display:grid;gap:11px}
    .svc li{display:flex;gap:11px;align-items:flex-start;font-size:14px;color:var(--ink-2)}
    .svc li svg{width:19px;height:19px;flex-shrink:0;color:var(--brand);margin-top:2px}
    .svc-more{display:inline-flex;align-items:center;gap:6px;font-family:var(--display);font-weight:600;font-size:13.5px;color:var(--brand-d);margin-top:18px}
    .why-grid{display:grid;grid-template-columns:.95fr 1.05fr;gap:56px;align-items:center}
    .why-points{display:grid;gap:18px;margin-top:8px}
    .why-pt{display:flex;gap:18px;align-items:flex-start}
    .why-pt .ic{width:50px;height:50px;border-radius:14px;flex-shrink:0;display:grid;place-items:center;background:var(--brand-tint);color:var(--brand-d);border:1px solid var(--brand-tint-2)}
    .why-pt .ic svg{width:23px;height:23px}
    .why-pt h4{font-size:18px;margin-bottom:4px}
    .why-pt p{font-size:14.5px}
    .why-visual{position:relative;background:linear-gradient(160deg,var(--navy),var(--navy-2));border-radius:var(--radius-lg);padding:40px;color:#fff;overflow:hidden;box-shadow:var(--shadow-lg)}
    .why-visual::before{content:"";position:absolute;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(56,189,248,.32),transparent 65%);top:-120px;right:-80px}
    .why-visual .qm{font-family:var(--display);font-size:60px;line-height:.6;color:var(--sky);margin-bottom:14px}
    .why-visual blockquote{font-family:var(--display);font-size:22px;font-weight:600;line-height:1.45;color:#fff;letter-spacing:-.01em;position:relative;z-index:1;margin-bottom:26px}
    .why-author{display:flex;align-items:center;gap:13px;position:relative;z-index:1}
    .why-author .av{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,var(--sky),var(--brand));display:grid;place-items:center;font-family:var(--display);font-weight:700;color:#fff}
    .why-author strong{display:block;font-family:var(--display);font-size:15px;color:#fff}
    .why-author span{font-size:13px;color:#9fb1d4}
    .why-mini{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:30px;position:relative;z-index:1}
    .why-mini div{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:16px}
    .why-mini b{font-family:var(--display);font-size:26px;color:#fff;display:block}
    .why-mini span{font-size:12.5px;color:#9fb1d4}
    .process{background:var(--soft)}
    .proc-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;position:relative}
    .proc{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:30px 26px;box-shadow:var(--shadow-sm);transition:var(--t);position:relative}
    .proc:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:var(--brand-tint-2)}
    .proc-num{font-family:var(--display);font-weight:700;font-size:14px;color:#fff;width:42px;height:42px;border-radius:12px;display:grid;place-items:center;background:linear-gradient(135deg,var(--brand-l),var(--brand-d));margin-bottom:18px;box-shadow:0 8px 16px rgba(37,99,235,.3)}
    .proc h3{font-size:19px;margin-bottom:9px}
    .proc p{font-size:14px}
    .pf-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:24px}
    .pf{position:relative;border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--line);box-shadow:var(--shadow-sm);transition:var(--t);min-height:300px;display:flex;flex-direction:column;justify-content:flex-end;padding:30px;color:#fff;isolation:isolate}
    .pf:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}
    .pf-bg{position:absolute;inset:0;z-index:-2;background-size:cover;background-position:center}
    .pf-bg::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(7,15,35,.94) 8%,rgba(7,15,35,.45) 55%,rgba(7,15,35,.12) 100%)}
    .pf-mesh{position:absolute;inset:0;z-index:-1;opacity:.25;background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:30px 30px;mask-image:linear-gradient(to top,#000,transparent)}
    .pf-cat{font-family:var(--display);font-size:12px;font-weight:600;letter-spacing:.05em;color:var(--sky);margin-bottom:10px;display:flex;align-items:center;gap:8px}
    .pf-cat svg{width:15px;height:15px}
    .pf h3{font-size:23px;color:#fff;margin-bottom:9px}
    .pf p{font-size:14px;color:rgba(255,255,255,.78);margin-bottom:16px;max-width:520px}
    .pf-tags{display:flex;flex-wrap:wrap;gap:7px}
    .pf-tags span{font-family:var(--display);font-size:11px;font-weight:500;padding:5px 10px;border-radius:99px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.16);color:#fff}
    .pf-open{position:absolute;top:22px;right:22px;width:42px;height:42px;border-radius:12px;display:grid;place-items:center;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);color:#fff;transition:var(--t)}
    .pf-open svg{width:18px;height:18px}
    .pf:hover .pf-open{background:#fff;color:var(--brand-d)}
    .pf-xl{grid-column:span 4}
    .pf-md{grid-column:span 2}
    .pf-sm{grid-column:span 2}
    .tech{background:var(--soft)}
    .tech-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px}
    .tech-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:26px;box-shadow:var(--shadow-sm);transition:var(--t)}
    .tech-card:hover{transform:translateY(-4px);box-shadow:var(--shadow);border-color:var(--brand-tint-2)}
    .tech-card .ic{width:46px;height:46px;border-radius:12px;display:grid;place-items:center;background:var(--brand-tint);color:var(--brand-d);margin-bottom:16px}
    .tech-card .ic svg{width:22px;height:22px}
    .tech-card h3{font-size:17px;margin-bottom:14px}
    .pills{display:flex;flex-wrap:wrap;gap:8px}
    .pills span{font-family:var(--display);font-size:12.5px;font-weight:500;padding:7px 12px;border-radius:10px;background:var(--soft-2);border:1px solid var(--line);color:var(--ink-2)}
    .testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .testi{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:30px;box-shadow:var(--shadow-sm);transition:var(--t)}
    .testi:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:var(--brand-tint-2)}
    .testi .stars{font-size:15px;margin-bottom:16px}
    .testi p{font-size:15px;color:var(--ink-2);margin-bottom:22px;line-height:1.7}
    .testi-user{display:flex;align-items:center;gap:13px}
    .testi-user .av{width:48px;height:48px;border-radius:50%;display:grid;place-items:center;font-family:var(--display);font-weight:700;color:#fff;font-size:17px}
    .testi-user strong{display:block;font-family:var(--display);font-size:15px;color:var(--ink)}
    .testi-user span{font-size:13px;color:var(--muted)}
    .faq{background:var(--soft)}
    .faq-wrap{display:grid;gap:14px;max-width:820px;margin-inline:auto}
    .faq-item{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:var(--t)}
    .faq-item.open{border-color:var(--brand-tint-2);box-shadow:var(--shadow-sm)}
    .faq-q{width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:22px 24px;text-align:left}
    .faq-q h3{font-size:16.5px;font-family:var(--display);font-weight:600}
    .faq-q .pm{width:30px;height:30px;border-radius:9px;flex-shrink:0;display:grid;place-items:center;border:1px solid var(--line-2);color:var(--brand-d);transition:var(--t)}
    .faq-q .pm svg{width:17px;height:17px;transition:var(--t)}
    .faq-item.open .pm{background:var(--brand);border-color:var(--brand);color:#fff}
    .faq-item.open .pm svg{transform:rotate(45deg)}
    .faq-a{max-height:0;overflow:hidden;transition:max-height .35s var(--ease)}
    .faq-a div{padding:0 24px 24px;font-size:15px;color:var(--body)}
    .cta-wrap{position:relative;border-radius:var(--radius-lg);overflow:hidden;background:linear-gradient(150deg,var(--navy),var(--navy-2) 70%);padding:64px 48px;text-align:center;box-shadow:var(--shadow-lg)}
    .cta-wrap::before{content:"";position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(56,189,248,.22),transparent 65%);top:-220px;left:50%;transform:translateX(-50%)}
    .cta-wrap::after{content:"";position:absolute;inset:0;opacity:.4;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:40px 40px;mask-image:radial-gradient(circle at 50% 0%,#000,transparent 70%)}
    .cta-wrap > *{position:relative;z-index:1}
    .cta-wrap .eyebrow{background:rgba(56,189,248,.12);border-color:rgba(56,189,248,.25);color:var(--sky)}
    .cta-wrap h2{color:#fff;font-size:clamp(30px,4.6vw,48px);margin-bottom:16px;letter-spacing:-.03em}
    .cta-wrap p{color:#b6c5e3;max-width:560px;margin:0 auto 32px;font-size:16.5px}
    .cta-actions{display:flex;flex-wrap:wrap;gap:14px;justify-content:center}
    footer{background:var(--navy);color:#9fb1d4;padding:64px 0 30px}
    .foot-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:40px;padding-bottom:44px;border-bottom:1px solid rgba(255,255,255,.1)}
    .foot-brand .logo{color:#fff;margin-bottom:16px}
    .foot-brand .logo-mark svg{color:#fff}
    .foot-brand p{font-size:14.5px;max-width:300px;color:#9fb1d4;margin-bottom:20px}
    .foot-social{display:flex;gap:10px}
    .foot-social a{width:40px;height:40px;border-radius:11px;display:grid;place-items:center;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#cbd6ee;transition:var(--t)}
    .foot-social a svg{width:19px;height:19px}
    .foot-social a:hover{background:var(--brand);color:#fff;border-color:var(--brand);transform:translateY(-3px)}
    .foot-col h4{font-family:var(--display);font-size:14px;color:#fff;margin-bottom:18px;letter-spacing:.02em}
    .foot-col a{display:block;font-size:14px;color:#9fb1d4;padding:6px 0;transition:var(--t)}
    .foot-col a:hover{color:#fff;padding-left:5px}
    .foot-bottom{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;padding-top:26px}
    .foot-bottom p{font-size:13px;color:#7f90b3;font-family:var(--display)}
    .foot-bottom .made{display:flex;align-items:center;gap:7px}
    .foot-bottom .made svg{width:14px;height:14px;color:var(--sky)}
    .totop{position:fixed;left:22px;bottom:22px;width:48px;height:48px;border-radius:14px;display:grid;place-items:center;background:var(--brand);color:#fff;box-shadow:0 12px 28px rgba(37,99,235,.4);z-index:90;opacity:0;visibility:hidden;transform:translateY(12px);transition:var(--t)}
    .totop.show{opacity:1;visibility:visible;transform:translateY(0)}
    .totop:hover{background:var(--brand-d);transform:translateY(-3px)}
    .totop svg{width:20px;height:20px}
    .reveal{opacity:0;transform:translateY(28px);transition:opacity .7s var(--ease),transform .7s var(--ease)}
    .reveal.in{opacity:1;transform:none}
    /* cards: templates, pricing, blog, form */
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:24px}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:40px}
    .filter-row a{font-family:var(--display);font-size:13.5px;font-weight:600;padding:9px 16px;border-radius:99px;border:1px solid var(--line-2);color:var(--ink-2);background:#fff;transition:var(--t)}
    .filter-row a.active,.filter-row a:hover{background:var(--brand);color:#fff;border-color:var(--brand)}
    .tpl-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-sm);transition:var(--t)}
    .tpl-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}
    .tpl-thumb{height:190px;background-size:cover;background-position:center;position:relative;display:flex;align-items:flex-end;padding:16px}
    .tpl-thumb span.badge{font-family:var(--display);font-size:11px;font-weight:700;color:#fff;background:rgba(0,0,0,.35);padding:5px 10px;border-radius:99px}
    .tpl-body{padding:22px}
    .tpl-body h3{font-size:18px;margin-bottom:6px}
    .tpl-body .cat{font-size:12.5px;color:var(--muted);margin-bottom:14px;display:block}
    .tpl-foot{display:flex;align-items:center;justify-content:space-between;margin-top:16px}
    .tpl-foot .price{font-family:var(--display);font-weight:700;color:var(--brand-d);font-size:13.5px}
    .price-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:32px;box-shadow:var(--shadow-sm);position:relative;transition:var(--t)}
    .price-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}
    .price-card .badge{position:absolute;top:-12px;right:24px;background:var(--brand);color:#fff;font-family:var(--display);font-size:11.5px;font-weight:700;padding:6px 14px;border-radius:99px}
    .price-card h3{font-size:20px;margin-bottom:6px}
    .price-old{font-size:13.5px;color:var(--muted);text-decoration:line-through}
    .price-now{font-family:var(--display);font-size:32px;color:var(--ink);font-weight:700;margin:6px 0 4px}
    .price-now span{font-size:14px;color:var(--muted);font-weight:500}
    .price-feat{display:grid;gap:10px;margin:20px 0 24px}
    .price-feat li{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:var(--ink-2)}
    .price-feat svg{width:18px;height:18px;color:var(--ok);flex-shrink:0;margin-top:2px}
    .blog-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-sm);transition:var(--t)}
    .blog-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}
    .blog-thumb{height:180px;background-size:cover;background-position:center;background-color:var(--soft-2)}
    .blog-body{padding:22px}
    .blog-body .cat{font-family:var(--display);font-size:11.5px;font-weight:700;letter-spacing:.04em;color:var(--brand-d);text-transform:uppercase}
    .blog-body h3{font-size:18px;margin:8px 0}
    .blog-body p{font-size:14px;margin-bottom:14px}
    .blog-meta{font-size:12.5px;color:var(--muted)}
    .form-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:36px;box-shadow:var(--shadow-sm);max-width:560px;margin-inline:auto}
    .form-row{margin-bottom:18px}
    .form-row label{display:block;font-family:var(--display);font-size:13.5px;font-weight:600;color:var(--ink-2);margin-bottom:7px}
    .form-row input,.form-row select,.form-row textarea{width:100%;padding:13px 15px;border-radius:12px;border:1px solid var(--line-2);font-family:var(--sans);font-size:14.5px;color:var(--ink);background:#fff}
    .form-row input:focus,.form-row select:focus,.form-row textarea:focus{outline:2px solid var(--brand-l);border-color:var(--brand)}
    .form-note{background:var(--soft-2);border:1px solid var(--line);border-radius:12px;padding:14px 16px;font-size:13.5px;color:var(--ink-2);margin-bottom:22px}
    .alert{padding:14px 16px;border-radius:12px;font-size:14px;margin-bottom:18px}
    .alert-error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#b91c1c}
    .community-stat{text-align:center}
    @media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important;scroll-behavior:auto!important}.reveal{opacity:1;transform:none}}
    @media (max-width:1080px){.hero-grid,.why-grid{grid-template-columns:1fr;gap:48px}.hero-vis{max-width:520px;margin-inline:auto;width:100%}.svc-grid,.svc-grid.cols-4{grid-template-columns:1fr 1fr}.pf-xl,.pf-md,.pf-sm{grid-column:span 3}.pf-grid{grid-template-columns:repeat(6,1fr)}.grid-3,.grid-4{grid-template-columns:1fr 1fr}}
    @media (max-width:920px){.nav-links,.nav-right .lang,.nav-right > .btn{display:none}.burger{display:grid}.stats-grid{grid-template-columns:1fr 1fr;gap:32px 24px}.stat-div::after{display:none}.proc-grid{grid-template-columns:1fr 1fr}.tech-grid{grid-template-columns:1fr 1fr}.testi-grid{grid-template-columns:1fr}.foot-grid{grid-template-columns:1fr 1fr;gap:34px}.grid-2{grid-template-columns:1fr}}
    @media (max-width:640px){.section{padding:74px 0}.wrap{width:min(100% - 32px,var(--container))}.hero{padding-top:calc(var(--nav-h) + 44px)}.hero h1{font-size:clamp(31px,9vw,42px)}.hero-cta{flex-direction:column}.hero-cta .btn{width:100%}.svc-grid,.svc-grid.cols-4{grid-template-columns:1fr}.proc-grid{grid-template-columns:1fr}.tech-grid{grid-template-columns:1fr}.pf-grid{grid-template-columns:1fr}.pf-xl,.pf-md,.pf-sm{grid-column:span 1;min-height:280px}.stats-grid{grid-template-columns:1fr 1fr}.foot-grid{grid-template-columns:1fr}.cta-wrap{padding:48px 24px}.svc,.testi,.why-visual{padding:26px}.float-a{left:-8px;top:-14px}.float-b{right:-6px;bottom:-14px}.float-card{padding:11px 13px}.grid-3,.grid-4{grid-template-columns:1fr}}
  </style>
  @stack('styles')
</head>
<body>

  @include('partials.navbar')

  @yield('content')

  @include('partials.footer')

  <a href="#top" class="totop" id="totop" aria-label="Ke atas">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
  </a>

  <script>
    const nav = document.getElementById("nav");
    const totop = document.getElementById("totop");
    function onScroll(){
      nav.classList.toggle("scrolled", window.scrollY > 20);
      totop.classList.toggle("show", window.scrollY > 600);
    }
    window.addEventListener("scroll", onScroll); onScroll();

    const burger = document.getElementById("burger");
    const drawer = document.getElementById("drawer");
    if (burger && drawer) {
      burger.addEventListener("click", ()=>{ drawer.classList.toggle("open"); document.body.classList.toggle("lock", drawer.classList.contains("open")); });
      drawer.querySelectorAll("a").forEach(a=>a.addEventListener("click", ()=>{ drawer.classList.remove("open"); document.body.classList.remove("lock"); }));
    }

    document.querySelectorAll(".faq-item").forEach(item=>{
      const q = item.querySelector(".faq-q");
      const a = item.querySelector(".faq-a");
      if(item.classList.contains("open")) a.style.maxHeight = a.scrollHeight + "px";
      q.addEventListener("click", ()=>{
        const open = item.classList.contains("open");
        document.querySelectorAll(".faq-item").forEach(o=>{ o.classList.remove("open"); o.querySelector(".faq-a").style.maxHeight = null; });
        if(!open){ item.classList.add("open"); a.style.maxHeight = a.scrollHeight + "px"; }
      });
    });

    const io = new IntersectionObserver((entries)=>{ entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add("in"); io.unobserve(e.target);} }); }, { threshold:.12 });
    document.querySelectorAll(".reveal").forEach(el=>io.observe(el));
  </script>
  @include('partials.chat-widget')

  @stack('scripts')
</body>
</html>
