@extends('order-wizard.layout')

@section('title', 'Pilih Domain — '.$brand.' '.$suffix)

@section('step')
  <div class="ow-main-head">
    <div>
      <div class="ow-eyebrow">01 · Pilih Domain</div>
      <h1>Cari nama domain <em style="color:var(--brand-d);font-style:italic">yang pas</em>.</h1>
      <p class="lead">Domain adalah identitas bisnismu di internet. Ketik nama yang kamu mau, kami cek ketersediaan di semua TLD (simulasi — registrar asli akan dipasang kemudian).</p>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-error">{{ $errors->first() }}</div>
  @endif

  <div class="ow-search">
    <input type="text" id="ow-domain-input" placeholder="ketik nama domain kamu..." value="{{ \App\Support\OrderWizard::get('domain_name') }}">
    <button type="button" class="btn btn-primary btn-sm" id="ow-domain-search">
      Cari Domain
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </button>
  </div>

  <div class="ow-results" id="ow-domain-results">
    <p class="ow-empty">Hasil pencarian akan muncul di sini.</p>
  </div>

  <form method="POST" action="{{ route('order-wizard.domain.store') }}" id="ow-domain-form">
    @csrf
    <input type="hidden" name="name" id="ow-domain-name">
    <input type="hidden" name="tld" id="ow-domain-tld">
  </form>

  <script>
    const input = document.getElementById('ow-domain-input');
    const btn = document.getElementById('ow-domain-search');
    const results = document.getElementById('ow-domain-results');
    const form = document.getElementById('ow-domain-form');
    const nameField = document.getElementById('ow-domain-name');
    const tldField = document.getElementById('ow-domain-tld');

    function fmt(n){ return 'Rp' + Number(n).toLocaleString('id-ID'); }

    function render(data){
      if(!data.results || !data.results.length){ results.innerHTML = '<p class="ow-empty">Tidak ada hasil.</p>'; return; }
      results.innerHTML = data.results.map(r => `
        <div class="ow-result ${r.available ? '' : 'unavailable'}">
          <span class="name">${data.name}${r.tld}</span>
          <div class="price">
            ${r.available ? `
              ${r.original_price ? `<span class="old">${fmt(r.original_price)}</span>` : ''}
              <span class="now">${Number(r.price) > 0 ? fmt(r.price) : 'Termasuk paket'}</span>
              <button type="button" class="btn btn-primary btn-sm" data-tld="${r.tld}">Pilih</button>
            ` : `<span class="ow-badge-unavail">Tidak Tersedia</span>`}
          </div>
        </div>
      `).join('');

      results.querySelectorAll('button[data-tld]').forEach(b => {
        b.addEventListener('click', () => {
          nameField.value = data.name;
          tldField.value = b.getAttribute('data-tld');
          form.submit();
        });
      });
    }

    function search(){
      const name = input.value.trim();
      if(name.length < 3){ results.innerHTML = '<p class="ow-empty">Minimal 3 karakter.</p>'; return; }
      results.innerHTML = '<p class="ow-empty">Mencari...</p>';
      fetch(`{{ route('order-wizard.domain.check') }}?name=${encodeURIComponent(name)}`)
        .then(r => r.json())
        .then(render)
        .catch(() => { results.innerHTML = '<p class="ow-empty">Terjadi kesalahan, coba lagi.</p>'; });
    }

    btn.addEventListener('click', search);
    input.addEventListener('keydown', e => { if(e.key === 'Enter'){ e.preventDefault(); search(); } });
    @if(\App\Support\OrderWizard::get('domain_name'))
    search();
    @endif
  </script>
@endsection
