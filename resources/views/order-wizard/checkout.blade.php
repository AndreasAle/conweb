@extends('order-wizard.layout')

@section('title', 'Paket & Bayar — '.$brand.' '.$suffix)

@section('step')
  <style>
    .pay-group{font-family:var(--display);font-size:11.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin:16px 0 8px}
    .pay-group:first-of-type{margin-top:0}
    .pay-methods{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .pay-method{display:flex;align-items:center;gap:10px;padding:12px 14px;border:1px solid var(--line-2);border-radius:12px;cursor:pointer;font-size:14px;transition:.18s;background:#fff}
    .pay-method:hover{border-color:var(--brand)}
    .pay-method input{accent-color:var(--brand);width:16px;height:16px;flex-shrink:0}
    .pay-method.sel{border-color:var(--brand);background:var(--brand-tint,rgba(37,99,235,.07));box-shadow:0 0 0 3px rgba(37,99,235,.1)}
    @media(max-width:560px){.pay-methods{grid-template-columns:1fr}}
  </style>
  <div class="ow-main-head">
    <div>
      <div class="ow-eyebrow">04 · Paket & Pembayaran</div>
      <h1>Pilih durasi <em style="color:var(--brand-d);font-style:italic">yang paling hemat</em> untuk bisnismu.</h1>
      <p class="lead">Paket ConWeb Launch sudah mencakup domain, hosting, SSL, dan pembuatan website. Tambahkan tahun perawatan (Care) agar lebih hemat, atau pilih add-on sesuai kebutuhan.</p>
    </div>
    <div class="ow-nav">
      <a href="{{ route('order-wizard.profile') }}" class="btn btn-line btn-sm">← Sebelumnya</a>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-error">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('order-wizard.checkout.store') }}" id="ow-checkout-form">
    @csrf
    <div class="grid-3" style="margin-bottom:28px">
      @foreach($durations as $years => $opt)
      @php $t = \App\Support\OrderWizard::totals($years); @endphp
      <label class="price-card" style="cursor:pointer;display:block;{{ $selectedDuration === $years ? 'outline:2px solid var(--brand)' : '' }}">
        @if($opt['badge'])<span class="badge">{{ $opt['badge'] }}</span>@endif
        <input type="radio" name="duration" value="{{ $years }}" {{ $selectedDuration === $years ? 'checked' : '' }} class="ow-duration-radio" style="margin-bottom:10px">
        <h3>{{ $opt['label'] }}</h3>
        @if(!empty($opt['note']))<span class="muted" style="font-size:12.5px;display:block;margin-bottom:6px">{{ $opt['note'] }}</span>@endif
        <div class="price-now" data-total>Rp{{ number_format($t['total'], 0, ',', '.') }}</div>
        @if($opt['discount_pct'] > 0)<span class="price-old" style="text-decoration:none;color:var(--ok)">Hemat {{ $opt['discount_pct'] }}% perawatan</span>@endif
      </label>
      @endforeach
    </div>

    <div class="ow-card" style="margin-bottom:22px">
      <h4 style="font-size:14.5px;margin-bottom:14px">Add-on Opsional</h4>
      @foreach($addons as $key => $addon)
      <label style="display:flex;align-items:center;justify-content:space-between;gap:14px;padding:10px 0;cursor:pointer">
        <span style="display:flex;align-items:center;gap:10px;font-size:14px">
          <input type="checkbox" name="addons[]" value="{{ $key }}" class="ow-addon-checkbox" {{ in_array($key, $selectedAddons) ? 'checked' : '' }}>
          {{ $addon['label'] }}
        </span>
        <strong>+Rp{{ number_format($addon['price'], 0, ',', '.') }}</strong>
      </label>
      @endforeach
    </div>

    <div class="ow-card" style="margin-bottom:22px">
      <h4 style="font-size:14.5px;margin-bottom:14px">Kode Promo</h4>
      <div style="display:flex;gap:10px">
        <input type="text" id="ow-promo-input" placeholder="Kode Promo..." value="{{ $totals['promo_code'] }}" style="flex:1;padding:11px 14px;border-radius:12px;border:1px solid var(--line-2)">
        <button type="button" class="btn btn-line btn-sm" id="ow-promo-apply">Gunakan</button>
      </div>
      <p id="ow-promo-message" style="font-size:13px;margin-top:8px"></p>
    </div>

    <div class="ow-card" style="margin-bottom:22px">
      <h4 style="font-size:14.5px;margin-bottom:14px">Metode Pembayaran <span style="color:var(--danger,#ef4444)">*</span></h4>
      @foreach($channelGroups as $group => $methods)
        <div class="pay-group">{{ $group }}</div>
        <div class="pay-methods">
          @foreach($methods as $code => $label)
            <label class="pay-method">
              <input type="radio" name="payment_channel" value="{{ $code }}" class="ow-pay-radio" {{ old('payment_channel') === $code ? 'checked' : '' }}>
              <span>{{ $label }}</span>
            </label>
          @endforeach
        </div>
      @endforeach
    </div>

    <div class="ow-card" id="ow-email-card" style="margin-bottom:22px;display:none">
      <h4 style="font-size:14.5px;margin-bottom:6px">Email untuk Invoice & Notifikasi <span style="color:var(--danger,#ef4444)">*</span></h4>
      <p class="muted" style="font-size:13px;margin-bottom:12px">Bukti pembayaran dan status pesanan dikirim ke email ini.</p>
      <input type="email" name="customer_email" id="ow-email-input" value="{{ old('customer_email', $customerEmail) }}" placeholder="email@bisnismu.com" style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid var(--line-2);font-size:14px">
    </div>

    <div class="ow-card" style="margin-bottom:22px">
      <div class="ow-summary-row"><span>Subtotal</span><strong id="ow-bd-subtotal">Rp{{ number_format($totals['subtotal'], 0, ',', '.') }}</strong></div>
      <div class="ow-summary-row"><span>Diskon</span><strong id="ow-bd-discount" style="color:var(--ok)">-Rp{{ number_format($totals['discount_amount'], 0, ',', '.') }}</strong></div>
      <div class="ow-summary-total"><b>Total Bayar</b><span class="val" id="ow-bd-total">Rp{{ number_format($totals['total'], 0, ',', '.') }}</span></div>
    </div>

    <button type="submit" class="btn btn-primary btn-block" id="ow-pay-submit">
      Lanjut ke Pembayaran
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </button>
    <p class="muted center" style="font-size:12.5px;margin-top:12px">Pembayaran diproses aman lewat DOKU. Biaya pihak ketiga (payment gateway, ekspedisi) mengikuti ketentuan provider masing-masing jika digunakan.</p>
  </form>

  <script>
    const form = document.getElementById('ow-checkout-form');
    const fmt = n => 'Rp' + Number(n).toLocaleString('id-ID');

    function applyTotals(t){
      document.getElementById('ow-bd-subtotal').textContent = fmt(t.subtotal);
      document.getElementById('ow-bd-discount').textContent = '-' + fmt(t.discount_amount);
      document.getElementById('ow-bd-total').textContent = fmt(t.total);
      const sidebarTotal = document.getElementById('ow-sidebar-total');
      if (sidebarTotal) sidebarTotal.textContent = fmt(t.total);
      document.querySelectorAll('[data-total]').forEach((el, i) => {
        const radios = document.querySelectorAll('.ow-duration-radio');
        if (radios[i] && parseInt(radios[i].value) === t.duration) el.textContent = fmt(t.total);
      });
    }

    function recalc(){
      const duration = form.querySelector('.ow-duration-radio:checked')?.value || 1;
      const addons = Array.from(form.querySelectorAll('.ow-addon-checkbox:checked')).map(c => c.value);
      const body = new URLSearchParams();
      body.append('duration', duration);
      addons.forEach(a => body.append('addons[]', a));
      body.append('_token', '{{ csrf_token() }}');
      fetch('{{ route('order-wizard.checkout.recalculate') }}', { method: 'POST', body })
        .then(r => r.json()).then(applyTotals);
    }

    form.querySelectorAll('.ow-duration-radio, .ow-addon-checkbox').forEach(el => el.addEventListener('change', recalc));

    document.getElementById('ow-promo-apply').addEventListener('click', () => {
      const code = document.getElementById('ow-promo-input').value.trim();
      const msg = document.getElementById('ow-promo-message');
      if (!code) return;
      const body = new URLSearchParams();
      body.append('code', code);
      body.append('_token', '{{ csrf_token() }}');
      fetch('{{ route('order-wizard.checkout.promo') }}', { method: 'POST', body })
        .then(async r => {
          const data = await r.json();
          if (!r.ok) { msg.textContent = data.error || 'Kode promo tidak valid.'; msg.style.color = '#b91c1c'; return; }
          msg.textContent = 'Kode promo berhasil digunakan!'; msg.style.color = 'var(--ok)';
          applyTotals(data);
        });
    });

    // Metode pembayaran: tampilkan & wajibkan email setelah metode dipilih.
    const emailCard = document.getElementById('ow-email-card');
    const emailInput = document.getElementById('ow-email-input');
    function onPaySelect(){
      form.querySelectorAll('.pay-method').forEach(m => m.classList.remove('sel'));
      const checked = form.querySelector('.ow-pay-radio:checked');
      if (checked){
        checked.closest('.pay-method').classList.add('sel');
        emailCard.style.display = '';
        emailInput.required = true;
      }
    }
    form.querySelectorAll('.ow-pay-radio').forEach(r => r.addEventListener('change', onPaySelect));
    onPaySelect();

    form.addEventListener('submit', (e) => {
      if (!form.querySelector('.ow-pay-radio:checked')){
        e.preventDefault();
        alert('Silakan pilih metode pembayaran terlebih dahulu.');
        return;
      }
      const btn = document.getElementById('ow-pay-submit');
      btn.disabled = true; btn.style.opacity = '.7'; btn.textContent = 'Memproses...';
    });
  </script>
@endsection
