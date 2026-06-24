@extends('layouts.app')

@section('title', (site_locale() === 'en' ? 'About Us' : 'Tentang Kami').' — '.$brand.' '.$suffix)

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <span class="eyebrow">{{ site_locale() === 'en' ? 'About Us' : 'Tentang Kami' }}</span>
      <h1>{{ $brand }} {{ $suffix }} — {{ site_locale() === 'en' ? 'your digital growth partner' : 'partner pertumbuhan digital Anda' }}</h1>
      <p>{{ setting_t('hero.desc') }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap stats-grid reveal">
      @foreach($stats as $stat)
      <div class="stat {{ $loop->last ? '' : 'stat-div' }}"><b>{{ $stat->value }}<span style="font-size:.6em">{{ $stat->suffix }}</span></b><span>{{ t($stat, 'label') }}</span></div>
      @endforeach
    </div>
  </section>

  <section class="section process">
    <div class="wrap why-grid">
      <div class="reveal">
        <h2 class="heading">{{ setting_t('why.title') }}</h2>
        <p class="lead">{{ setting_t('why.lead') }}</p>
      </div>
      <div class="why-visual reveal">
        <div class="qm">"</div>
        <blockquote>{{ setting_t('why.quote') }}</blockquote>
        <div class="why-author">
          <div class="av">{{ mb_substr($s['why.authorName'] ?? 'A',0,1) }}</div>
          <div><strong>{{ $s['why.authorName'] ?? '' }}</strong><span>{{ setting_t('why.author') }}</span></div>
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
        <h2>{{ setting_t('contact.title') }}</h2>
        <p>{{ setting_t('contact.desc') }}</p>
        <div class="cta-actions">
          <a href="{{ route('order.create') }}" class="btn btn-light">{{ setting_t('contact.cta1') }}</a>
          <a href="{{ $wa }}" class="btn btn-outline-light">{{ setting_t('contact.cta2') }}</a>
        </div>
      </div>
    </div>
  </section>
@endsection
