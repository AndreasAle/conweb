@extends('layouts.app')

@section('title', 'Akun Saya — '.$brand.' '.$suffix)

@push('styles')
<style>
  .acc-head{display:flex;align-items:center;gap:18px;flex-wrap:wrap;justify-content:space-between;margin-bottom:36px}
  .acc-user{display:flex;align-items:center;gap:16px}
  .acc-av{width:60px;height:60px;border-radius:50%;display:grid;place-items:center;font-family:var(--display);font-weight:700;color:#fff;font-size:24px;background:linear-gradient(135deg,var(--brand-l),var(--brand-d))}
  .acc-av img{width:100%;height:100%;object-fit:cover;border-radius:50%}
  .order-row{display:grid;grid-template-columns:1fr auto;gap:18px;align-items:center;background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:24px 26px;box-shadow:var(--shadow-sm);transition:var(--t);margin-bottom:16px}
  .order-row:hover{transform:translateY(-3px);box-shadow:var(--shadow);border-color:var(--brand-tint-2)}
  .order-row .code{font-family:var(--display);font-size:12px;color:var(--muted);letter-spacing:.04em}
  .order-row h3{font-size:18px;margin:4px 0 10px}
  .obar{height:8px;border-radius:99px;background:var(--soft-2);overflow:hidden;max-width:360px}
  .obar i{display:block;height:100%;border-radius:99px;background:linear-gradient(90deg,var(--brand),var(--sky))}
  .ostatus{display:inline-flex;align-items:center;gap:7px;font-family:var(--display);font-size:12.5px;font-weight:600;padding:6px 12px;border-radius:99px;background:var(--brand-tint);color:var(--brand-d);border:1px solid var(--brand-tint-2);margin-top:10px}
  .ostatus.done{background:rgba(34,197,94,.12);color:#15803d;border-color:rgba(34,197,94,.25)}
  .acc-empty{text-align:center;background:#fff;border:1px dashed var(--line-2);border-radius:var(--radius-lg);padding:60px 30px}
  @media(max-width:640px){.order-row{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="acc-head">
        <div class="acc-user">
          <div class="acc-av">@if(auth()->user()->avatar)<img src="{{ auth()->user()->avatar }}" alt="">@else{{ strtoupper(mb_substr(auth()->user()->name,0,1)) }}@endif</div>
          <div>
            <h1 style="font-size:26px;margin-bottom:2px">Halo, {{ auth()->user()->name }} 👋</h1>
            <p style="font-size:14px;color:var(--muted)">{{ auth()->user()->email }}</p>
          </div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <a href="{{ route('order-wizard.start') }}" class="btn btn-primary btn-sm">+ Pesan Website</a>
          <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-line btn-sm">Keluar</button></form>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap" style="max-width:880px;margin-inline:auto">
      @if(session('status'))
      <div class="alert" style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#15803d;margin-bottom:22px">{{ session('status') }}</div>
      @endif

      <div class="sec-head reveal" style="margin-bottom:24px"><h2 style="font-size:22px">Pesanan Saya</h2></div>

      @forelse($orders as $order)
      <a href="{{ route('account.order', $order->order_code) }}" class="order-row reveal">
        <div>
          <span class="code">{{ $order->order_code }}</span>
          <h3>{{ $order->domain_name }}{{ $order->domain_tld }}</h3>
          <div class="obar"><i style="width:{{ $order->progressPercent() }}%"></i></div>
          <span class="ostatus {{ $order->isDone() ? 'done' : '' }}">
            <span class="dot" style="background:currentColor;box-shadow:none;width:6px;height:6px"></span>
            {{ $order->stageLabel() }} · {{ $order->progressPercent() }}%
          </span>
        </div>
        <div style="text-align:right">
          <div style="font-family:var(--display);font-weight:700;color:var(--ink);font-size:18px">Rp{{ number_format($order->total_amount,0,',','.') }}</div>
          <span style="font-size:13px;color:var(--brand-d);font-weight:600">Lihat progres →</span>
        </div>
      </a>
      @empty
      <div class="acc-empty reveal">
        <h3 style="font-size:20px;margin-bottom:10px">Belum ada pesanan</h3>
        <p style="margin-bottom:22px">Mulai pesan website pertamamu dan pantau progresnya di sini.</p>
        <a href="{{ route('order-wizard.start') }}" class="btn btn-primary">Pesan Sekarang</a>
      </div>
      @endforelse
    </div>
  </section>
@endsection
