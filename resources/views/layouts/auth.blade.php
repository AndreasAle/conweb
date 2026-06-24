<!DOCTYPE html>
<html lang="{{ site_locale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Akun') — {{ $brand }} {{ $suffix }}</title>
  @if(!empty($s['site.favicon']))<link rel="icon" href="{{ asset('storage/'.$s['site.favicon']) }}">@endif
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root{
      --ink:#0a1633;--ink-2:#1c2a4a;--body:#4b5a78;--muted:#8190ab;--line:#e6ecf7;--line-2:#d9e2f2;
      --bg:#fff;--soft:#f5f8ff;--soft-2:#eef3fe;--brand:#2563eb;--brand-d:#1d4ed8;--brand-l:#3b82f6;
      --brand-tint:rgba(37,99,235,.08);--brand-tint-2:rgba(37,99,235,.14);--sky:#38bdf8;--navy:#0a1530;--navy-2:#0f1d3d;--ok:#22c55e;
      --shadow-sm:0 1px 2px rgba(13,30,70,.06),0 2px 8px rgba(13,30,70,.05);
      --shadow:0 12px 32px rgba(13,30,70,.08);--shadow-lg:0 28px 64px rgba(13,30,70,.14);
      --radius:18px;--radius-lg:26px;--display:'Space Grotesk',sans-serif;--sans:'Plus Jakarta Sans',sans-serif;
      --ease:cubic-bezier(.22,1,.36,1);--t:.35s var(--ease);
    }
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:var(--sans);color:var(--body);background:var(--soft-2);line-height:1.6;-webkit-font-smoothing:antialiased}
    a{color:inherit;text-decoration:none}
    h1,h2,h3{font-family:var(--display);color:var(--ink);letter-spacing:-.02em;line-height:1.15}
    .auth-shell{min-height:100vh;display:grid;grid-template-columns:1.05fr 1fr}
    /* brand side */
    .auth-brand{position:relative;overflow:hidden;background:linear-gradient(160deg,var(--navy),var(--navy-2));color:#fff;padding:56px 56px;display:flex;flex-direction:column;justify-content:space-between}
    .auth-brand::before{content:"";position:absolute;width:560px;height:560px;border-radius:50%;background:radial-gradient(circle,rgba(56,189,248,.28),transparent 65%);top:-180px;right:-160px}
    .auth-brand::after{content:"";position:absolute;inset:0;opacity:.4;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:42px 42px;mask-image:radial-gradient(680px 460px at 70% 30%,#000,transparent 75%)}
    .auth-brand>*{position:relative;z-index:1}
    .auth-logo{display:flex;align-items:center;gap:11px;font-family:var(--display);font-weight:700;font-size:21px;color:#fff}
    .auth-logo b{color:var(--sky)}
    .auth-brand h2{color:#fff;font-size:clamp(28px,3vw,38px);margin-bottom:16px}
    .auth-brand h2 em{font-style:italic;color:var(--sky)}
    .auth-brand p.tag{color:#b6c5e3;font-size:16px;max-width:420px}
    .auth-points{display:grid;gap:16px;margin-top:30px}
    .auth-pt{display:flex;gap:13px;align-items:flex-start}
    .auth-pt .ic{width:38px;height:38px;border-radius:11px;flex-shrink:0;display:grid;place-items:center;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);color:var(--sky)}
    .auth-pt .ic svg{width:19px;height:19px}
    .auth-pt strong{display:block;font-family:var(--display);color:#fff;font-size:15px}
    .auth-pt span{font-size:13.5px;color:#9fb1d4}
    .auth-quote{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:20px;font-size:14.5px;color:#cdd9f0}
    .auth-quote b{color:#fff;font-family:var(--display)}
    /* form side */
    .auth-form-side{display:flex;align-items:center;justify-content:center;padding:48px 28px;background:#fff}
    .auth-card{width:100%;max-width:420px}
    .auth-card .top a.back{font-size:13px;color:var(--muted);font-weight:600}
    .auth-card h1{font-size:28px;margin:18px 0 8px}
    .auth-card .sub{font-size:14.5px;color:var(--body);margin-bottom:26px}
    .field{margin-bottom:16px}
    .field label{display:block;font-family:var(--display);font-size:13px;font-weight:600;color:var(--ink-2);margin-bottom:7px}
    .field input{width:100%;padding:13px 15px;border-radius:12px;border:1px solid var(--line-2);font-family:var(--sans);font-size:14.5px;color:var(--ink);background:#fff;transition:var(--t)}
    .field input:focus{outline:2px solid var(--brand-l);border-color:var(--brand)}
    .field .hint{font-size:12px;color:var(--muted);margin-top:6px}
    .row-between{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:20px;font-size:13px}
    .check{display:flex;align-items:center;gap:8px;color:var(--body)}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;width:100%;font-family:var(--display);font-weight:600;font-size:15px;padding:14px 22px;border-radius:12px;border:none;cursor:pointer;transition:var(--t)}
    .btn-primary{background:var(--brand);color:#fff;box-shadow:0 10px 24px rgba(37,99,235,.28)}
    .btn-primary:hover{background:var(--brand-d);transform:translateY(-2px)}
    .btn-google{background:#fff;color:var(--ink);border:1px solid var(--line-2);box-shadow:var(--shadow-sm)}
    .btn-google:hover{border-color:var(--brand-l);transform:translateY(-2px)}
    .btn-google svg{width:19px;height:19px}
    .divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:var(--muted);font-size:12.5px}
    .divider::before,.divider::after{content:"";flex:1;height:1px;background:var(--line)}
    .alt{text-align:center;font-size:14px;color:var(--body);margin-top:24px}
    .alt a{color:var(--brand-d);font-weight:700}
    .alert{padding:12px 15px;border-radius:12px;font-size:13.5px;margin-bottom:18px}
    .alert-error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#b91c1c}
    .alert-ok{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#15803d}
    /* OTP */
    .otp-row{display:flex;gap:10px;justify-content:space-between;margin-bottom:22px}
    .otp-row input{width:100%;aspect-ratio:1;text-align:center;font-family:var(--display);font-size:26px;font-weight:700;color:var(--ink);border:1.5px solid var(--line-2);border-radius:14px;background:var(--soft)}
    .otp-row input:focus{outline:none;border-color:var(--brand);background:#fff;box-shadow:0 0 0 4px var(--brand-tint)}
    @media(max-width:900px){.auth-shell{grid-template-columns:1fr}.auth-brand{display:none}}
  </style>
</head>
<body>
  <div class="auth-shell">
    <aside class="auth-brand">
      <a href="{{ route('home') }}" class="auth-logo">
        @if($logo)<img src="{{ asset('storage/'.$logo) }}" alt="{{ $brand }}" style="height:34px">@else {{ $brand }}<b>{{ $suffix }}</b>@endif
      </a>
      <div>
        <h2>Bangun <em>website impian</em> bisnismu bersama ConWeb.</h2>
        <p class="tag">Masuk untuk memesan, lalu pantau langsung progres pengerjaan website-mu secara real-time.</p>
        <div class="auth-points">
          <div class="auth-pt"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div><div><strong>Pantau progres real-time</strong><span>Lihat sampai mana pengerjaan webmu, kapan saja.</span></div></div>
          <div class="auth-pt"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><div><strong>Aman & terverifikasi</strong><span>Akun dilindungi verifikasi email.</span></div></div>
          <div class="auth-pt"><div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div><div><strong>Dukungan tim</strong><span>Terhubung langsung lewat WhatsApp.</span></div></div>
        </div>
      </div>
      <div class="auth-quote">&ldquo;Prosesnya transparan, aku bisa lihat web-ku dikerjakan tahap demi tahap.&rdquo; <b>— Klien ConWeb</b></div>
    </aside>

    <main class="auth-form-side">
      <div class="auth-card">
        @yield('form')
      </div>
    </main>
  </div>
  @stack('scripts')
</body>
</html>
