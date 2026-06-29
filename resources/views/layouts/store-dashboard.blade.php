<!DOCTYPE html>
<html lang="{{ site_locale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow">
  <title>@yield('title', 'Dashboard Toko') — Conweb Store</title>
  @if(! empty($s['site.favicon']))
  <link rel="icon" href="{{ asset('storage/'.$s['site.favicon']) }}" sizes="any">
  @endif
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root{
      --ink:#0a1633;--ink-2:#1c2a4a;--body:#4b5a78;--muted:#8190ab;--line:#e6ecf7;--line-2:#d9e2f2;
      --bg:#ffffff;--soft:#f5f8ff;--soft-2:#eef3fe;--brand:#2563eb;--brand-d:#1d4ed8;--brand-l:#3b82f6;
      --brand-tint:rgba(37,99,235,.08);--brand-tint-2:rgba(37,99,235,.14);--navy:#0a1530;--ok:#22c55e;--warn:#f59e0b;--danger:#ef4444;
      --shadow-sm:0 1px 2px rgba(13,30,70,.06),0 2px 8px rgba(13,30,70,.05);
      --shadow:0 12px 32px rgba(13,30,70,.08),0 2px 8px rgba(13,30,70,.04);
      --radius:16px;--radius-sm:11px;--sidebar:264px;
      --display:'Space Grotesk',sans-serif;--sans:'Plus Jakarta Sans',sans-serif;
    }
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:var(--sans);color:var(--body);background:var(--soft);line-height:1.6;-webkit-font-smoothing:antialiased}
    a{color:inherit;text-decoration:none}
    button{font:inherit;cursor:pointer;border:none;background:none;color:inherit}
    img,svg{display:block;max-width:100%}
    h1,h2,h3,h4{font-family:var(--display);color:var(--ink);font-weight:700;letter-spacing:-.02em;line-height:1.2}
    .layout{display:flex;min-height:100vh}
    /* Sidebar */
    .sidebar{width:var(--sidebar);background:var(--navy);color:#cdd8f0;position:fixed;inset:0 auto 0 0;display:flex;flex-direction:column;z-index:50;transition:transform .3s cubic-bezier(.22,1,.36,1)}
    .sb-brand{padding:22px 22px 18px;display:flex;align-items:center;gap:11px;border-bottom:1px solid rgba(255,255,255,.08)}
    .sb-brand .mk{width:38px;height:38px;border-radius:11px;background:linear-gradient(135deg,var(--brand-l),var(--brand-d));display:grid;place-items:center;color:#fff;font-family:var(--display);font-weight:700;flex-shrink:0}
    .sb-brand b{font-family:var(--display);color:#fff;font-size:15px;line-height:1.15;display:block}
    .sb-brand span{font-size:11.5px;color:#8da0c8}
    .sb-nav{flex:1;overflow-y:auto;padding:16px 12px}
    .sb-nav .grp{font-family:var(--display);font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:#6b7ea8;padding:14px 12px 8px}
    .sb-nav a{display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:11px;font-size:14px;font-weight:500;color:#bccbe8;transition:.2s;margin-bottom:2px}
    .sb-nav a svg{width:19px;height:19px;flex-shrink:0;opacity:.85}
    .sb-nav a:hover{background:rgba(255,255,255,.06);color:#fff}
    .sb-nav a.active{background:var(--brand);color:#fff;box-shadow:0 8px 18px rgba(37,99,235,.34)}
    .sb-foot{padding:14px 16px;border-top:1px solid rgba(255,255,255,.08)}
    .sb-foot a{display:flex;align-items:center;gap:10px;font-size:13.5px;color:#8da0c8}
    .sb-foot a:hover{color:#fff}
    /* Main */
    .main{flex:1;margin-left:var(--sidebar);display:flex;flex-direction:column;min-width:0}
    .topbar{position:sticky;top:0;z-index:40;background:rgba(255,255,255,.9);backdrop-filter:blur(12px);border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 26px}
    .topbar .tb-title{font-family:var(--display);font-weight:700;color:var(--ink);font-size:17px}
    .topbar .tb-right{display:flex;align-items:center;gap:10px}
    .burger{display:none;width:42px;height:42px;border-radius:11px;border:1px solid var(--line-2);background:#fff;place-items:center;color:var(--ink)}
    .burger svg{width:22px;height:22px}
    .content{padding:26px;max-width:1200px;width:100%}
    /* Reusable */
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;font-family:var(--display);font-weight:600;font-size:14px;padding:11px 18px;border-radius:11px;transition:.25s;white-space:nowrap}
    .btn svg{width:17px;height:17px}
    .btn-primary{background:var(--brand);color:#fff;box-shadow:0 8px 20px rgba(37,99,235,.26)}
    .btn-primary:hover{background:var(--brand-d);transform:translateY(-1px)}
    .btn-line{background:#fff;color:var(--ink);border:1px solid var(--line-2)}
    .btn-line:hover{border-color:var(--brand-l);color:var(--brand-d)}
    .btn-danger{background:rgba(239,68,68,.1);color:var(--danger);border:1px solid rgba(239,68,68,.2)}
    .btn-danger:hover{background:var(--danger);color:#fff}
    .btn-sm{padding:8px 13px;font-size:13px;border-radius:9px}
    .card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);box-shadow:var(--shadow-sm)}
    .card-pad{padding:22px}
    .page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:24px}
    .page-head h1{font-size:24px;margin-bottom:4px}
    .page-head p{font-size:14px;color:var(--muted)}
    .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
    .stat{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow-sm)}
    .stat .ic{width:42px;height:42px;border-radius:11px;display:grid;place-items:center;background:var(--brand-tint);color:var(--brand-d);margin-bottom:14px}
    .stat .ic svg{width:21px;height:21px}
    .stat b{font-family:var(--display);font-size:28px;color:var(--ink);display:block;line-height:1}
    .stat span{font-size:13px;color:var(--muted);margin-top:5px;display:block}
    /* Tables */
    .table-wrap{overflow-x:auto}
    table.tbl{width:100%;border-collapse:collapse;font-size:14px}
    table.tbl th{text-align:left;font-family:var(--display);font-size:12px;letter-spacing:.04em;text-transform:uppercase;color:var(--muted);padding:13px 16px;border-bottom:1px solid var(--line);white-space:nowrap}
    table.tbl td{padding:14px 16px;border-bottom:1px solid var(--line);color:var(--ink-2);vertical-align:middle}
    table.tbl tr:last-child td{border-bottom:none}
    table.tbl tr:hover td{background:var(--soft)}
    .badge{display:inline-flex;align-items:center;gap:6px;font-family:var(--display);font-size:11.5px;font-weight:600;padding:4px 10px;border-radius:99px}
    .badge-green{background:rgba(34,197,94,.12);color:#15803d}
    .badge-gray{background:var(--soft-2);color:var(--muted)}
    .badge-amber{background:rgba(245,158,11,.13);color:#b45309}
    .badge-blue{background:var(--brand-tint);color:var(--brand-d)}
    .badge-red{background:rgba(239,68,68,.1);color:#b91c1c}
    /* Forms */
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
    .form-row{margin-bottom:18px}
    .form-row.full{grid-column:1/-1}
    .form-row label{display:block;font-family:var(--display);font-size:13px;font-weight:600;color:var(--ink-2);margin-bottom:7px}
    .form-row .req{color:var(--danger)}
    .form-row input,.form-row select,.form-row textarea{width:100%;padding:12px 14px;border-radius:11px;border:1px solid var(--line-2);font-family:var(--sans);font-size:14px;color:var(--ink);background:#fff;transition:.2s}
    .form-row input:focus,.form-row select:focus,.form-row textarea:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px var(--brand-tint)}
    .form-row .hint{font-size:12.5px;color:var(--muted);margin-top:6px}
    .form-row .err{font-size:12.5px;color:var(--danger);margin-top:6px;font-weight:500}
    .form-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:6px}
    .switch{display:flex;align-items:center;gap:10px;cursor:pointer}
    .switch input{width:auto}
    /* Alerts */
    .alert{padding:13px 16px;border-radius:12px;font-size:14px;margin-bottom:20px;display:flex;align-items:center;gap:10px}
    .alert svg{width:19px;height:19px;flex-shrink:0}
    .alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#15803d}
    .alert-error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#b91c1c}
    .empty{text-align:center;padding:54px 20px;color:var(--muted)}
    .empty svg{width:48px;height:48px;margin:0 auto 14px;color:var(--line-2)}
    .empty h3{color:var(--ink-2);font-size:17px;margin-bottom:6px}
    .pagination{display:flex;gap:6px;flex-wrap:wrap;margin-top:20px;justify-content:center}
    .pagination span,.pagination a{font-family:var(--display);font-size:13px;font-weight:600;padding:8px 13px;border-radius:9px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2)}
    .pagination .active span{background:var(--brand);color:#fff;border-color:var(--brand)}
    .pagination [aria-disabled] span{opacity:.4}
    .scrim{display:none;position:fixed;inset:0;background:rgba(10,21,48,.5);z-index:45}
    @media(max-width:980px){.stat-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:860px){
      .sidebar{transform:translateX(-100%)}
      body.sb-open .sidebar{transform:translateX(0)}
      body.sb-open .scrim{display:block}
      .main{margin-left:0}
      .burger{display:grid}
      .form-grid{grid-template-columns:1fr}
    }
    @media(max-width:520px){.stat-grid{grid-template-columns:1fr}.content{padding:18px}}
  </style>
  @stack('styles')
</head>
<body>
<div class="layout">
  @php $sd = $currentStore; @endphp
  <aside class="sidebar">
    <div class="sb-brand">
      <div class="mk">{{ strtoupper(substr($sd->name,0,1)) }}</div>
      <div>
        <b>{{ Str::limit($sd->name, 18) }}</b>
        <span>Conweb Store</span>
      </div>
    </div>
    <nav class="sb-nav">
      <div class="grp">Toko</div>
      <a href="{{ route('store-dashboard.index') }}" class="{{ request()->routeIs('store-dashboard.index') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
        Overview
      </a>
      <a href="{{ route('store-dashboard.orders.index') }}" class="{{ request()->routeIs('store-dashboard.orders.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        Pesanan
      </a>
      <div class="grp">Katalog</div>
      <a href="{{ route('store-dashboard.products.index') }}" class="{{ request()->routeIs('store-dashboard.products.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
        Produk
      </a>
      <a href="{{ route('store-dashboard.categories.index') }}" class="{{ request()->routeIs('store-dashboard.categories.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7v6a2 2 0 0 0 2 2h6"/><rect x="3" y="3" width="7" height="7" rx="1"/><path d="m14 7 3-3 3 3"/><path d="M17 4v8a2 2 0 0 1-2 2h-1"/></svg>
        Kategori
      </a>
      <a href="{{ route('store-dashboard.vouchers.index') }}" class="{{ request()->routeIs('store-dashboard.vouchers.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
        Voucher
      </a>
      <div class="grp">Pengaturan</div>
      <a href="{{ route('store-dashboard.settings') }}" class="{{ request()->routeIs('store-dashboard.settings') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2Z"/><circle cx="12" cy="12" r="3"/></svg>
        Pengaturan Toko
      </a>
    </nav>
    <div class="sb-foot">
      <a href="{{ route('store.home', $sd->slug) }}" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:17px;height:17px"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
        Lihat toko publik
      </a>
    </div>
  </aside>

  <div class="scrim" id="scrim"></div>

  <div class="main">
    <header class="topbar">
      <div style="display:flex;align-items:center;gap:12px">
        <button class="burger" id="burger" aria-label="Menu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
        </button>
        <span class="tb-title">@yield('title', 'Dashboard')</span>
      </div>
      <div class="tb-right">
        <a href="{{ route('store.home', $sd->slug) }}" target="_blank" rel="noopener" class="btn btn-line btn-sm">Lihat Toko</a>
        <form method="POST" action="{{ route('logout') }}">@csrf
          <button type="submit" class="btn btn-line btn-sm">Keluar</button>
        </form>
      </div>
    </header>

    <main class="content">
      @if(session('success'))
        <div class="alert alert-success">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
          {{ session('error') }}
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

<script>
  const burger = document.getElementById('burger');
  const scrim = document.getElementById('scrim');
  const toggle = () => document.body.classList.toggle('sb-open');
  if (burger) burger.addEventListener('click', toggle);
  if (scrim) scrim.addEventListener('click', () => document.body.classList.remove('sb-open'));
</script>
@stack('scripts')
</body>
</html>
