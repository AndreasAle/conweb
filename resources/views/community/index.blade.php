@extends('layouts.app')

@php $en = site_locale() === 'en'; @endphp

@section('title', ($en ? 'Community' : 'Komunitas').' — '.$brand.' '.$suffix)

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('home') }}">{{ $en ? 'Home' : 'Beranda' }}</a><span>/</span><span>{{ $en ? 'Community' : 'Komunitas' }}</span></div>
      <span class="eyebrow">{{ $en ? 'Community' : 'Komunitas' }}</span>
      <h1>{{ $en ? 'Grow together with fellow business owners' : 'Bertumbuh bersama sesama pemilik usaha' }}</h1>
      <p>{{ $en ? 'Join discussions, learning sessions, exclusive promos, and shared experiences from business owners across Indonesia.' : 'Ikut diskusi, sesi belajar, promo eksklusif, dan berbagi pengalaman bersama pelaku usaha se-Indonesia.' }}</p>
      <div class="hero-cta" style="margin-top:26px;margin-bottom:0">
        <a href="{{ $wa }}" class="btn btn-primary">{{ $en ? 'Join via WhatsApp' : 'Gabung via WhatsApp' }}<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      </div>
    </div>
  </section>

  @if($stats->count())
  <section class="logos" style="margin-bottom:0">
    <div class="wrap stats-grid reveal">
      @foreach($stats as $stat)
      <div class="stat {{ $loop->last ? '' : 'stat-div' }} community-stat"><b>{{ $stat->value }}<span style="font-size:.6em">{{ $stat->suffix }}</span></b><span>{{ t($stat, 'label') }}</span></div>
      @endforeach
    </div>
  </section>
  @endif

  {{-- what you get --}}
  <section class="section">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">{{ $en ? 'Member benefits' : 'Manfaat anggota' }}</span>
        <h2 class="heading">{{ $en ? 'What you get' : 'Apa yang Anda dapatkan' }}</h2>
        <p class="lead">{{ $en ? 'A supportive space built to help your business learn, connect, and grow faster.' : 'Ruang suportif yang dibangun untuk membantu bisnis Anda belajar, terhubung, dan tumbuh lebih cepat.' }}</p>
      </div>
      <div class="proc-grid">
        @php
        $items = $en
          ? [['Discussion Groups','Share challenges and solutions with fellow members.'],['Learning Classes','Free webinars on marketing, design, and operations.'],['Exclusive Promos','Special discounts for active community members.'],['Export Financing Info','Curated information about export financing programs.']]
          : [['Grup Diskusi','Berbagi kendala dan solusi dengan sesama anggota.'],['Kelas Belajar','Webinar gratis seputar marketing, desain, dan operasional.'],['Promo Eksklusif','Diskon khusus untuk anggota komunitas aktif.'],['Info Pembiayaan Ekspor','Informasi terkurasi seputar program pembiayaan ekspor.']];
        @endphp
        @foreach($items as $i => $item)
        <div class="proc reveal" style="transition-delay:{{ $i*.06 }}s">
          <div class="proc-num">{{ sprintf('%02d', $i+1) }}</div>
          <h3>{{ $item[0] }}</h3>
          <p>{{ $item[1] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- how it works --}}
  <section class="section process">
    <div class="wrap why-grid">
      <div class="reveal">
        <span class="eyebrow">{{ $en ? 'Getting started' : 'Cara mulai' }}</span>
        <h2 class="heading">{{ $en ? 'Three steps to join' : 'Tiga langkah untuk bergabung' }}</h2>
        <p class="lead">{{ $en ? 'It’s free and takes less than a minute to become part of the community.' : 'Gratis dan kurang dari semenit untuk menjadi bagian komunitas.' }}</p>
        <div class="why-points">
          @php
          $how = $en
            ? [['target','Say hello','Message us on WhatsApp to request an invite link.'],['layers','Pick your channels','Join the groups that match your industry and interests.'],['award','Start growing','Attend sessions, ask questions, and unlock member promos.']]
            : [['target','Sapa kami','Chat WhatsApp untuk minta tautan undangan.'],['layers','Pilih kanal','Gabung grup yang sesuai industri dan minat Anda.'],['award','Mulai bertumbuh','Ikut sesi, bertanya, dan nikmati promo anggota.']];
          @endphp
          @foreach($how as $h)
          <div class="why-pt">
            <div class="ic">{!! \App\Support\Icons::get($h[0]) !!}</div>
            <div><h4>{{ $h[1] }}</h4><p>{{ $h[2] }}</p></div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="why-visual reveal">
        <div class="qm">&ldquo;</div>
        <blockquote>{{ $en ? 'The community gave me real answers from people who run the same kind of business.' : 'Komunitas ini memberi saya jawaban nyata dari orang yang menjalankan bisnis serupa.' }}</blockquote>
        <div class="why-author">
          <div class="av">S</div>
          <div><strong>Siti Rahma</strong><span>{{ $en ? 'Member since 2024' : 'Anggota sejak 2024' }}</span></div>
        </div>
        <div class="why-mini">
          <div><b>500+</b><span>{{ $en ? 'Active members' : 'Anggota aktif' }}</span></div>
          <div><b>Free</b><span>{{ $en ? 'To join' : 'Untuk gabung' }}</span></div>
        </div>
      </div>
    </div>
  </section>

  @if($testimonials->count())
  <section class="section">
    <div class="wrap">
      <div class="sec-head center reveal"><h2 class="heading">{{ setting_t('testi.title') }}</h2></div>
      <div class="testi-grid">
        @foreach($testimonials as $tm)
        <div class="testi reveal">
          <div class="stars" style="color:#f5b50a">{{ str_repeat('★', $tm->rating) }}</div>
          <p>{{ t($tm, 'quote') }}</p>
          <div class="testi-user"><div class="av" style="background:{{ $tm->gradient }}">{{ $tm->avatar_letter }}</div><div><strong>{{ $tm->name }}</strong><span>{{ t($tm, 'role') }}</span></div></div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <span class="eyebrow">{{ $en ? 'Free to join' : 'Gratis bergabung' }}</span>
        <h2>{{ $en ? 'Join the community today' : 'Gabung komunitas hari ini' }}</h2>
        <p>{{ $en ? 'Connect with us on WhatsApp to get an invite.' : 'Hubungi kami via WhatsApp untuk mendapatkan undangan.' }}</p>
        <div class="cta-actions">
          <a href="{{ $wa }}" class="btn btn-light">{{ $en ? 'Join via WhatsApp' : 'Gabung via WhatsApp' }}</a>
        </div>
      </div>
    </div>
  </section>
@endsection
