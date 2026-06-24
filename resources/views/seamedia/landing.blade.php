<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Seamedia ConWeb — Conversion Web Partner untuk UMKM & Local Brand</title>
  <meta name="description" content="Seamedia ConWeb: social media membawa perhatian, website membangun kepercayaan. Partner pembuatan website profesional, katalog, & funnel order WhatsApp untuk UMKM dan local brand.">
  <meta name="robots" content="index, follow">
  <meta property="og:title" content="Seamedia ConWeb — Dari Konten Menuju Konversi Nyata">
  <meta property="og:description" content="Social media bawa perhatian, website bangun kepercayaan.">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  @php
    $waSeamedia = 'https://wa.me/6281234567890'; // TODO: ganti nomor WA Seamedia asli
    $emailSeamedia = 'seamediaindonesia@gmail.com';
  @endphp
  <style>
    :root{
      --ink:#06232b;--ink-2:#0f3a45;--body:#3f5b63;--muted:#7b96a0;--line:#e3eef0;--line-2:#cfe3e6;
      --bg:#fff;--soft:#f2fafb;--soft-2:#e8f6f7;
      --teal:#0d9488;--teal-d:#0f766e;--teal-l:#14b8a6;     /* Seamedia */
      --blue:#2563eb;--blue-d:#1d4ed8;                       /* ConWeb */
      --cyan:#22d3ee;
      --tint:rgba(13,148,136,.08);--tint-2:rgba(13,148,136,.16);
      --grad:linear-gradient(115deg,#0d9488 0%,#0ea5b7 45%,#2563eb 100%);
      --grad-2:linear-gradient(115deg,#14b8a6,#2563eb);
      --ok:#16a34a;
      --shadow-sm:0 1px 2px rgba(6,35,43,.06),0 2px 8px rgba(6,35,43,.05);
      --shadow:0 14px 36px rgba(6,35,43,.09),0 2px 8px rgba(6,35,43,.04);
      --shadow-lg:0 30px 70px rgba(6,35,43,.16);
      --radius:18px;--radius-lg:26px;--container:1180px;--nav-h:76px;
      --ease:cubic-bezier(.22,1,.36,1);--t:.4s var(--ease);
      --display:'Space Grotesk',sans-serif;--sans:'Plus Jakarta Sans',sans-serif;
    }
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{font-family:var(--sans);color:var(--body);background:var(--bg);line-height:1.7;-webkit-font-smoothing:antialiased;overflow-x:hidden}
    body.lock{overflow:hidden}
    a{color:inherit;text-decoration:none}ul{list-style:none}
    img,svg{display:block;max-width:100%}
    h1,h2,h3,h4{font-family:var(--display);color:var(--ink);font-weight:700;line-height:1.12;letter-spacing:-.02em}
    ::selection{background:var(--teal);color:#fff}
    ::-webkit-scrollbar{width:10px}::-webkit-scrollbar-track{background:var(--soft)}
    ::-webkit-scrollbar-thumb{background:#aacfd3;border-radius:99px;border:2px solid var(--soft)}
    .wrap{width:min(100% - 40px,var(--container));margin-inline:auto}
    .section{padding:104px 0}
    .grad-text{background:var(--grad);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
    .eyebrow{display:inline-flex;align-items:center;gap:9px;font-family:var(--display);font-weight:600;font-size:12.5px;letter-spacing:.14em;text-transform:uppercase;color:var(--teal-d);padding:7px 14px;border-radius:99px;background:var(--tint);border:1px solid var(--tint-2);margin-bottom:20px}
    .eyebrow .pip{width:7px;height:7px;border-radius:50%;background:var(--teal);box-shadow:0 0 0 4px rgba(13,148,136,.18)}
    .heading{font-size:clamp(30px,4.3vw,46px);margin-bottom:16px}
    .lead{font-size:clamp(16px,1.5vw,17.5px);color:var(--body);max-width:620px}
    .center{text-align:center}.center .lead{margin-inline:auto}
    .sec-head{max-width:680px;margin-bottom:54px}.sec-head.center{margin-inline:auto}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;font-family:var(--display);font-weight:600;font-size:15px;padding:14px 24px;border-radius:13px;transition:var(--t);cursor:pointer;border:none;white-space:nowrap}
    .btn svg{width:18px;height:18px;transition:transform var(--t)}
    .btn-grad{background:var(--grad);color:#fff;box-shadow:0 12px 28px rgba(13,148,136,.32)}
    .btn-grad:hover{transform:translateY(-2px);box-shadow:0 18px 38px rgba(37,99,235,.34)}
    .btn-grad:hover svg{transform:translateX(3px)}
    .btn-line{background:#fff;color:var(--ink);border:1px solid var(--line-2);box-shadow:var(--shadow-sm)}
    .btn-line:hover{border-color:var(--teal-l);color:var(--teal-d);transform:translateY(-2px)}
    .btn-light{background:#fff;color:var(--ink)}.btn-light:hover{transform:translateY(-2px);box-shadow:0 16px 32px rgba(0,0,0,.18)}
    .btn-outline-light{border:1px solid rgba(255,255,255,.3);color:#fff;background:rgba(255,255,255,.06)}.btn-outline-light:hover{background:rgba(255,255,255,.12);transform:translateY(-2px)}
    .btn-block{width:100%}
    .tag{display:inline-flex;align-items:center;gap:7px;font-family:var(--display);font-size:12.5px;font-weight:500;padding:6px 12px;border-radius:99px;background:var(--soft-2);color:var(--ink-2);border:1px solid var(--line)}
    .dot{width:7px;height:7px;border-radius:50%;background:var(--ok);box-shadow:0 0 0 4px rgba(22,163,74,.16)}
    /* nav */
    .nav{position:fixed;inset:0 0 auto 0;z-index:100;transition:var(--t);background:rgba(255,255,255,.82);backdrop-filter:blur(16px);border-bottom:1px solid var(--line)}
    .nav.scrolled{background:rgba(255,255,255,.95);box-shadow:0 2px 20px rgba(6,35,43,.05)}
    .nav-in{height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;gap:20px}
    .brand{display:flex;align-items:center;gap:11px;font-family:var(--display);font-weight:700;font-size:19px;letter-spacing:-.02em;flex-shrink:0}
    .brand .mk{width:42px;height:42px;border-radius:13px;display:grid;place-items:center;background:var(--grad);color:#fff;flex-shrink:0;box-shadow:0 8px 18px rgba(13,148,136,.3)}
    .brand .mk svg{width:23px;height:23px}
    .brand .tx b:first-child{color:var(--teal-d)}.brand .tx b:last-child{color:var(--blue-d)}
    .nav-links{display:flex;align-items:center;gap:28px}
    .nav-links a{font-size:14px;font-weight:500;color:var(--ink-2);position:relative;transition:var(--t)}
    .nav-links a::after{content:"";position:absolute;left:0;bottom:-5px;height:2px;width:0;background:var(--grad);border-radius:2px;transition:var(--t)}
    .nav-links a:hover{color:var(--teal-d)}.nav-links a:hover::after{width:100%}
    .nav-right{display:flex;align-items:center;gap:12px}
    .burger{display:none;width:44px;height:44px;border-radius:12px;border:1px solid var(--line-2);background:#fff;place-items:center;color:var(--ink)}
    .burger svg{width:22px;height:22px}
    .drawer{position:fixed;inset:var(--nav-h) 0 auto 0;z-index:99;background:#fff;border-bottom:1px solid var(--line);padding:18px 20px 26px;display:none;flex-direction:column;gap:6px;box-shadow:var(--shadow)}
    .drawer.open{display:flex}
    .drawer a{padding:13px 14px;border-radius:12px;font-weight:600;color:var(--ink-2)}
    .drawer a:hover{background:var(--soft-2);color:var(--teal-d)}
    /* hero */
    .hero{position:relative;padding-top:calc(var(--nav-h) + 70px);padding-bottom:88px;overflow:hidden}
    .hero::before{content:"";position:absolute;inset:0;z-index:-2;background:radial-gradient(880px 480px at 80% -8%,rgba(34,211,238,.18),transparent 60%),radial-gradient(760px 520px at 4% 0%,rgba(13,148,136,.14),transparent 58%),linear-gradient(180deg,var(--soft) 0%,#fff 62%)}
    .hero::after{content:"";position:absolute;inset:0;z-index:-1;opacity:.5;background-image:linear-gradient(var(--line) 1px,transparent 1px),linear-gradient(90deg,var(--line) 1px,transparent 1px);background-size:46px 46px;mask-image:radial-gradient(720px 460px at 72% 24%,#000,transparent 75%);-webkit-mask-image:radial-gradient(720px 460px at 72% 24%,#000,transparent 75%)}
    .hero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:54px;align-items:center}
    .hero h1{font-size:clamp(36px,5.3vw,58px);letter-spacing:-.035em;margin-bottom:22px}
    .hero p.desc{font-size:17.5px;max-width:545px;margin-bottom:30px}
    .hero-cta{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:34px}
    .hero-trust{display:flex;align-items:center;gap:22px;flex-wrap:wrap}
    .avatars{display:flex}
    .avatars span{width:40px;height:40px;border-radius:50%;border:2.5px solid #fff;margin-left:-12px;display:grid;place-items:center;font-family:var(--display);font-weight:700;font-size:13px;color:#fff}
    .avatars span:first-child{margin-left:0}
    .avatars span:nth-child(1){background:linear-gradient(135deg,#14b8a6,#0f766e)}
    .avatars span:nth-child(2){background:linear-gradient(135deg,#22d3ee,#0ea5b7)}
    .avatars span:nth-child(3){background:linear-gradient(135deg,#3b82f6,#1d4ed8)}
    .avatars span:nth-child(4){background:linear-gradient(135deg,#06232b,#0f3a45);font-size:11px}
    .trust-text strong{display:block;font-family:var(--display);color:var(--ink);font-size:15px}
    .trust-text span{font-size:13px;color:var(--muted)}
    .stars{color:#f5b50a;letter-spacing:2px;font-size:13px}
    /* hero visual */
    .hero-vis{position:relative}
    .window{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);box-shadow:var(--shadow-lg);overflow:hidden;position:relative}
    .win-bar{display:flex;align-items:center;gap:7px;padding:14px 18px;border-bottom:1px solid var(--line);background:var(--soft)}
    .win-bar i{width:11px;height:11px;border-radius:50%;background:#cfe3e6}
    .win-bar i:nth-child(1){background:#ff6058}.win-bar i:nth-child(2){background:#febc2e}.win-bar i:nth-child(3){background:#28c840}
    .win-url{margin-left:12px;font-family:var(--display);font-size:12px;color:var(--muted);background:#fff;border:1px solid var(--line);border-radius:8px;padding:5px 12px}
    .win-body{padding:22px}
    .win-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
    .win-row h4{font-size:16px}
    .win-pill{font-family:var(--display);font-size:11px;font-weight:600;color:var(--ok);background:rgba(22,163,74,.1);padding:5px 11px;border-radius:99px}
    .win-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .win-stat{background:var(--soft);border:1px solid var(--line);border-radius:14px;padding:14px}
    .win-stat span{font-family:var(--display);font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em}
    .win-stat b{display:block;font-family:var(--display);font-size:21px;color:var(--ink);margin-top:4px}
    .win-stat b em{font-style:normal;font-size:12px;color:var(--ok);margin-left:4px}
    .win-chart{display:flex;align-items:flex-end;gap:9px;height:116px;padding:16px;background:var(--soft);border:1px solid var(--line);border-radius:16px}
    .win-chart i{flex:1;border-radius:6px 6px 3px 3px;background:var(--grad);opacity:.9;animation:rise 1s var(--ease) backwards}
    .win-chart i:nth-child(odd){background:linear-gradient(180deg,#bdeef0,#7fd6dc)}
    @keyframes rise{from{height:0!important;opacity:0}}
    .float-card{position:absolute;background:#fff;border:1px solid var(--line);border-radius:16px;padding:13px 16px;box-shadow:var(--shadow);display:flex;align-items:center;gap:12px;animation:floaty 5s ease-in-out infinite}
    .float-card .ic{width:40px;height:40px;border-radius:11px;display:grid;place-items:center;flex-shrink:0}
    .float-card .ic svg{width:20px;height:20px}
    .float-card strong{display:block;font-family:var(--display);font-size:14px;color:var(--ink);line-height:1.2}
    .float-card span{font-size:12px;color:var(--muted)}
    .float-a{top:-22px;left:-26px}.float-a .ic{background:var(--tint);color:var(--teal-d)}
    .float-b{bottom:-24px;right:-22px;animation-delay:1.2s}.float-b .ic{background:rgba(37,99,235,.1);color:var(--blue-d)}
    @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    /* stats */
    .stats{padding:40px 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:var(--soft)}
    .stats p.k{text-align:center;font-family:var(--display);font-size:12.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:26px}
    .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .stat{text-align:center;position:relative}
    .stat:not(:last-child)::after{content:"";position:absolute;right:-12px;top:14%;height:72%;width:1px;background:var(--line-2)}
    .stat b{display:block;font-family:var(--display);font-size:clamp(32px,4.4vw,50px);letter-spacing:-.04em;line-height:1}
    .stat span{font-size:14px;color:var(--body);margin-top:8px;display:block;font-weight:500}
    /* synergy */
    .syn-grid{display:grid;grid-template-columns:1fr auto 1fr;gap:24px;align-items:stretch}
    .syn{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px;box-shadow:var(--shadow-sm);transition:var(--t);position:relative;overflow:hidden}
    .syn::before{content:"";position:absolute;inset:0 0 auto 0;height:4px;background:var(--grad);transform:scaleX(0);transform-origin:left;transition:transform .5s var(--ease)}
    .syn:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}.syn:hover::before{transform:scaleX(1)}
    .syn .t{font-family:var(--display);font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:14px}
    .syn h3{font-size:22px;margin-bottom:10px}.syn p{font-size:14.5px}
    .syn ul{display:grid;gap:10px;margin-top:18px}
    .syn li{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:var(--ink-2)}
    .syn li svg{width:18px;height:18px;color:var(--teal);flex-shrink:0;margin-top:2px}
    .syn-x{display:grid;place-items:center;width:64px}
    .syn-x span{width:60px;height:60px;border-radius:50%;background:var(--grad);display:grid;place-items:center;color:#fff;box-shadow:0 14px 30px rgba(13,148,136,.35)}
    .syn-x svg{width:26px;height:26px}
    /* services */
    .services{background:var(--soft)}
    .svc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .svc{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:32px;box-shadow:var(--shadow-sm);transition:var(--t);position:relative;overflow:hidden}
    .svc:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg);border-color:var(--line-2)}
    .svc-ic{width:54px;height:54px;border-radius:15px;display:grid;place-items:center;margin-bottom:20px;background:var(--tint);color:var(--teal-d);border:1px solid var(--tint-2)}
    .svc-ic svg{width:25px;height:25px}
    .svc h3{font-size:19px;margin-bottom:9px}
    .svc p{font-size:14px}
    /* packages */
    .pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .pkg{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px 30px;box-shadow:var(--shadow-sm);transition:var(--t);position:relative;overflow:hidden}
    .pkg:hover{transform:translateY(-8px);box-shadow:var(--shadow-lg)}
    .pkg.feat{border-color:transparent;box-shadow:var(--shadow-lg)}
    .pkg.feat::before{content:"";position:absolute;inset:0;border-radius:var(--radius-lg);padding:1.5px;background:var(--grad);-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
    .pkg .badge{position:absolute;top:20px;right:22px;font-family:var(--display);font-size:11px;font-weight:700;padding:5px 12px;border-radius:99px;background:var(--grad);color:#fff}
    .pkg .name{font-family:var(--display);font-size:12.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--teal-d);margin-bottom:6px}
    .pkg h3{font-size:23px;margin-bottom:12px}
    .pkg p{font-size:14px;margin-bottom:22px;min-height:64px}
    .pkg ul{display:grid;gap:11px;margin-bottom:26px}
    .pkg li{display:flex;gap:10px;align-items:flex-start;font-size:14px;color:var(--ink-2)}
    .pkg li svg{width:18px;height:18px;color:var(--ok);flex-shrink:0;margin-top:2px}
    /* feature detail */
    .feat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:22px}
    .feat-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px;box-shadow:var(--shadow-sm);transition:var(--t)}
    .feat-card:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:var(--tint-2)}
    .feat-card .ic{width:48px;height:48px;border-radius:13px;display:grid;place-items:center;background:var(--tint);color:var(--teal-d);margin-bottom:16px}
    .feat-card .ic svg{width:23px;height:23px}
    .feat-card h3{font-size:18px;margin-bottom:12px}
    .feat-card .chips{display:flex;flex-wrap:wrap;gap:8px}
    .feat-card .chips span{font-size:12.5px;padding:6px 12px;border-radius:99px;background:var(--soft-2);border:1px solid var(--line);color:var(--ink-2)}
    /* process */
    .process{background:var(--soft)}
    .proc-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px}
    .proc{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:30px 26px;box-shadow:var(--shadow-sm);transition:var(--t)}
    .proc:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:var(--tint-2)}
    .proc-num{font-family:var(--display);font-weight:700;font-size:14px;color:#fff;width:42px;height:42px;border-radius:12px;display:grid;place-items:center;background:var(--grad);margin-bottom:18px;box-shadow:0 8px 16px rgba(13,148,136,.3)}
    .proc h3{font-size:18px;margin-bottom:9px}.proc p{font-size:14px}
    /* addons */
    .addons{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;max-width:820px;margin-inline:auto}
    .addons span{font-family:var(--display);font-size:14px;font-weight:600;color:var(--ink-2);padding:12px 20px;border-radius:99px;background:#fff;border:1px solid var(--line-2);box-shadow:var(--shadow-sm);transition:var(--t)}
    .addons span:hover{color:var(--teal-d);border-color:var(--teal-l);transform:translateY(-2px)}
    /* quote */
    .quote-wrap{background:linear-gradient(160deg,var(--ink),#0a2e38);border-radius:var(--radius-lg);padding:54px 48px;color:#fff;position:relative;overflow:hidden;box-shadow:var(--shadow-lg)}
    .quote-wrap::before{content:"";position:absolute;width:360px;height:360px;border-radius:50%;background:radial-gradient(circle,rgba(34,211,238,.28),transparent 65%);top:-140px;right:-90px}
    .quote-wrap .qm{font-family:var(--display);font-size:64px;line-height:.5;color:var(--cyan);margin-bottom:18px}
    .quote-wrap blockquote{font-family:var(--display);font-size:clamp(20px,2.4vw,28px);font-weight:600;line-height:1.5;color:#fff;max-width:860px;position:relative;z-index:1;margin-bottom:22px}
    .quote-wrap .by{font-size:14px;color:#a9cfd6;position:relative;z-index:1}
    /* CTA */
    .cta-wrap{position:relative;border-radius:var(--radius-lg);overflow:hidden;background:var(--grad);padding:64px 48px;text-align:center;box-shadow:var(--shadow-lg)}
    .cta-wrap::after{content:"";position:absolute;inset:0;opacity:.5;background-image:linear-gradient(rgba(255,255,255,.08) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.08) 1px,transparent 1px);background-size:40px 40px;mask-image:radial-gradient(circle at 50% 0%,#000,transparent 70%)}
    .cta-wrap>*{position:relative;z-index:1}
    .cta-wrap h2{color:#fff;font-size:clamp(28px,4.4vw,44px);margin-bottom:14px;letter-spacing:-.03em}
    .cta-wrap p{color:rgba(255,255,255,.9);max-width:580px;margin:0 auto 30px;font-size:16.5px}
    .cta-actions{display:flex;flex-wrap:wrap;gap:14px;justify-content:center}
    /* contact */
    .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:center}
    .contact-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px;box-shadow:var(--shadow-sm)}
    .contact-card .row{display:flex;align-items:center;gap:14px;padding:15px 0;border-bottom:1px solid var(--line)}
    .contact-card .row:last-child{border-bottom:none}
    .contact-card .row .ic{width:44px;height:44px;border-radius:12px;background:var(--tint);display:grid;place-items:center;color:var(--teal-d);flex-shrink:0}
    .contact-card .row .ic svg{width:21px;height:21px}
    .contact-card .row strong{font-family:var(--display);font-size:15px;color:var(--ink);display:block}
    .contact-card .row span{font-size:13px;color:var(--muted)}
    /* footer */
    footer{background:var(--ink);color:#9fc0c6;padding:60px 0 28px}
    .foot-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr;gap:40px;padding-bottom:40px;border-bottom:1px solid rgba(255,255,255,.1)}
    .foot-brand .brand{color:#fff;margin-bottom:14px}.foot-brand .brand .tx b{color:#fff!important}
    .foot-brand p{font-size:14px;max-width:320px;margin-bottom:18px}
    .foot-col h4{font-family:var(--display);font-size:14px;color:#fff;margin-bottom:16px}
    .foot-col a{display:block;font-size:14px;color:#9fc0c6;padding:6px 0;transition:var(--t)}
    .foot-col a:hover{color:#fff;padding-left:4px}
    .foot-bottom{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;padding-top:24px}
    .foot-bottom p{font-size:13px;color:#7ba3aa}
    .reveal{opacity:0;transform:translateY(28px);transition:opacity .7s var(--ease),transform .7s var(--ease)}
    .reveal.in{opacity:1;transform:none}
    @media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}.reveal{opacity:1;transform:none}}
    @media (max-width:1080px){.hero-grid{grid-template-columns:1fr;gap:48px}.hero-vis{max-width:520px;margin-inline:auto;width:100%}
      .syn-grid{grid-template-columns:1fr}.syn-x{width:auto;transform:rotate(90deg);margin:2px 0}
      .svc-grid,.pkg-grid{grid-template-columns:1fr 1fr}.proc-grid{grid-template-columns:1fr 1fr}}
    @media (max-width:920px){.nav-links{display:none}.nav-right>.btn{display:none}.burger{display:grid}}
    @media (max-width:760px){.feat-grid,.contact-grid{grid-template-columns:1fr}}
    @media (max-width:640px){.section{padding:74px 0}.hero{padding-top:calc(var(--nav-h) + 44px)}.hero h1{font-size:clamp(31px,9vw,42px)}
      .hero-cta{flex-direction:column}.hero-cta .btn{width:100%}.svc-grid,.pkg-grid,.proc-grid{grid-template-columns:1fr}
      .stats-grid{grid-template-columns:1fr;gap:30px}.stat::after{display:none}.foot-grid{grid-template-columns:1fr}
      .cta-wrap,.quote-wrap{padding:44px 24px}}
  </style>
</head>
<body id="top">

  <nav class="nav" id="nav">
    <div class="wrap nav-in">
      <a href="#top" class="brand">
        <span class="mk"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 15c2.5-2 5-2 7.5 0s5 2 7.5 0"/><path d="M3 10c2.5-2 5-2 7.5 0s5 2 7.5 0"/><circle cx="18.5" cy="6" r="1.6" fill="currentColor"/></svg></span>
        <span class="tx"><b>Seamedia</b> <b>ConWeb</b></span>
      </a>
      <div class="nav-links">
        <a href="#kolaborasi">Kolaborasi</a>
        <a href="#layanan">Layanan</a>
        <a href="#paket">Paket</a>
        <a href="#proses">Proses</a>
        <a href="#kontak">Kontak</a>
      </div>
      <div class="nav-right">
        <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener">Konsultasi Gratis</a>
        <button class="burger" id="burger" aria-label="Menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg></button>
      </div>
    </div>
  </nav>
  <div class="drawer" id="drawer">
    <a href="#kolaborasi">Kolaborasi</a><a href="#layanan">Layanan</a><a href="#paket">Paket</a><a href="#proses">Proses</a><a href="#kontak">Kontak</a>
    <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener" style="margin-top:10px">Konsultasi Gratis</a>
  </div>

  <!-- HERO -->
  <header class="hero">
    <div class="wrap hero-grid">
      <div class="reveal">
        <span class="eyebrow"><span class="pip"></span> Conversion Web Partner</span>
        <h1>Social media bawa perhatian, <span class="grad-text">website bangun kepercayaan.</span></h1>
        <p class="desc">Seamedia ConWeb membantu UMKM & local brand punya rumah digital profesional — website, katalog produk, dan funnel order WhatsApp — agar perhatian dari konten berubah jadi konversi nyata.</p>
        <div class="hero-cta">
          <a href="{{ $waSeamedia }}" class="btn btn-grad" target="_blank" rel="noopener">Mulai Konsultasi<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
          <a href="#paket" class="btn btn-line">Lihat Paket</a>
        </div>
        <div class="hero-trust">
          <div class="avatars"><span>S</span><span>C</span><span>U</span><span>4k+</span></div>
          <div class="trust-text"><div class="stars">★★★★★</div><strong>Dipercaya ribuan creator & seller</strong><span>UMKM & local brand se-Indonesia</span></div>
        </div>
      </div>
      <div class="hero-vis reveal" style="transition-delay:.1s">
        <div class="window">
          <div class="win-bar"><i></i><i></i><i></i><span class="win-url">brandkamu.id</span></div>
          <div class="win-body">
            <div class="win-row"><h4>Performa Bisnis</h4><span class="win-pill">● Live</span></div>
            <div class="win-stats">
              <div class="win-stat"><span>Pengunjung</span><b>9.2k <em>+24%</em></b></div>
              <div class="win-stat"><span>Klik WA</span><b>1.4k <em>+31%</em></b></div>
              <div class="win-stat"><span>Order</span><b>680 <em>+18%</em></b></div>
            </div>
            <div class="win-chart"><i style="height:42%;animation-delay:.05s"></i><i style="height:64%;animation-delay:.1s"></i><i style="height:50%;animation-delay:.15s"></i><i style="height:80%;animation-delay:.2s"></i><i style="height:60%;animation-delay:.25s"></i><i style="height:92%;animation-delay:.3s"></i><i style="height:72%;animation-delay:.35s"></i><i style="height:100%;animation-delay:.4s"></i></div>
          </div>
        </div>
        <div class="float-card float-a"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div><div><strong>Konten Viral</strong><span>Awareness naik</span></div></div>
        <div class="float-card float-b"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div><div><strong>Order Masuk</strong><span>Konversi nyata</span></div></div>
      </div>
    </div>
  </header>

  <!-- STATS -->
  <section class="stats">
    <div class="wrap">
      <p class="k reveal">Tumbuh bersama ekosistem Seamedia</p>
      <div class="stats-grid reveal">
        <div class="stat"><b class="grad-text">4.000+</b><span>Creator multi-platform</span></div>
        <div class="stat"><b class="grad-text">500+</b><span>Seller partnership</span></div>
        <div class="stat"><b class="grad-text">2.000+</b><span>TAP product collaboration</span></div>
      </div>
    </div>
  </section>

  <!-- SYNERGY -->
  <section class="section" id="kolaborasi">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Kenapa Seamedia ConWeb</span>
        <h2 class="heading">Dua kekuatan, satu ekosistem digital</h2>
        <p class="lead">Seamedia menghadirkan perhatian lewat konten & komunitas. ConWeb mengubahnya menjadi kepercayaan dan penjualan lewat website profesional.</p>
      </div>
      <div class="syn-grid">
        <div class="syn reveal">
          <div class="t" style="color:var(--teal-d)">Seamedia</div>
          <h3>Membawa Perhatian</h3>
          <p>Jaringan creator, konten, dan komunitas yang membangun awareness serta mengarahkan traffic ke bisnismu.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Konten & kampanye sosial media</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Jaringan creator & seller partner</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Awareness & traffic ke brand</li>
          </ul>
        </div>
        <div class="syn-x"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></div>
        <div class="syn reveal" style="transition-delay:.08s">
          <div class="t" style="color:var(--blue-d)">ConWeb</div>
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

  <!-- SERVICES -->
  <section class="section services" id="layanan">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Layanan Kami</span>
        <h2 class="heading">Semua yang bisnismu butuhkan untuk online</h2>
        <p class="lead">Dari halaman pertama hingga sistem order, kami siapkan rumah digital yang rapi, cepat, dan mudah dikelola.</p>
      </div>
      <div class="svc-grid">
        @php
        $svc = [
          ['web','Website & Landing Page','Company profile, katalog, dan landing page premium yang membangun kredibilitas brand.'],
          ['cart','Katalog Produk Online','Tampilkan produk/menu rapi dengan detail, foto, dan tombol order langsung.'],
          ['wa','Funnel Order WhatsApp','Arahkan traffic ke chat WhatsApp dengan tombol & format pesan otomatis.'],
          ['panel','Dashboard Admin','Kelola profil, produk, promo, galeri, dan testimoni sendiri dengan mudah.'],
          ['seo','SEO & Google Ready','Struktur ramah Google, meta, sitemap, hingga Google Business Profile.'],
          ['care','Maintenance & Support','Perawatan rutin, update konten, dan dukungan teknis berkelanjutan.'],
        ];
        $icons = [
          'web'=>'<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="2" y1="8" x2="22" y2="8"/><line x1="8" y1="21" x2="16" y2="21"/>',
          'cart'=>'<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/>',
          'wa'=>'<path d="M21 11.5a8.4 8.4 0 0 1-12.2 7.5L3 21l2-5.8A8.5 8.5 0 1 1 21 11.5z"/>',
          'panel'=>'<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
          'seo'=>'<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
          'care'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
        ];
        @endphp
        @foreach($svc as $i => $s)
        <div class="svc reveal" style="transition-delay:{{ ($i%3)*.06 }}s">
          <div class="svc-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$s[0]] !!}</svg></div>
          <h3>{{ $s[1] }}</h3>
          <p>{{ $s[2] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- PACKAGES (NO PRICE) -->
  <section class="section" id="paket">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Paket Kolaborasi</span>
        <h2 class="heading">Pilih paket sesuai tahap bisnismu</h2>
        <p class="lead">Setiap paket dirancang membawa bisnismu naik kelas. Penawaran & detail dibahas langsung saat konsultasi agar pas dengan kebutuhanmu.</p>
      </div>
      <div class="pkg-grid">
        <div class="pkg reveal">
          <div class="name">Care</div>
          <h3>Rawat & Lanjutkan</h3>
          <p>Untuk bisnis yang sudah punya website dan ingin menjaga keberlangsungan serta performanya.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Perawatan & pembaruan rutin</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Domain, hosting & SSL terjaga</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Dukungan teknis berkelanjutan</li>
          </ul>
          <a href="{{ $waSeamedia }}" class="btn btn-line btn-block" target="_blank" rel="noopener">Konsultasi</a>
        </div>
        <div class="pkg feat reveal" style="transition-delay:.06s">
          <span class="badge">Paling Populer</span>
          <div class="name">Launch</div>
          <h3>Website Baru Premium</h3>
          <p>Pembuatan website baru dengan desain premium, lengkap hingga siap tayang & mudah dikelola.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Website / landing page (s/d 7 halaman)</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Dashboard admin & WhatsApp funnel</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>SEO basic & siap di-index Google</li>
          </ul>
          <a href="{{ $waSeamedia }}" class="btn btn-grad btn-block" target="_blank" rel="noopener">Konsultasi</a>
        </div>
        <div class="pkg reveal" style="transition-delay:.12s">
          <div class="name">Signature</div>
          <h3>Eksklusif & Custom</h3>
          <p>Untuk bisnis dengan kebutuhan lebih bervariasi yang ingin tampilan eksklusif & berciri khas.</p>
          <ul>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Desain & fitur sepenuhnya custom</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Identitas visual khas brand</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Konsultasi mendalam & fleksibel</li>
          </ul>
          <a href="{{ $waSeamedia }}" class="btn btn-line btn-block" target="_blank" rel="noopener">Konsultasi</a>
        </div>
      </div>
      <p class="center" style="margin-top:24px;font-size:13.5px;color:var(--muted)">Penawaran & detail biaya dijelaskan secara personal saat sesi konsultasi — agar sesuai kebutuhan & skala bisnismu.</p>
    </div>
  </section>

  <!-- WHAT YOU GET -->
  <section class="section services">
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
    </div>
  </section>

  <!-- PROCESS -->
  <section class="section process" id="proses">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Cara Kerja</span>
        <h2 class="heading">Proses yang jelas, hasil yang terukur</h2>
        <p class="lead">Empat langkah sederhana dari obrolan awal hingga website tayang dan terus bertumbuh.</p>
      </div>
      <div class="proc-grid">
        @php $proc = [['Konsultasi','Kami pahami brand, target, dan kebutuhan bisnismu.'],['Desain & Setup','Menyusun tampilan, konten, domain, hosting & SSL.'],['Pengembangan','Membangun website, katalog, funnel WA, dan SEO dasar.'],['Tayang & Rawat','Website live, lalu didampingi update & maintenance.']]; @endphp
        @foreach($proc as $i => $p)
        <div class="proc reveal" style="transition-delay:{{ $i*.06 }}s"><div class="proc-num">{{ sprintf('%02d',$i+1) }}</div><h3>{{ $p[0] }}</h3><p>{{ $p[1] }}</p></div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ADD-ONS -->
  <section class="section">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow"><span class="pip"></span> Layanan Tambahan</span>
        <h2 class="heading">Tambah sesuai kebutuhan, kapan saja</h2>
      </div>
      <div class="addons reveal">
        <span>Tambah Halaman</span><span>Upload Produk</span><span>Edit Konten Ringan</span><span>Desain Banner</span><span>Maintenance Bulanan Khusus</span><span>Optimasi Pencarian (SEO)</span><span>Setup Google Business Profile</span>
      </div>
    </div>
  </section>

  <!-- QUOTE -->
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="quote-wrap reveal">
        <div class="qm">&ldquo;</div>
        <blockquote>Di era biaya digital dan potongan platform yang terus meningkat, memiliki website bukan lagi pilihan — melainkan kebutuhan.</blockquote>
        <div class="by">— Seamedia ConWeb · Conversion Web</div>
      </div>
    </div>
  </section>

  <!-- UMKM CTA -->
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <h2>Saatnya UMKM punya kehadiran digital yang nyata</h2>
        <p>Bukan sekadar aktif di sosial media — miliki website profesional, katalog online, dan halaman order WhatsApp dalam satu ekosistem.</p>
        <div class="cta-actions">
          <a href="{{ $waSeamedia }}" class="btn btn-light" target="_blank" rel="noopener">Bertumbuh Bersama Kami</a>
          <a href="#paket" class="btn btn-outline-light">Lihat Paket</a>
        </div>
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
            <a href="mailto:{{ $emailSeamedia }}" class="btn btn-line">Kirim Email</a>
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
    <div class="wrap">
      <div class="foot-grid">
        <div class="foot-brand">
          <a href="#top" class="brand"><span class="mk"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 15c2.5-2 5-2 7.5 0s5 2 7.5 0"/><path d="M3 10c2.5-2 5-2 7.5 0s5 2 7.5 0"/><circle cx="18.5" cy="6" r="1.6" fill="currentColor"/></svg></span><span class="tx"><b>Seamedia</b> <b>ConWeb</b></span></a>
          <p>Conversion Web — social media bawa perhatian, website bangun kepercayaan. Partner digital untuk UMKM & local brand.</p>
        </div>
        <div class="foot-col">
          <h4>Navigasi</h4>
          <a href="#kolaborasi">Kolaborasi</a><a href="#layanan">Layanan</a><a href="#paket">Paket</a><a href="#proses">Proses</a>
        </div>
        <div class="foot-col">
          <h4>Kontak</h4>
          <a href="mailto:{{ $emailSeamedia }}">{{ $emailSeamedia }}</a>
          <a href="{{ $waSeamedia }}" target="_blank" rel="noopener">WhatsApp</a>
          <a href="https://conweb.id" target="_blank" rel="noopener">ConWeb.id</a>
        </div>
      </div>
      <div class="foot-bottom">
        <p>© {{ date('Y') }} Seamedia ConWeb. Conversion Web Collaboration.</p>
        <p>Dibuat dengan ❤️ untuk UMKM Indonesia</p>
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
