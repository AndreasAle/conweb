@extends('layouts.app')

@php
$en = site_locale() === 'en';
$addons = [
  ['Tambah Halaman', 'Add Page', 200000, ''],
  ['Upload Tambahan Produk', 'Extra Product Upload', 15000, $en ? '/product' : '/produk'],
  ['Edit Konten Ringan', 'Light Content Edit', 150000, ''],
  ['Desain Banner', 'Banner Design', 150000, $en ? '/banner' : '/banner'],
  ['Setup Google Business Profile', 'Google Business Profile Setup', 300000, ''],
  ['SEO Basic Tambahan', 'Extra Basic SEO', 350000, ''],
  ['Maintenance Bulanan', 'Monthly Maintenance', 350000, $en ? '/month' : '/bulan'],
];
@endphp

@section('title', ($en ? 'Pricing' : 'Paket & Harga').' — '.$brand.' '.$suffix)

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('home') }}">{{ $en ? 'Home' : 'Beranda' }}</a><span>/</span><span>{{ $en ? 'Pricing' : 'Paket' }}</span></div>
      <span class="eyebrow">{{ $en ? 'Packages & Pricing' : 'Paket & Harga' }}</span>
      <h1>{{ $en ? 'Simple, transparent pricing' : 'Harga simpel dan transparan' }}</h1>
      <p>{{ $en ? 'One package covers everything to get online — domain, hosting, SSL, and a fully built website. No hidden fees.' : 'Satu paket mencakup semua untuk online — domain, hosting, SSL, dan website jadi. Tanpa biaya tersembunyi.' }}</p>
      <div class="hero-trust" style="margin-top:24px">
        @php
        $trust = $en ? ['No setup fee','Domain, hosting & SSL included','All-in-one package'] : ['Tanpa biaya setup','Domain, hosting & SSL termasuk','Paket lengkap sekaligus'];
        @endphp
        @foreach($trust as $tt)
        <span class="tag"><span class="dot"></span>{{ $tt }}</span>
        @endforeach
      </div>
    </div>
  </section>

  {{-- main packages --}}
  @if($packages->count())
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">{{ $en ? 'Main packages' : 'Paket utama' }}</span>
        <h2 class="heading">{{ $en ? 'Pick the package that fits' : 'Pilih paket yang sesuai' }}</h2>
        <p class="lead">{{ $en ? 'Launch a brand-new site, renew & maintain an existing one, or go fully custom.' : 'Buat website baru, perpanjang & rawat yang sudah ada, atau sepenuhnya custom.' }}</p>
      </div>
      <div class="grid-3">
        @foreach($packages as $plan)
        @php $custom = $plan->price <= 0 || $plan->period === 'custom'; @endphp
        <div class="price-card reveal" style="{{ $plan->badge === 'Paling Lengkap' ? 'outline:2px solid var(--brand)' : '' }}">
          @if($plan->badge)<span class="badge">{{ $plan->badge }}</span>@endif
          <h3>{{ $plan->name }}</h3>
          @if($plan->original_price)<div class="price-old">Rp{{ number_format($plan->original_price,0,',','.') }}</div>@endif
          @if($custom)
          <div class="price-now">{{ $en ? 'Custom' : 'Custom' }} <span>{{ $en ? 'on request' : 'sesuai kebutuhan' }}</span></div>
          @else
          <div class="price-now">Rp{{ number_format($plan->price,0,',','.') }} <span>{{ $plan->period }}</span></div>
          @endif
          <ul class="price-feat">
            @foreach(($plan->features ?? []) as $f)
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{{ $f }}</span></li>
            @endforeach
          </ul>
          @if($custom)
          <a href="{{ $wa }}" class="btn btn-line btn-block">{{ $en ? 'Contact us' : 'Hubungi kami' }}</a>
          @elseif($plan->period === '/tahun')
          <a href="{{ $wa }}" class="btn btn-line btn-block">{{ $en ? 'Renew via WhatsApp' : 'Perpanjang via WhatsApp' }}</a>
          @else
          <a href="{{ route('order-wizard.start') }}" class="btn btn-primary btn-block">{{ $en ? 'Start now' : 'Mulai sekarang' }}</a>
          @endif
        </div>
        @endforeach
      </div>
      <p class="center muted reveal" style="margin-top:22px;font-size:13.5px">{{ $en ? 'Custom (Signature) pricing is calculated from project cost — contact us for a tailored quote.' : 'Harga Custom (Signature) dihitung dari biaya proyek — hubungi kami untuk penawaran khusus.' }}</p>
    </div>
  </section>
  @endif

  {{-- add-ons --}}
  <section class="section process">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">{{ $en ? 'Add-ons' : 'Layanan Tambahan' }}</span>
        <h2 class="heading">{{ $en ? 'Add only what you need' : 'Tambah sesuai kebutuhan saja' }}</h2>
        <p class="lead">{{ $en ? 'Extra services you can add anytime, à la carte — transparent flat pricing.' : 'Layanan ekstra yang bisa ditambahkan kapan saja, satuan — harga jelas dan tetap.' }}</p>
      </div>
      <div class="grid-2" style="max-width:820px;margin-inline:auto">
        @foreach($addons as $a)
        <div class="price-card reveal" style="padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:16px">
          <span style="font-family:var(--display);font-weight:600;color:var(--ink);font-size:15px">{{ $en ? $a[1] : $a[0] }}</span>
          <strong style="font-family:var(--display);color:var(--brand-d);white-space:nowrap">Rp{{ number_format($a[2],0,',','.') }}<span style="color:var(--muted);font-weight:500;font-size:12.5px">{{ $a[3] }}</span></strong>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- included in every plan --}}
  <section class="section">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">{{ $en ? 'Always included' : 'Selalu termasuk' }}</span>
        <h2 class="heading">{{ $en ? 'Every package comes with the essentials' : 'Setiap paket sudah lengkap dengan dasarnya' }}</h2>
      </div>
      <div class="tech-grid">
        @php
        $incl = $en
          ? [['shield','Free SSL','Secure HTTPS on every page out of the box.'],['deploy','Domain & hosting','Domain + DNS and hosting + SSL included for a year.'],['target','Mobile responsive','Looks great on phones, tablets, and desktops.'],['award','Ongoing support','Help via WhatsApp whenever you need it.']]
          : [['shield','SSL gratis','HTTPS aman di setiap halaman tanpa biaya tambahan.'],['deploy','Domain & hosting','Domain + DNS dan hosting + SSL termasuk selama setahun.'],['target','Responsif mobile','Tampil rapi di ponsel, tablet, dan desktop.'],['award','Dukungan berkelanjutan','Bantuan via WhatsApp kapan pun dibutuhkan.']];
        @endphp
        @foreach($incl as $it)
        <div class="tech-card reveal">
          <div class="ic">{!! \App\Support\Icons::get($it[0]) !!}</div>
          <h3>{{ $it[1] }}</h3>
          <p style="font-size:14px">{{ $it[2] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- pricing FAQ --}}
  <section class="section faq" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">FAQ</span>
        <h2 class="heading">{{ $en ? 'Pricing questions' : 'Pertanyaan seputar harga' }}</h2>
      </div>
      <div class="faq-wrap">
        @php
        $pfaq = $en
          ? [['What does ConWeb Launch include?','Everything to get online: domain + DNS, hosting + SSL for a year, professional template/UI setup, and a fully built website by our team.'],['What is ConWeb Care?','It’s the yearly renewal & maintenance — keeping your domain, hosting, SSL, and site updated and supported after the first year.'],['How is Signature (custom) priced?','Custom projects are quoted based on scope and cost. Reach out and we’ll prepare a tailored quote.'],['Are there hidden fees?','No. The package price covers everything listed. Add-ons are optional and priced clearly above.']]
          : [['Apa saja yang termasuk di ConWeb Launch?','Semua untuk online: domain + DNS, hosting + SSL setahun, setup template/UI profesional, dan website jadi yang dikerjakan tim kami.'],['Apa itu ConWeb Care?','Perpanjangan & perawatan tahunan — menjaga domain, hosting, SSL, dan website tetap diperbarui dan didukung setelah tahun pertama.'],['Bagaimana harga Signature (custom)?','Proyek custom dihitung berdasarkan ruang lingkup dan biaya. Hubungi kami dan kami siapkan penawaran khusus.'],['Apakah ada biaya tersembunyi?','Tidak. Harga paket sudah mencakup semua yang tertera. Add-on bersifat opsional dengan harga jelas di atas.']];
        @endphp
        @foreach($pfaq as $i => $fq)
        <div class="faq-item {{ $i === 0 ? 'open' : '' }} reveal">
          <button class="faq-q"><h3>{{ $fq[0] }}</h3><span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
          <div class="faq-a"><div>{{ $fq[1] }}</div></div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <h2>{{ $en ? 'Not sure which package?' : 'Bingung pilih paket?' }}</h2>
        <p>{{ $en ? 'Tell us your goals and we’ll recommend the best fit — free, no pressure.' : 'Ceritakan tujuan Anda dan kami rekomendasikan yang paling pas — gratis, tanpa paksaan.' }}</p>
        <div class="cta-actions">
          <a href="{{ route('order-wizard.start') }}" class="btn btn-light">{{ $en ? 'Start order' : 'Mulai pesan' }}</a>
          <a href="{{ $wa }}" class="btn btn-outline-light">{{ $en ? 'Ask on WhatsApp' : 'Tanya via WhatsApp' }}</a>
        </div>
      </div>
    </div>
  </section>
@endsection
