@extends('layouts.app')

@php
$en = site_locale() === 'en';
$cats = $portfolio->map(fn($p) => t($p, 'category'))->filter()->unique()->values();
@endphp

@section('title', ($en ? 'Portfolio — Websites & Apps We Built — '.$brand.' '.$suffix : 'Portofolio Website & Aplikasi — '.$brand.' '.$suffix))
@section('description', $en ? 'See websites, apps, and custom systems built by ConWeb ID for real businesses across Indonesia.' : 'Lihat portofolio website, aplikasi, dan sistem custom buatan ConWeb ID untuk berbagai bisnis di Indonesia.')

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('home') }}">{{ $en ? 'Home' : 'Beranda' }}</a><span>/</span><span>{{ $en ? 'Portfolio' : 'Portofolio' }}</span></div>
      <span class="eyebrow">{{ setting_t('pf.eyebrow') }}</span>
      <h1>{{ setting_t('pf.title') }}</h1>
      <p>{{ setting_t('pf.lead') }}</p>
    </div>
  </section>

  {{-- results strip --}}
  <section class="logos" style="margin-bottom:0">
    <div class="wrap stats-grid reveal">
      @php
      $pfStats = $en
        ? [[$portfolio->count().'+','Projects shipped'],['12','Industries served'],['98%','Would recommend'],['7d','Avg. delivery']]
        : [[$portfolio->count().'+','Proyek dikerjakan'],['12','Industri dilayani'],['98%','Merekomendasikan'],['7h','Rata-rata rilis']];
      @endphp
      @foreach($pfStats as $st)
      <div class="stat {{ $loop->last ? '' : 'stat-div' }}"><b>{{ $st[0] }}</b><span>{{ $st[1] }}</span></div>
      @endforeach
    </div>
  </section>

  <section class="section" style="padding-top:64px">
    <div class="wrap">
      @if($cats->count() > 1)
      <div class="filter-row reveal" id="pf-filter">
        <a href="#" class="active" data-cat="all">{{ $en ? 'All' : 'Semua' }}</a>
        @foreach($cats as $c)
        <a href="#" data-cat="{{ $c }}">{{ $c }}</a>
        @endforeach
      </div>
      @endif

      <div class="pf-grid">
        @foreach($portfolio as $p)
        <article class="pf pf-{{ $p->size }} reveal" data-cat="{{ t($p, 'category') }}">
          <div class="pf-bg" style="@if($p->image)background-image:url('{{ asset('storage/'.$p->image) }}');@else background:{{ $p->gradient }};@endif"></div>
          <div class="pf-mesh"></div>
          <a href="{{ $p->link ?: '#' }}" class="pf-open" aria-label="Buka"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
          <div class="pf-cat">{!! \App\Support\Icons::get($p->icon) !!}<span>{{ t($p, 'category') }}</span></div>
          <h3>{{ $p->title }}</h3>
          <p>{{ t($p, 'desc') }}</p>
          <div class="pf-tags">@foreach(($p->tags ?? []) as $tag)<span>{{ $tag }}</span>@endforeach</div>
        </article>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <span class="eyebrow">{{ $en ? 'Your project next' : 'Proyek Anda berikutnya' }}</span>
        <h2>{{ $en ? 'Let’s make your business stand out' : 'Mari buat bisnis Anda menonjol' }}</h2>
        <p>{{ $en ? 'Join the businesses already growing online with ConWeb.' : 'Bergabunglah dengan bisnis yang sudah bertumbuh online bersama ConWeb.' }}</p>
        <div class="cta-actions">
          <a href="{{ route('order-wizard.start') }}" class="btn btn-light">{{ $en ? 'Start a project' : 'Mulai proyek' }}</a>
          <a href="{{ route('pricing.index') }}" class="btn btn-outline-light">{{ $en ? 'See pricing' : 'Lihat harga' }}</a>
        </div>
      </div>
    </div>
  </section>

  @push('scripts')
  <script>
    const pfFilter = document.getElementById('pf-filter');
    if (pfFilter) {
      pfFilter.addEventListener('click', e => {
        const link = e.target.closest('a'); if (!link) return;
        e.preventDefault();
        pfFilter.querySelectorAll('a').forEach(a => a.classList.remove('active'));
        link.classList.add('active');
        const cat = link.dataset.cat;
        document.querySelectorAll('.pf-grid .pf').forEach(card => {
          card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
        });
      });
    }
  </script>
  @endpush
@endsection
