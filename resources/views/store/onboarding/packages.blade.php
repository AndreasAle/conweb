@extends('layouts.app')

@section('title', 'Pilih Paket Toko Online — '.$brand.' '.$suffix)
@section('description', 'Pilih paket Conweb Store untuk membuka toko online mandiri UMKM. Bayar sekali, kelola produk & pesanan sendiri, 0% biaya admin dari Conweb.')

@section('content')
<style>
  .pk-wrap{max-width:1080px;margin-inline:auto}
  .pk-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;align-items:stretch}
  .pk{display:flex;flex-direction:column;background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg,22px);padding:30px 26px;position:relative;transition:.25s}
  .pk:hover{transform:translateY(-4px);box-shadow:var(--shadow)}
  .pk.feat{border-color:var(--brand);box-shadow:0 18px 50px rgba(37,99,235,.14)}
  .pk-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--brand);color:#fff;font-family:var(--display);font-size:11.5px;font-weight:700;letter-spacing:.05em;padding:6px 16px;border-radius:99px}
  .pk h3{font-size:21px;margin-bottom:5px}
  .pk .pk-tag{font-size:13.5px;color:var(--muted);margin-bottom:18px;min-height:38px}
  .pk .pk-price{font-family:var(--display);font-size:32px;font-weight:700;color:var(--ink);letter-spacing:-.02em}
  .pk .pk-price span{font-size:14px;color:var(--muted);font-weight:500}
  .pk-feats{list-style:none;margin:20px 0 24px;padding:0;display:flex;flex-direction:column;gap:11px}
  .pk-feats li{display:flex;gap:10px;font-size:14px;color:var(--ink-2);line-height:1.45}
  .pk-feats svg{width:18px;height:18px;color:var(--ok);flex-shrink:0;margin-top:2px}
  .pk .btn{margin-top:auto}
  .pk-note{text-align:center;font-size:13px;color:var(--muted);max-width:680px;margin:30px auto 0}
  @media(max-width:880px){.pk-grid{grid-template-columns:1fr;max-width:440px;margin-inline:auto}}
</style>

<section class="page-hero">
  <div class="wrap" style="text-align:center">
    <div class="eyebrow">E-commerce by Conweb</div>
    <h1 style="font-size:clamp(30px,5vw,44px);max-width:760px;margin:0 auto 14px">Punya toko online sendiri, <em style="color:var(--brand-d);font-style:italic">mulai hari ini</em>.</h1>
    <p class="lead" style="max-width:600px;margin:0 auto;color:var(--body)">Pilih paket, bayar, lalu isi data tokomu. Kelola produk & pesanan sendiri dengan <strong>0% biaya admin dari Conweb</strong>.</p>
  </div>
</section>

<section class="section" style="padding-top:14px">
  <div class="wrap pk-wrap">
    @if($packages->isEmpty())
      <div style="text-align:center;color:var(--muted);padding:40px">Belum ada paket tersedia. Silakan hubungi kami.</div>
    @else
    <div class="pk-grid">
      @foreach($packages as $package)
        <div class="pk {{ $package->is_featured ? 'feat' : '' }}">
          @if($package->is_featured)<span class="pk-badge">Paling Populer</span>@endif
          <h3>{{ $package->name }}</h3>
          <div class="pk-tag">{{ $package->tagline }}</div>
          <div class="pk-price">{{ $package->formatted_price }}<span>{{ $package->price_period }}</span></div>
          @if(is_array($package->features) && count($package->features))
          <ul class="pk-feats">
            @foreach($package->features as $feat)
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>{{ is_array($feat) ? ($feat['text'] ?? '') : $feat }}</li>
            @endforeach
          </ul>
          @endif
          <a href="{{ route('store-onboarding.checkout', $package->slug) }}" class="btn {{ $package->is_featured ? 'btn-primary' : 'btn-line' }} btn-block">Pilih Paket</a>
        </div>
      @endforeach
    </div>
    @endif
    <p class="pk-note">Biaya pihak ketiga seperti payment gateway, ekspedisi, atau layanan tambahan mengikuti ketentuan masing-masing provider jika digunakan.</p>
  </div>
</section>
@endsection
