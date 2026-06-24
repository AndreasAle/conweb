@extends('layouts.app')

@push('styles')
<style>
  .ow-section{padding:calc(var(--nav-h) + 40px) 0 80px;background:var(--soft);min-height:100vh}
  .ow-wrap{display:grid;grid-template-columns:340px 1fr;gap:28px;align-items:start}
  .ow-side{display:grid;gap:20px;position:sticky;top:calc(var(--nav-h) + 24px)}
  .ow-card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:22px;box-shadow:var(--shadow-sm)}
  .ow-summary-tag{display:inline-flex;align-items:center;gap:7px;font-family:var(--display);font-size:11.5px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--brand-d);background:var(--brand-tint);border:1px solid var(--brand-tint-2);padding:6px 12px;border-radius:99px;margin-bottom:16px}
  .ow-summary-row{display:flex;justify-content:space-between;gap:10px;padding:10px 0;border-bottom:1px solid var(--line);font-size:13.5px}
  .ow-summary-row:last-of-type{border-bottom:none}
  .ow-summary-row strong{display:block;color:var(--ink);font-size:14px}
  .ow-summary-row span.muted{color:var(--muted);font-size:12px}
  .ow-summary-row .amt{font-family:var(--display);font-weight:700;color:var(--ink);white-space:nowrap}
  .ow-summary-total{display:flex;justify-content:space-between;align-items:center;padding-top:14px;margin-top:6px;border-top:1px solid var(--line-2)}
  .ow-summary-total b{font-family:var(--display);font-size:12px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted)}
  .ow-summary-total .val{font-family:var(--display);font-weight:700;font-size:19px;color:var(--brand-d)}
  .ow-empty{font-size:13px;color:var(--muted)}
  .ow-steps{display:grid;gap:16px}
  .ow-step{display:flex;gap:12px;align-items:flex-start}
  .ow-step .num{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;font-family:var(--display);font-weight:700;font-size:13px;flex-shrink:0;border:2px solid var(--line-2);color:var(--muted);background:#fff}
  .ow-step.active .num{background:var(--brand);color:#fff;border-color:var(--brand)}
  .ow-step.done .num{background:var(--ok);color:#fff;border-color:var(--ok)}
  .ow-step h4{font-size:14px;margin-bottom:2px;color:var(--ink)}
  .ow-step span{font-size:12px;color:var(--muted)}
  .ow-main{background:#fff;border:1px solid var(--line);border-radius:20px;padding:40px;box-shadow:var(--shadow-sm)}
  .ow-main-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:28px;flex-wrap:wrap}
  .ow-eyebrow{font-family:var(--display);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--brand-d);margin-bottom:10px}
  .ow-main h1{font-size:clamp(24px,3vw,32px);margin-bottom:10px}
  .ow-main p.lead{font-size:15px;max-width:560px}
  .ow-nav{display:flex;gap:10px;flex-shrink:0}
  .ow-search{display:flex;gap:10px;background:var(--soft-2);border:1px solid var(--line);border-radius:16px;padding:8px;margin-bottom:22px}
  .ow-search input{flex:1;border:none;background:transparent;padding:10px 14px;font-size:15px;color:var(--ink)}
  .ow-search input:focus{outline:none}
  .ow-results{display:grid;gap:10px}
  .ow-result{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:16px 18px;border:1px solid var(--line);border-radius:14px;background:#fff}
  .ow-result.unavailable{opacity:.55}
  .ow-result .name{font-family:var(--display);font-weight:600;color:var(--ink)}
  .ow-result .price{display:flex;align-items:center;gap:10px}
  .ow-result .price .old{font-size:12.5px;color:var(--muted);text-decoration:line-through}
  .ow-result .price .now{font-family:var(--display);font-weight:700;color:var(--brand-d)}
  .ow-badge-unavail{font-family:var(--display);font-size:11px;font-weight:700;color:#b91c1c;background:rgba(239,68,68,.1);padding:5px 10px;border-radius:99px}
  @media (max-width:920px){.ow-wrap{grid-template-columns:1fr}.ow-side{position:static}.ow-main{padding:26px}}
</style>
@endpush

@section('content')
<section class="ow-section">
  <div class="wrap ow-wrap">
    <aside class="ow-side">
      @include('order-wizard.partials.summary')
      <div class="ow-card">
        <div class="ow-steps">
          @php
            $stepList = [
              'domain' => ['no' => 1, 'title' => 'Domain', 'desc' => 'Cari nama domain yang pas untuk bisnismu.'],
              'template' => ['no' => 2, 'title' => 'Template', 'desc' => 'Pilih desain yang mewakili brand.'],
              'profile' => ['no' => 3, 'title' => 'Data Diri', 'desc' => 'Untuk aktivasi domain.'],
              'checkout' => ['no' => 4, 'title' => 'Paket & Bayar', 'desc' => 'Pilih durasi dan selesaikan pembayaran.'],
            ];
            $order = array_keys($stepList);
            $currentIndex = array_search($currentStep ?? 'domain', $order);
          @endphp
          @foreach($stepList as $key => $st)
            @php $idx = array_search($key, $order); @endphp
            <div class="ow-step {{ $idx === $currentIndex ? 'active' : ($idx < $currentIndex ? 'done' : '') }}">
              <span class="num">{{ $idx < $currentIndex ? '✓' : $st['no'] }}</span>
              <div><h4>{{ $st['title'] }}</h4><span>{{ $st['desc'] }}</span></div>
            </div>
          @endforeach
        </div>
      </div>
    </aside>
    <div class="ow-main">
      @yield('step')
    </div>
  </div>
</section>
@endsection
