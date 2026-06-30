@extends('layouts.app')

@section('title', 'Checkout '.$package->name.' — '.$brand.' '.$suffix)

@section('content')
<style>
  .co-wrap{max-width:760px;margin-inline:auto}
  .co-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius,18px);padding:24px;margin-bottom:20px;box-shadow:var(--shadow-sm)}
  .co-sum{display:flex;align-items:center;justify-content:space-between;gap:16px}
  .co-sum h3{font-size:19px;margin-bottom:3px}
  .co-sum .muted{font-size:13.5px;color:var(--muted)}
  .co-sum .price{font-family:var(--display);font-size:26px;font-weight:700;color:var(--brand-d)}
  .co-field{margin-bottom:16px}
  .co-field label{display:block;font-family:var(--display);font-size:13.5px;font-weight:600;color:var(--ink-2);margin-bottom:7px}
  .co-field input{width:100%;padding:12px 14px;border-radius:12px;border:1px solid var(--line-2);font-size:14px;font-family:var(--sans)}
  .co-field input:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px var(--brand-tint)}
  .pay-group{font-family:var(--display);font-size:11.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin:16px 0 8px}
  .pay-group:first-of-type{margin-top:0}
  .pay-methods{display:grid;grid-template-columns:1fr 1fr;gap:10px}
  .pay-method{display:flex;align-items:center;gap:10px;padding:12px 14px;border:1px solid var(--line-2);border-radius:12px;cursor:pointer;font-size:14px;transition:.18s}
  .pay-method:hover{border-color:var(--brand)}
  .pay-method input{accent-color:var(--brand);width:16px;height:16px;flex-shrink:0}
  .pay-method.sel{border-color:var(--brand);background:var(--brand-tint);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
  @media(max-width:560px){.pay-methods{grid-template-columns:1fr}}
</style>

<section class="page-hero" style="padding-bottom:20px">
  <div class="wrap co-wrap">
    <div class="breadcrumb" style="margin-bottom:14px"><a href="{{ route('store-onboarding.packages') }}">← Pilih paket lain</a></div>
    <h1 style="font-size:28px">Checkout Paket</h1>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="wrap co-wrap">
    @if(session('error'))<div class="alert alert-error" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#b91c1c;padding:13px 16px;border-radius:12px;margin-bottom:18px">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-error" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#b91c1c;padding:13px 16px;border-radius:12px;margin-bottom:18px">{{ $errors->first() }}</div>@endif

    <div class="co-card co-sum">
      <div>
        <h3>{{ $package->name }}</h3>
        <span class="muted">{{ $package->tagline }}</span>
      </div>
      <div class="price">{{ $package->formatted_price }}<span style="font-size:13px;color:var(--muted);font-weight:500">{{ $package->price_period }}</span></div>
    </div>

    <form method="POST" action="{{ route('store-onboarding.purchase', $package->slug) }}" id="co-form">
      @csrf
      <div class="co-card">
        <h3 style="font-size:16px;margin-bottom:16px">Data Pemesan</h3>
        <div class="co-field">
          <label>Nama Lengkap <span style="color:var(--danger,#ef4444)">*</span></label>
          <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" required>
        </div>
        <div class="co-field">
          <label>Nomor WhatsApp <span style="color:var(--danger,#ef4444)">*</span></label>
          <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone ?? '') }}" placeholder="08xxxxxxxxxx" required>
        </div>
        <div class="co-field" style="margin-bottom:0">
          <label>Email <span style="color:var(--danger,#ef4444)">*</span></label>
          <input type="email" name="customer_email" value="{{ old('customer_email', $user->email) }}" placeholder="email@bisnismu.com" required>
        </div>
      </div>

      <div class="co-card">
        <h3 style="font-size:16px;margin-bottom:6px">Metode Pembayaran <span style="color:var(--danger,#ef4444)">*</span></h3>
        @foreach($channelGroups as $group => $methods)
          <div class="pay-group">{{ $group }}</div>
          <div class="pay-methods">
            @foreach($methods as $code => $label)
              <label class="pay-method">
                <input type="radio" name="payment_channel" value="{{ $code }}" class="co-pay-radio" {{ old('payment_channel') === $code ? 'checked' : '' }}>
                <span>{{ $label }}</span>
              </label>
            @endforeach
          </div>
        @endforeach
      </div>

      <button type="submit" class="btn btn-primary btn-block" id="co-submit">
        Lanjut ke Pembayaran
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
      <p class="muted" style="text-align:center;font-size:12.5px;margin-top:12px">Pembayaran diproses aman lewat DOKU. Biaya pihak ketiga (payment gateway, ekspedisi) mengikuti ketentuan provider masing-masing jika digunakan.</p>
    </form>
  </div>
</section>

<script>
  (function(){
    const form = document.getElementById('co-form');
    function onSel(){
      form.querySelectorAll('.pay-method').forEach(m => m.classList.remove('sel'));
      const c = form.querySelector('.co-pay-radio:checked');
      if (c) c.closest('.pay-method').classList.add('sel');
    }
    form.querySelectorAll('.co-pay-radio').forEach(r => r.addEventListener('change', onSel));
    onSel();
    form.addEventListener('submit', function(e){
      if (!form.querySelector('.co-pay-radio:checked')){ e.preventDefault(); alert('Silakan pilih metode pembayaran terlebih dahulu.'); return; }
      const b = document.getElementById('co-submit'); b.disabled = true; b.style.opacity = '.7'; b.textContent = 'Memproses...';
    });
  })();
</script>
@endsection
