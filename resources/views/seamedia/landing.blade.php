<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SEAMEDIA × CONWEB — Dari Konten Menuju Konversi Nyata</title>
  <meta name="description" content="Kolaborasi Seamedia & ConWeb: social media membawa perhatian, website membangun kepercayaan. Rumah digital profesional untuk UMKM & local brand.">
  <meta name="robots" content="index, follow">
  <meta property="og:title" content="SEAMEDIA × CONWEB — Dari Konten Menuju Konversi Nyata">
  <meta property="og:description" content="Social media bawa perhatian, website bangun kepercayaan.">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  @php
    $waSeamedia = 'https://wa.me/6281234567890'; // TODO: ganti nomor WA Seamedia
    $emailSeamedia = 'seamediaindonesia@gmail.com';
  @endphp
  <style>
    :root{
      --bg:#0b0712;            /* dark plum/ink */
      --bg-2:#130b1f;
      --surface:#17101f;
      --surface-2:#1e1430;
      --line:rgba(255,255,255,.10);
      --line-2:rgba(255,255,255,.16);
      --text:#f4eefb;
      --muted:#b3a6c8;
      --dim:#8b7da6;
      --violet:#8b5cf6;
      --fuchsia:#e23dd0;
      --amber:#ff9f43;
      --emerald:#34d399;
      --grad:linear-gradient(100deg,#8b5cf6 0%,#e23dd0 50%,#ff9f43 100%);
      --grad-soft:linear-gradient(100deg,rgba(139,92,246,.18),rgba(226,61,208,.18) 55%,rgba(255,159,67,.18));
      --radius:20px;--radius-lg:28px;--container:1180px;--nav-h:74px;
      --ease:cubic-bezier(.22,1,.36,1);--t:.45s var(--ease);
      --display:'Sora',sans-serif;--sans:'Inter',sans-serif;
    }
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{font-family:var(--sans);background:var(--bg);color:var(--muted);line-height:1.7;-webkit-font-smoothing:antialiased;overflow-x:hidden}
    body.lock{overflow:hidden}
    a{color:inherit;text-decoration:none}
    ul{list-style:none}
    img,svg{display:block;max-width:100%}
    h1,h2,h3,h4{font-family:var(--display);color:var(--text);font-weight:700;line-height:1.12;letter-spacing:-.02em}
    ::selection{background:var(--fuchsia);color:#fff}
    ::-webkit-scrollbar{width:10px}
    ::-webkit-scrollbar-track{background:#0b0712}
    ::-webkit-scrollbar-thumb{background:#3a2c52;border-radius:99px}
    .wrap{width:min(100% - 40px,var(--container));margin-inline:auto}
    .section{padding:110px 0}
    .grad-text{background:var(--grad);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
    .eyebrow{display:inline-flex;align-items:center;gap:9px;font-family:var(--display);font-weight:600;font-size:12px;letter-spacing:.16em;text-transform:uppercase;color:var(--text);padding:8px 16px;border-radius:99px;background:var(--grad-soft);border:1px solid var(--line-2);margin-bottom:22px}
    .eyebrow .pip{width:7px;height:7px;border-radius:50%;background:var(--fuchsia);box-shadow:0 0 0 4px rgba(226,61,208,.2)}
    .heading{font-size:clamp(30px,4.4vw,48px);margin-bottom:16px;color:var(--text)}
    .lead{font-size:clamp(16px,1.6vw,18px);color:var(--muted);max-width:620px}
    .center{text-align:center}.center .lead{margin-inline:auto}
    .sec-head{max-width:680px;margin-bottom:56px}
    .sec-head.center{margin-inline:auto}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;font-family:var(--display);font-weight:600;font-size:15px;padding:15px 26px;border-radius:14px;transition:var(--t);cursor:pointer;border:none;white-space:nowrap}
    .btn svg{width:18px;height:18px;transition:transform var(--t)}
    .btn-grad{background:var(--grad);color:#fff;box-shadow:0 12px 34px rgba(226,61,208,.34)}
    .btn-grad:hover{transform:translateY(-3px);box-shadow:0 18px 44px rgba(226,61,208,.45)}
    .btn-grad:hover svg{transform:translateX(3px)}
    .btn-ghost{background:rgba(255,255,255,.05);color:var(--text);border:1px solid var(--line-2)}
    .btn-ghost:hover{background:rgba(255,255,255,.1);transform:translateY(-3px)}
    .btn-block{width:100%}
    /* nav */
    .nav{position:fixed;inset:0 0 auto 0;z-index:100;transition:var(--t)}
    .nav.scrolled{background:rgba(11,7,18,.72);backdrop-filter:blur(16px);border-bottom:1px solid var(--line)}
    .nav-in{height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;gap:20px}
    .brand{display:flex;align-items:center;gap:11px;font-family:var(--display);font-weight:800;font-size:17px;color:var(--text);letter-spacing:-.01em}
    .brand .x{width:30px;height:30px;border-radius:9px;display:grid;place-items:center;background:var(--grad);color:#fff;font-size:13px;font-weight:800}
    .brand b{font-weight:800}
    .nav-links{display:flex;align-items:center;gap:28px}
    .nav-links a{font-size:14px;font-weight:500;color:var(--muted);transition:var(--t)}
    .nav-links a:hover{color:var(--text)}
    .nav-right{display:flex;align-items:center;gap:12px}
    .burger{display:none;width:44px;height:44px;border-radius:12px;border:1px solid var(--line-2);background:rgba(255,255,255,.04);place-items:center;color:var(--text)}
    .burger svg{width:22px;height:22px}
    .drawer{position:fixed;inset:var(--nav-h) 0 auto 0;z-index:99;background:var(--bg-2);border-bottom:1px solid var(--line);padding:18px 20px 26px;display:none;flex-direction:column;gap:6px}
    .drawer.open{display:flex}
    .drawer a{padding:13px 14px;border-radius:12px;font-weight:600;color:var(--muted)}
    .drawer a:hover{background:rgba(255,255,255,.05);color:var(--text)}
    /* hero */
    .hero{position:relative;padding-top:calc(var(--nav-h) + 80px);padding-bottom:80px;overflow:hidden}
    .hero::before{content:"";position:absolute;inset:0;z-index:-2;background:radial-gradient(800px 480px at 82% -5%,rgba(226,61,208,.22),transparent 60%),radial-gradient(720px 520px at 6% 5%,rgba(139,92,246,.20),transparent 58%),radial-gradient(600px 400px at 60% 100%,rgba(255,159,67,.10),transparent 60%)}
    .hero::after{content:"";position:absolute;inset:0;z-index:-1;opacity:.5;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:48px 48px;mask-image:radial-gradient(700px 460px at 70% 30%,#000,transparent 75%);-webkit-mask-image:radial-gradient(700px 460px at 70% 30%,#000,transparent 75%)}
    .hero-grid{display:grid;grid-template-columns:1.08fr .92fr;gap:56px;align-items:center}
    .hero h1{font-size:clamp(36px,5.6vw,62px);font-weight:800;letter-spacing:-.035em;margin-bottom:22px;color:var(--text)}
    .hero p.desc{font-size:18px;max-width:540px;margin-bottom:32px}
    .hero-cta{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:34px}
    .hero-trust{display:flex;align-items:center;gap:14px;flex-wrap:wrap;font-size:13.5px;color:var(--dim)}
    .hero-trust .av{display:flex}
    .hero-trust .av span{width:38px;height:38px;border-radius:50%;border:2px solid var(--bg);margin-left:-11px;background:var(--grad);display:grid;place-items:center;font-family:var(--display);font-weight:700;font-size:12px;color:#fff}
    .hero-trust .av span:first-child{margin-left:0}
    /* hero visual: phone -> web flow */
    .flow{position:relative;display:flex;align-items:center;justify-content:center;gap:18px}
    .flow-card{background:linear-gradient(160deg,var(--surface-2),var(--surface));border:1px solid var(--line-2);border-radius:var(--radius-lg);padding:22px;box-shadow:0 30px 70px rgba(0,0,0,.5);position:relative;overflow:hidden}
    .flow-card::before{content:"";position:absolute;inset:0 0 auto 0;height:3px;background:var(--grad)}
    .flow-phone{width:180px}
    .flow-phone .scr{aspect-ratio:9/17;border-radius:18px;background:linear-gradient(180deg,#241636,#160d24);border:1px solid var(--line);padding:14px;display:flex;flex-direction:column;gap:9px}
    .flow-phone .bar{height:9px;border-radius:99px;background:rgba(255,255,255,.08)}
    .flow-phone .bar.g{background:var(--grad);width:60%}
    .flow-phone .sq{flex:1;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid var(--line)}
    .flow-arrow{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;background:var(--grad);color:#fff;flex-shrink:0;box-shadow:0 10px 24px rgba(226,61,208,.4)}
    .flow-arrow svg{width:20px;height:20px}
    .flow-web{width:230px}
    .flow-web .scr{border-radius:14px;background:linear-gradient(180deg,#241636,#160d24);border:1px solid var(--line);overflow:hidden}
    .flow-web .top{height:26px;background:rgba(255,255,255,.05);display:flex;align-items:center;gap:5px;padding:0 12px}
    .flow-web .top i{width:7px;height:7px;border-radius:50%;background:rgba(255,255,255,.2)}
    .flow-web .body{padding:14px;display:grid;gap:9px}
    .flow-web .hb{height:11px;border-radius:99px;background:var(--grad);width:70%}
    .flow-web .ln{height:8px;border-radius:99px;background:rgba(255,255,255,.08)}
    .flow-web .row{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:4px}
    .flow-web .row div{height:42px;border-radius:9px;background:rgba(255,255,255,.05);border:1px solid var(--line)}
    .float-badge{position:absolute;background:var(--surface);border:1px solid var(--line-2);border-radius:14px;padding:11px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 16px 40px rgba(0,0,0,.5);font-size:13px;color:var(--text);animation:floaty 5s ease-in-out infinite}
    .float-badge .ic{width:30px;height:30px;border-radius:8px;background:var(--grad-soft);display:grid;place-items:center;color:var(--fuchsia)}
    .float-badge .ic svg{width:16px;height:16px}
    .fb-a{top:-18px;left:-14px}.fb-b{bottom:-16px;right:-10px;animation-delay:1.4s}
    @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    /* stats */
    .stats{border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:rgba(255,255,255,.02)}
    .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;padding:44px 0}
    .stat{text-align:center}
    .stat b{display:block;font-family:var(--display);font-size:clamp(34px,5vw,52px);font-weight:800;letter-spacing:-.03em;line-height:1}
    .stat span{font-size:14px;color:var(--dim);margin-top:8px;display:block}
    /* synergy */
    .syn-grid{display:grid;grid-template-columns:1fr auto 1fr;gap:24px;align-items:stretch}
    .syn{background:linear-gradient(160deg,var(--surface-2),var(--surface));border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px;position:relative;overflow:hidden;transition:var(--t)}
    .syn:hover{transform:translateY(-6px);border-color:var(--line-2)}
    .syn .tag{font-family:var(--display);font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--fuchsia);margin-bottom:14px}
    .syn h3{font-size:23px;margin-bottom:12px}
    .syn p{font-size:14.5px}
    .syn ul{display:grid;gap:10px;margin-top:18px}
    .syn li{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:var(--text)}
    .syn li svg{width:18px;height:18px;color:var(--emerald);flex-shrink:0;margin-top:2px}
    .syn-x{display:grid;place-items:center;width:60px}
    .syn-x span{width:56px;height:56px;border-radius:50%;background:var(--grad);display:grid;place-items:center;font-family:var(--display);font-weight:800;color:#fff;font-size:18px;box-shadow:0 14px 34px rgba(226,61,208,.4)}
    /* packages */
    .pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .pkg{background:linear-gradient(165deg,var(--surface-2),var(--surface));border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px 30px;position:relative;overflow:hidden;transition:var(--t)}
    .pkg:hover{transform:translateY(-8px);border-color:var(--line-2);box-shadow:0 30px 64px rgba(0,0,0,.45)}
    .pkg.feat{border-color:transparent;background:linear-gradient(165deg,rgba(139,92,246,.16),rgba(226,61,208,.10)),var(--surface)}
    .pkg.feat::before{content:"";position:absolute;inset:0;border-radius:var(--radius-lg);padding:1px;background:var(--grad);-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
    .pkg .badge{position:absolute;top:20px;right:22px;font-family:var(--display);font-size:11px;font-weight:700;padding:5px 12px;border-radius:99px;background:var(--grad);color:#fff}
    .pkg .name{font-family:var(--display);font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--fuchsia);margin-bottom:6px}
    .pkg h3{font-size:24px;margin-bottom:12px}
    .pkg p{font-size:14px;margin-bottom:22px;min-height:66px}
    .pkg ul{display:grid;gap:11px;margin-bottom:26px}
    .pkg li{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:var(--text)}
    .pkg li svg{width:18px;height:18px;color:var(--emerald);flex-shrink:0;margin-top:2px}
    .pkg .price-note{font-size:12.5px;color:var(--dim);text-align:center;margin-top:14px}
    /* detail features */
    .feat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:22px}
    .feat-card{background:linear-gradient(160deg,var(--surface-2),var(--surface));border:1px solid var(--line);border-radius:var(--radius);padding:28px;transition:var(--t)}
    .feat-card:hover{transform:translateY(-5px);border-color:var(--line-2)}
    .feat-card .ic{width:48px;height:48px;border-radius:13px;display:grid;place-items:center;background:var(--grad-soft);border:1px solid var(--line-2);color:var(--fuchsia);margin-bottom:16px}
    .feat-card .ic svg{width:23px;height:23px}
    .feat-card h3{font-size:18px;margin-bottom:12px}
    .feat-card .chips{display:flex;flex-wrap:wrap;gap:8px}
    .feat-card .chips span{font-size:12.5px;padding:6px 12px;border-radius:99px;background:rgba(255,255,255,.05);border:1px solid var(--line);color:var(--muted)}
    /* addons */
    .addons{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;max-width:840px;margin-inline:auto}
    .addons span{font-family:var(--display);font-size:14px;font-weight:600;color:var(--text);padding:12px 20px;border-radius:99px;background:rgba(255,255,255,.04);border:1px solid var(--line-2);transition:var(--t)}
    .addons span:hover{background:var(--grad-soft);border-color:transparent}
    /* umkm band */
    .umkm{position:relative;border-radius:var(--radius-lg);overflow:hidden;background:linear-gradient(150deg,#1b1030,#0d0818);border:1px solid var(--line);padding:60px 48px;text-align:center}
    .umkm::before{content:"";position:absolute;width:560px;height:560px;border-radius:50%;background:radial-gradient(circle,rgba(226,61,208,.22),transparent 65%);top:-260px;left:50%;transform:translateX(-50%)}
    .umkm>*{position:relative;z-index:1}
    .umkm h2{font-size:clamp(28px,4vw,42px);margin-bottom:14px}
    .umkm p{max-width:620px;margin:0 auto 30px;font-size:16.5px;color:var(--muted)}
    /* contact */
    .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:center}
    .contact-card{background:linear-gradient(160deg,var(--surface-2),var(--surface));border:1px solid var(--line);border-radius:var(--radius-lg);padding:36px}
    .contact-card .row{display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid var(--line);font-size:15px;color:var(--text)}
    .contact-card .row:last-child{border-bottom:none}
    .contact-card .row .ic{width:42px;height:42px;border-radius:12px;background:var(--grad-soft);display:grid;place-items:center;color:var(--fuchsia);flex-shrink:0}
    .contact-card .row .ic svg{width:20px;height:20px}
    .contact-card .row span{font-size:12.5px;color:var(--dim);display:block}
    /* footer */
    footer{border-top:1px solid var(--line);padding:48px 0 30px;background:rgba(255,255,255,.02)}
    .foot-in{display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap}
    .foot-in p{font-size:13px;color:var(--dim)}
    .foot-links{display:flex;gap:20px}
    .foot-links a{font-size:13.5px;color:var(--muted)}
    .foot-links a:hover{color:var(--text)}
    .reveal{opacity:0;transform:translateY(28px);transition:opacity .7s var(--ease),transform .7s var(--ease)}
    .reveal.in{opacity:1;transform:none}
    @media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}.reveal{opacity:1;transform:none}}
    @media (max-width:980px){
      .hero-grid{grid-template-columns:1fr;gap:48px}
      .syn-grid{grid-template-columns:1fr}.syn-x{width:auto;transform:rotate(90deg);margin:4px 0}
      .pkg-grid{grid-template-columns:1fr;max-width:480px;margin-inline:auto}
      .feat-grid{grid-template-columns:1fr}
      .contact-grid{grid-template-columns:1fr}
      .nav-links{display:none}.burger{display:grid}
    }
    @media (max-width:560px){
      .section{padding:78px 0}
      .stats-grid{grid-template-columns:1fr;gap:30px}
      .flow{flex-direction:column}.flow-arrow{transform:rotate(90deg)}
      .hero-cta{flex-direction:column}.hero-cta .btn{width:100%}
      .umkm{padding:44px 22px}
    }
  </style>
</head>
<body>

  <nav class="nav" id="nav">
    <div class="wrap nav-in">
      <a href="#top" class="brand"><span class="x">S×C</span> Seamedia <b class="grad-text">×</b> ConWeb</a>
      <div class="nav-links">
        <a href="#kolaborasi">Kolaborasi</a>
        <a href="#paket">Paket</a>
        <a href="#detail">Yang Didapat</a>
        <a href="#kontak">Kontak</a>
      </div>
      <div class="nav-right">
        <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener">Konsultasi Gratis</a>
        <button class="burger" id="burger" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg></button>
      </div>
    </div>
  </nav>
  <div class="drawer" id="drawer">
    <a href="#kolaborasi">Kolaborasi</a>
    <a href="#paket">Paket</a>
    <a href="#detail">Yang Didapat</a>
    <a href="#kontak">Kontak</a>
    <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener" style="margin-top:10px">Konsultasi Gratis</a>
  </div>

  <!-- HERO -->
  <header class="hero" id="top">
    <div class="wrap hero-grid">
      <div class="reveal">
        <span class="eyebrow"><span class="pip"></span> Seamedia × ConWeb · Conversion Web</span>
        <h1>Social media bawa perhatian, <span class="grad-text">website bangun kepercayaan.</span></h1>
        <p class="desc">Dari konten menuju konversi nyata. Kami bantu UMKM & local brand punya rumah digital profesional — katalog, halaman order WhatsApp, dan profil bisnis yang menghasilkan.</p>
        <div class="hero-cta">
          <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener">Mulai Konsultasi<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
          <a href="#paket" class="btn btn-ghost">Lihat Paket</a>
        </div>
        <div class="hero-trust">
          <div class="av"><span>S</span><span>C</span><span>4k+</span></div>
          <span>Dipercaya ribuan creator & seller partner di seluruh Indonesia</span>
        </div>
      </div>
      <div class="hero-vis reveal" style="transition-delay:.1s">
        <div class="flow">
          <div class="flow-card flow-phone">
            <div class="scr">
              <div class="bar g"></div><div class="bar"></div>
              <div class="sq"></div>
              <div class="bar" style="width:80%"></div><div class="bar" style="width:50%"></div>
            </div>
          </div>
          <div class="flow-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></div>
          <div class="flow-card flow-web">
            <div class="scr">
              <div class="top"><i></i><i></i><i></i></div>
              <div class="body"><div class="hb"></div><div class="ln"></div><div class="ln" style="width:85%"></div><div class="row"><div></div><div></div></div></div>
            </div>
          </div>
          <div class="float-badge fb-a"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>Konten viral</div>
          <div class="float-badge fb-b"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>Konversi nyata</div>
        </div>
      </div>
    </div>
  </header>

  <!-- STATS -->
  <section class="stats">
    <div class="wrap stats-grid reveal">
      <div class="stat"><b class="grad-text">4.000+</b><span>Creator multi-platform</span></div>
      <div class="stat"><b class="grad-text">500+</b><span>Seller partnership</span></div>
      <div class="stat"><b class="grad-text">2.000+</b><span>TAP product collaboration</span></div>
    </div>
  </section>

  <!-- SYNERGY -->
  <section class="section" id="kolaborasi">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Kenapa Kolaborasi Ini</span>
        <h2 class="heading">Dua kekuatan, satu ekosistem digital</h2>
        <p class="lead">Seamedia menghadirkan perhatian lewat konten & komunitas. ConWeb mengubahnya jadi kepercayaan & penjualan lewat website profesional.</p>
      </div>
      <div class="syn-grid">
        <div class="syn reveal">
          <div class="tag">Seamedia</div>
          <h3>Membawa Perhatian</h3>
          <p>Jaringan creator, konten, dan komunitas yang membangun awareness serta mengarahkan traffic ke bisnismu.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Konten & kampanye sosial media</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Jaringan creator & seller partner</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Awareness & traffic ke brand</li>
          </ul>
        </div>
        <div class="syn-x"><span>×</span></div>
        <div class="syn reveal" style="transition-delay:.08s">
          <div class="tag" style="color:var(--amber)">ConWeb</div>
          <h3>Membangun Kepercayaan</h3>
          <p>Website profesional, katalog, dan halaman order yang mengubah perhatian menjadi konversi yang menghasilkan.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Website & landing page premium</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Katalog & funnel order WhatsApp</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Dukungan teknis & SEO dasar</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- PACKAGES (NO PRICE) -->
  <section class="section" id="paket" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Paket Kolaborasi</span>
        <h2 class="heading">Pilih paket sesuai tahap bisnismu</h2>
        <p class="lead">Setiap paket dirancang untuk membawa bisnismu naik kelas secara digital. Harga & penawaran spesial dibahas langsung saat konsultasi.</p>
      </div>
      <div class="pkg-grid">
        <div class="pkg reveal">
          <div class="name">Care</div>
          <h3>Rawat & Lanjutkan</h3>
          <p>Khusus bisnis yang sudah punya website dan ingin menjaga keberlangsungan serta performanya.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Perawatan & pembaruan rutin</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Domain, hosting & SSL terjaga</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Dukungan teknis berkelanjutan</li>
          </ul>
          <a href="{{ $waSeamedia }}" class="btn btn-ghost btn-block" target="_blank" rel="noopener">Konsultasi</a>
        </div>
        <div class="pkg feat reveal" style="transition-delay:.06s">
          <span class="badge">Paling Populer</span>
          <div class="name">Launch</div>
          <h3>Website Baru Premium</h3>
          <p>Paket pembuatan website baru dengan desain premium, lengkap hingga siap tayang & mudah dikelola.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Website / landing page (s/d 7 halaman)</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Dashboard admin & WA funnel</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>SEO basic & siap di-index Google</li>
          </ul>
          <a href="{{ $waSeamedia }}" class="btn btn-grad btn-block" target="_blank" rel="noopener">Konsultasi</a>
        </div>
        <div class="pkg reveal" style="transition-delay:.12s">
          <div class="name">Signature</div>
          <h3>Eksklusif & Custom</h3>
          <p>Untuk bisnis dengan kebutuhan lebih bervariasi yang ingin tampilan eksklusif dan ciri khas tersendiri.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Desain & fitur sepenuhnya custom</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Identitas visual khas brand</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Konsultasi mendalam & fleksibel</li>
          </ul>
          <a href="{{ $waSeamedia }}" class="btn btn-ghost btn-block" target="_blank" rel="noopener">Konsultasi</a>
        </div>
      </div>
      <p class="center" style="margin-top:24px;font-size:13.5px;color:var(--dim)">Penawaran & detail biaya dijelaskan secara personal saat sesi konsultasi — agar sesuai kebutuhan & skala bisnismu.</p>
    </div>
  </section>

  <!-- DETAIL / WHAT YOU GET -->
  <section class="section" id="detail" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Yang Kamu Dapatkan</span>
        <h2 class="heading">Lengkap dalam satu ekosistem</h2>
      </div>
      <div class="feat-grid">
        <div class="feat-card reveal">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="8" x2="22" y2="8"/></svg></div>
          <h3>Website / Landing Page</h3>
          <div class="chips"><span>Home</span><span>Profil Usaha</span><span>Produk / Menu</span><span>Keunggulan</span><span>Gallery</span><span>Testimoni</span><span>Lokasi & Maps</span></div>
        </div>
        <div class="feat-card reveal" style="transition-delay:.06s">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></div>
          <h3>Dashboard Admin Basic</h3>
          <div class="chips"><span>Profil</span><span>Produk / Menu</span><span>Promo</span><span>Gallery</span><span>Testimoni</span><span>FAQ</span><span>Kontak & Sosmed</span></div>
        </div>
        <div class="feat-card reveal">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-12.2 7.5L3 21l2-5.8A8.5 8.5 0 1 1 21 11.5z"/></svg></div>
          <h3>WhatsApp Funnel</h3>
          <div class="chips"><span>Tombol WA utama</span><span>Floating WA</span><span>Link chat otomatis</span></div>
        </div>
        <div class="feat-card reveal" style="transition-delay:.06s">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg></div>
          <h3>SEO Basic</h3>
          <div class="chips"><span>Meta title & description</span><span>Struktur ramah Google</span><span>Favicon</span><span>Sitemap</span><span>Siap di-index</span></div>
        </div>
      </div>

      <div class="sec-head center reveal" style="margin:64px auto 28px">
        <h3 style="font-size:22px">Layanan Tambahan</h3>
        <p class="lead" style="font-size:15px">Bisa ditambahkan kapan saja sesuai kebutuhan unit bisnis.</p>
      </div>
      <div class="addons reveal">
        <span>Tambah Halaman</span>
        <span>Upload Produk</span>
        <span>Edit Konten Ringan</span>
        <span>Desain Banner</span>
        <span>Maintenance Bulanan Khusus</span>
        <span>Optimasi Pencarian (SEO)</span>
        <span>Setup Google Business Profile</span>
      </div>
    </div>
  </section>

  <!-- UMKM BAND -->
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="umkm reveal">
        <span class="eyebrow" style="background:rgba(255,255,255,.06)"><span class="pip"></span> Rumah Digital untuk UMKM</span>
        <h2>Bukan sekadar aktif di sosial media —<br><span class="grad-text">saatnya punya kehadiran digital yang nyata.</span></h2>
        <p>Kolaborasi ini hadir membantu UMKM & local brand punya website profesional, katalog online, halaman order WhatsApp, dan profil bisnis digital — semua dalam satu ekosistem.</p>
        <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener">Bertumbuh Bersama Kami<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section class="section" id="kontak" style="padding-top:0">
    <div class="wrap">
      <div class="contact-grid">
        <div class="reveal">
          <span class="eyebrow"><span class="pip"></span> Konsultasi</span>
          <h2 class="heading">Mari diskusikan kebutuhan bisnismu</h2>
          <p class="lead">Ceritakan brand-mu, dan tim kami siap merekomendasikan paket yang paling pas. Gratis, tanpa kewajiban.</p>
          <div class="hero-cta" style="margin-top:26px">
            <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener">Chat WhatsApp</a>
            <a href="mailto:{{ $emailSeamedia }}" class="btn btn-ghost">Kirim Email</a>
          </div>
        </div>
        <div class="contact-card reveal" style="transition-delay:.08s">
          <div class="row"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div><strong>Agung Ando</strong><span>Seamedia Indonesia</span></div></div>
          <div class="row"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg></div><div><strong>{{ $emailSeamedia }}</strong><span>Email resmi</span></div></div>
          <div class="row"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div><div><strong>Palembang, Indonesia</strong><span>Melayani seluruh Indonesia</span></div></div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="wrap foot-in">
      <p>© {{ date('Y') }} Seamedia × ConWeb. Conversion Web Collaboration.</p>
      <div class="foot-links">
        <a href="#paket">Paket</a>
        <a href="#kontak">Kontak</a>
        <a href="https://conweb.id" target="_blank" rel="noopener">ConWeb.id</a>
      </div>
    </div>
  </footer>

  <script>
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 20));
    const burger = document.getElementById('burger'), drawer = document.getElementById('drawer');
    burger.addEventListener('click', () => { drawer.classList.toggle('open'); document.body.classList.toggle('lock', drawer.classList.contains('open')); });
    drawer.querySelectorAll('a').forEach(a => a.addEventListener('click', () => { drawer.classList.remove('open'); document.body.classList.remove('lock'); }));
    const io = new IntersectionObserver((es) => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); } }), { threshold:.12 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
  </script>
</body>
</html>
