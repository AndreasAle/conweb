@extends('layouts.app')

@section('title', 'Status Pembayaran '.$purchase->order_code.' — '.$brand.' '.$suffix)

@section('content')
<style>
  .st-wrap{max-width:620px;margin-inline:auto;text-align:center}
  .st-ic{width:84px;height:84px;border-radius:50%;display:grid;place-items:center;margin:0 auto 22px}
  .st-ic svg{width:40px;height:40px}
  .st-ic.ok{background:rgba(34,197,94,.12);color:#15803d}
  .st-ic.wait{background:rgba(245,158,11,.13);color:#b45309}
  .st-ic.bad{background:rgba(239,68,68,.1);color:#b91c1c}
  .st-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius,18px);padding:20px;margin:26px 0;text-align:left}
  .st-row{display:flex;justify-content:space-between;gap:14px;padding:9px 0;font-size:14px;border-bottom:1px solid var(--line)}
  .st-row:last-child{border-bottom:none}
  .st-row span{color:var(--muted)}
  .st-row strong{color:var(--ink);font-family:var(--display)}
  .st-cta{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
</style>

<section class="page-hero">
  <div class="wrap st-wrap">
    @php
      $paid = $purchase->isPaid();
      $bad = in_array($purchase->payment_status, ['failed','expired']);
    @endphp

    <div class="st-ic {{ $paid ? 'ok' : ($bad ? 'bad' : 'wait') }}">
      @if($paid)
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
      @elseif($bad)
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
      @else
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 7v5l3 2"/></svg>
      @endif
    </div>

    <h1 style="font-size:28px;margin-bottom:8px">
      @if($paid && $purchase->store_id) Toko Anda sudah aktif!
      @elseif($paid) Pembayaran berhasil 🎉
      @elseif($bad) Pembayaran {{ $purchase->statusLabel() }}
      @else Menunggu Pembayaran
      @endif
    </h1>
    <p class="lead" style="color:var(--body)">
      @if($paid && $purchase->store_id) Toko online Anda sudah aktif dan siap dikelola.
      @elseif($paid) Tinggal satu langkah lagi — lengkapi data toko untuk mengaktifkan toko online Anda.
      @elseif($bad) Pembayaran tidak berhasil diselesaikan. Anda bisa mencoba membeli paket kembali.
      @else Selesaikan pembayaran Anda. Status akan otomatis terupdate setelah pembayaran kami terima.
      @endif
    </p>

    <div class="st-card">
      <div class="st-row"><span>Kode</span><strong>{{ $purchase->order_code }}</strong></div>
      <div class="st-row"><span>Paket</span><strong>{{ $purchase->package_name }}</strong></div>
      <div class="st-row"><span>Total</span><strong>{{ $purchase->formatted_amount }}</strong></div>
      <div class="st-row"><span>Status</span><strong style="color:{{ $paid ? '#15803d' : ($bad ? '#b91c1c' : '#b45309') }}">{{ $purchase->statusLabel() }}</strong></div>
    </div>

    <div class="st-cta">
      @if($paid && $purchase->store_id)
        <a href="{{ route('store-dashboard.index') }}" class="btn btn-primary">Kelola Toko</a>
        <a href="{{ route('store.home', $purchase->store->slug) }}" target="_blank" rel="noopener" class="btn btn-line">Lihat Toko</a>
      @elseif($paid)
        <a href="{{ route('store-onboarding.setup', $purchase->order_code) }}" class="btn btn-primary">Lengkapi Data Toko</a>
      @elseif($bad)
        <a href="{{ route('store-onboarding.packages') }}" class="btn btn-primary">Pilih Paket Lagi</a>
      @else
        @if($purchase->doku_payment_url)<a href="{{ $purchase->doku_payment_url }}" class="btn btn-primary">Lanjutkan Pembayaran</a>@endif
        <a href="{{ route('account.index') }}" class="btn btn-line">Ke Akun Saya</a>
      @endif
    </div>
  </div>
</section>
@endsection
