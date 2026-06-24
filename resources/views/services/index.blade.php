@extends('layouts.app')

@php $en = site_locale() === 'en'; @endphp

@section('title', ($en ? 'Services' : 'Layanan').' — '.$brand.' '.$suffix)

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('home') }}">{{ $en ? 'Home' : 'Beranda' }}</a><span>/</span><span>{{ $en ? 'Services' : 'Layanan' }}</span></div>
      <span class="eyebrow">{{ setting_t('services.eyebrow') }}</span>
      <h1>{{ setting_t('services.title') }}</h1>
      <p>{{ setting_t('services.lead') }}</p>
      <div class="hero-cta" style="margin-top:26px;margin-bottom:0">
        <a href="{{ route('order-wizard.start') }}" class="btn btn-primary">{{ $en ? 'Start a project' : 'Mulai proyek' }}<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        <a href="{{ route('pricing.index') }}" class="btn btn-line">{{ $en ? 'See pricing' : 'Lihat harga' }}</a>
      </div>
    </div>
  </section>

  {{-- quick stats strip --}}
  <section class="logos">
    <div class="wrap stats-grid reveal">
      @php
      $svcStats = $en
        ? [['250+','Projects delivered'],['98%','Client satisfaction'],['7','Days average launch'],['24/7','Support coverage']]
        : [['250+','Proyek selesai'],['98%','Kepuasan klien'],['7','Hari rata-rata rilis'],['24/7','Dukungan tim']];
      @endphp
      @foreach($svcStats as $i => $st)
      <div class="stat {{ $loop->last ? '' : 'stat-div' }}"><b>{{ $st[0] }}</b><span>{{ $st[1] }}</span></div>
      @endforeach
    </div>
  </section>

  {{-- services grid --}}
  <section class="section services">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">{{ $en ? 'What we do' : 'Yang kami kerjakan' }}</span>
        <h2 class="heading">{{ $en ? 'Solutions tailored to your business' : 'Solusi yang disesuaikan dengan bisnis Anda' }}</h2>
        <p class="lead">{{ $en ? 'From a single landing page to a full digital ecosystem — pick the service that moves your business forward.' : 'Dari satu halaman landing hingga ekosistem digital lengkap — pilih layanan yang mendorong bisnis Anda maju.' }}</p>
      </div>
      <div class="svc-grid">
        @foreach($services as $sv)
        <div class="svc reveal">
          <div class="svc-ic">{!! \App\Support\Icons::get($sv->icon) !!}</div>
          <h3>{{ t($sv, 'title') }}</h3>
          <p>{{ t($sv, 'desc') }}</p>
          <ul>
            @foreach(($sv->features ?? []) as $f)
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{{ $f[site_locale()] ?? '' }}</span></li>
            @endforeach
          </ul>
          <div style="display:flex;gap:12px;margin-top:22px;flex-wrap:wrap">
            @if($sv->slug)
            <a href="{{ route('services.show', $sv->slug) }}" class="btn btn-line btn-sm">{{ $en ? 'Details' : 'Detail' }}</a>
            @endif
            <a href="{{ route('order.create', ['service' => $sv->slug]) }}" class="btn btn-primary btn-sm">{{ $en ? 'Order Now' : 'Pesan Sekarang' }}</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- how we work --}}
  <section class="section process">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">{{ $en ? 'Our process' : 'Proses kami' }}</span>
        <h2 class="heading">{{ $en ? 'A clear path from idea to launch' : 'Alur jelas dari ide hingga rilis' }}</h2>
      </div>
      <div class="proc-grid">
        @php
        $steps = $en
          ? [['Discovery','We learn your goals, audience, and brand to map the right scope.'],['Design','You review a modern mockup and we refine until it feels right.'],['Build','We develop, fill in content, and connect domain, hosting & SSL.'],['Launch & Care','Your site goes live and we keep supporting and updating it.']]
          : [['Diskusi Awal','Kami pelajari tujuan, audiens, dan brand Anda untuk menentukan ruang lingkup.'],['Desain','Anda meninjau mockup modern dan kami sempurnakan hingga pas.'],['Pengerjaan','Kami bangun, isi konten, dan sambungkan domain, hosting & SSL.'],['Rilis & Rawat','Situs Anda tayang dan kami terus dukung serta perbarui.']];
        @endphp
        @foreach($steps as $i => $step)
        <div class="proc reveal" style="transition-delay:{{ $i*.06 }}s">
          <div class="proc-num">{{ sprintf('%02d', $i+1) }}</div>
          <h3>{{ $step[0] }}</h3>
          <p>{{ $step[1] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- why us --}}
  <section class="section">
    <div class="wrap why-grid">
      <div class="reveal">
        <span class="eyebrow">{{ $en ? 'Why ConWeb' : 'Kenapa ConWeb' }}</span>
        <h2 class="heading">{{ $en ? 'More than a website — a partner for growth' : 'Lebih dari sekadar website — partner untuk bertumbuh' }}</h2>
        <p class="lead">{{ $en ? 'Every service comes with transparent pricing, fast turnaround, and a team that stays with you after launch.' : 'Setiap layanan hadir dengan harga transparan, pengerjaan cepat, dan tim yang tetap mendampingi setelah rilis.' }}</p>
        <div class="why-points">
          @php
          $why = $en
            ? [['deploy','Fast turnaround','Most projects launch within 7 days without cutting corners.'],['shield','Reliable & secure','Free SSL, daily backups, and 99.9% uptime hosting included.'],['target','Human support','Talk to real people via WhatsApp whenever you need help.']]
            : [['deploy','Pengerjaan cepat','Mayoritas proyek tayang dalam 7 hari tanpa mengurangi kualitas.'],['shield','Andal & aman','SSL gratis, backup harian, dan hosting uptime 99,9% sudah termasuk.'],['target','Dukungan manusia','Bicara dengan tim asli via WhatsApp kapan pun Anda butuh.']];
          @endphp
          @foreach($why as $w)
          <div class="why-pt">
            <div class="ic">{!! \App\Support\Icons::get($w[0]) !!}</div>
            <div><h4>{{ $w[1] }}</h4><p>{{ $w[2] }}</p></div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="why-visual reveal">
        <div class="qm">&ldquo;</div>
        <blockquote>{{ $en ? 'They turned our idea into a polished store in a week. Sales started in the first month.' : 'Mereka mengubah ide kami jadi toko yang rapi dalam seminggu. Penjualan mulai di bulan pertama.' }}</blockquote>
        <div class="why-author">
          <div class="av">A</div>
          <div><strong>Andi Pratama</strong><span>{{ $en ? 'Owner, Kopi Nusantara' : 'Pemilik, Kopi Nusantara' }}</span></div>
        </div>
        <div class="why-mini">
          <div><b>7d</b><span>{{ $en ? 'To launch' : 'Sampai rilis' }}</span></div>
          <div><b>3x</b><span>{{ $en ? 'More leads' : 'Lebih banyak leads' }}</span></div>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <span class="eyebrow">{{ $en ? 'Ready when you are' : 'Siap kapan pun Anda mau' }}</span>
        <h2>{{ $en ? 'Let’s build something that works' : 'Mari bangun sesuatu yang berdampak' }}</h2>
        <p>{{ $en ? 'Tell us about your project and get a free consultation today.' : 'Ceritakan proyek Anda dan dapatkan konsultasi gratis hari ini.' }}</p>
        <div class="cta-actions">
          <a href="{{ route('order-wizard.start') }}" class="btn btn-light">{{ $en ? 'Start now' : 'Mulai sekarang' }}</a>
          <a href="{{ $wa }}" class="btn btn-outline-light">{{ $en ? 'Chat on WhatsApp' : 'Chat via WhatsApp' }}</a>
        </div>
      </div>
    </div>
  </section>
@endsection
