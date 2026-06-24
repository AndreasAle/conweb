@extends('layouts.app')

@section('title', $s['site.title'] ?? 'ConWeb ID')
@section('description', $s['site.description'] ?? '')

@push('styles')
<style>
  .hero-slides{position:relative}
  .hero-slide{display:none}
  .hero-slide.active{display:block;animation:heroFade .5s ease}
  @keyframes heroFade{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
  .hero-promo{display:flex;align-items:center;gap:12px;margin-bottom:24px;flex-wrap:wrap}
  .hero-promo .promo-label{font-family:var(--display);font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted)}
  .hero-promo .promo-amount{font-family:var(--display);font-weight:700;font-size:18px;color:var(--ink)}
  .hero-promo .promo-code{font-family:var(--display);font-weight:700;font-size:12px;color:#fff;background:var(--brand);padding:6px 14px;border-radius:99px}
  .hero-photo{width:100%;aspect-ratio:4/5;max-height:520px;border-radius:var(--radius-lg);background-size:cover;background-position:center;box-shadow:var(--shadow-lg);background-color:var(--soft-2)}
  .hero-photo-placeholder{background:linear-gradient(135deg,var(--brand-tint),var(--soft-2))}
  .hero-controls{display:flex;align-items:center;justify-content:center;gap:18px;margin-top:34px}
  .hero-arrow{width:42px;height:42px;border-radius:50%;background:#fff;border:1px solid var(--line-2);box-shadow:var(--shadow-sm);display:grid;place-items:center;font-size:18px;color:var(--ink);transition:var(--t)}
  .hero-arrow:hover{border-color:var(--brand-l);color:var(--brand-d)}
  .hero-dots{display:flex;gap:8px}
  .hero-dot{width:9px;height:9px;border-radius:50%;background:var(--line-2);transition:var(--t)}
  .hero-dot.active{background:var(--brand);width:26px;border-radius:5px}
  @media (max-width:1080px){.hero-photo{max-height:380px;margin-inline:auto}}
</style>
@endpush

@section('content')

  <!-- HERO CAROUSEL -->
  <header class="hero" id="top">
    <div class="wrap">
      @if($heroSlides->count())
      <div class="hero-slides" id="hero-slides">
        @foreach($heroSlides as $i => $slide)
        <div class="hero-slide {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}">
          <div class="hero-grid">
            <div class="reveal">
              @if(t($slide, 'badge'))
              <span class="eyebrow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h7l-1 8 10-12h-7z"/></svg>
                <span>{{ t($slide, 'badge') }}</span>
              </span>
              @endif
              <h1>{!! t($slide, 'title') !!}</h1>
              @if(t($slide, 'desc'))<p class="desc">{{ t($slide, 'desc') }}</p>@endif

              @if(t($slide, 'discount_text') || $slide->promo_code)
              <div class="hero-promo">
                @if(t($slide, 'discount_text'))
                <span class="promo-label">{{ site_locale() === 'en' ? 'DISCOUNT' : 'DISKON' }}</span>
                <span class="promo-amount">{{ t($slide, 'discount_text') }}</span>
                @endif
                @if($slide->promo_code)<span class="promo-code">{{ site_locale() === 'en' ? 'CODE' : 'KODE' }} {{ $slide->promo_code }}</span>@endif
              </div>
              @endif

              <div class="hero-cta">
                @if($slide->button1_label_id)
                <a href="{{ $slide->button1_url ?: route('templates.index') }}" class="btn btn-primary">
                  <span>{{ t($slide, 'button1_label') }}</span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                @endif
                @if($slide->button2_label_id)
                <a href="{{ $slide->button2_url ?: $wa }}" class="btn btn-line">{{ t($slide, 'button2_label') }}</a>
                @endif
              </div>
            </div>
            <div class="hero-vis reveal" style="transition-delay:.1s">
              <div class="hero-photo @if(!$slide->image) hero-photo-placeholder @endif" @if($slide->image) style="background-image:url('{{ asset('storage/'.$slide->image) }}')" @endif></div>
              @if(t($slide, 'float1_text'))
              <div class="float-card float-a">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div><strong>{{ t($slide, 'float1_text') }}</strong></div>
              </div>
              @endif
              @if(t($slide, 'float2_text'))
              <div class="float-card float-b">
                <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
                <div><strong>{{ t($slide, 'float2_text') }}</strong></div>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      @if($heroSlides->count() > 1)
      <div class="hero-controls">
        <button class="hero-arrow" id="hero-prev" aria-label="Sebelumnya">‹</button>
        <div class="hero-dots" id="hero-dots">
          @foreach($heroSlides as $i => $slide)
          <button class="hero-dot {{ $i === 0 ? 'active' : '' }}" data-dot="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
          @endforeach
        </div>
        <button class="hero-arrow" id="hero-next" aria-label="Selanjutnya">›</button>
      </div>
      @endif
      @else
      <div class="hero-grid">
        <div class="reveal">
          <span class="eyebrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h7l-1 8 10-12h-7z"/></svg>
            <span>{{ setting_t('hero.eyebrow') }}</span>
          </span>
          <h1>{!! setting_t('hero.title') !!}</h1>
          <p class="desc">{{ setting_t('hero.desc') }}</p>
          <div class="hero-cta">
            <a href="{{ route('templates.index') }}" class="btn btn-primary">
              <span>{{ setting_t('hero.cta1') }}</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ route('portfolio.index') }}" class="btn btn-line">{{ setting_t('hero.cta2') }}</a>
          </div>
        </div>
        <div class="hero-vis reveal" style="transition-delay:.1s">
          <div class="hero-photo hero-photo-placeholder"></div>
        </div>
      </div>
      @endif
    </div>
  </header>

  <!-- KOLEKSI DESAIN -->
  @if($designs->count())
  <section class="section" id="designs" style="padding-top:64px">
    <div class="wrap">
      <div class="sec-head reveal" style="display:flex;justify-content:space-between;align-items:flex-end;gap:24px;flex-wrap:wrap;margin-bottom:34px;max-width:none">
        <div>
          <span class="eyebrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
            <span>{{ setting_t('designs.eyebrow') ?: (site_locale() === 'en' ? '01 · Design Collection' : '01 · Koleksi Desain') }}</span>
          </span>
          <h2 class="heading" style="margin-bottom:0">{!! setting_t('designs.title') ?: (site_locale() === 'en' ? 'Hundreds of <em>ready-made designs</em> for every business.' : 'Sedia <em>desain siap pakai</em> untuk semua jenis bisnis.') !!}</h2>
        </div>
        <p class="lead" style="max-width:320px">{{ setting_t('designs.lead') ?: (site_locale() === 'en' ? 'Pick a category, swap templates anytime. Every design is SEO-optimized and looks great on every device.' : 'Pilih kategori, ganti template gratis kapan pun. Setiap desain sudah dioptimasi untuk SEO dan tampil rapi di semua perangkat.') }}</p>
      </div>

      <div class="filter-row reveal" id="design-filter">
        <a href="#" class="active" data-filter="all">{{ site_locale() === 'en' ? 'All' : 'Semua' }}</a>
        @foreach($designCategories as $cat)
        <a href="#" data-filter="{{ $cat }}">{{ $cat }}</a>
        @endforeach
      </div>

      <div class="grid-3" id="design-grid">
        @foreach($designs as $tpl)
        <div class="tpl-card reveal" data-category="{{ $tpl->category }}">
          <div class="tpl-thumb" style="@if($tpl->thumbnail)background-image:url('{{ asset('storage/'.$tpl->thumbnail) }}')@else background:linear-gradient(135deg,{{ $tpl->primary_color }},{{ $tpl->secondary_color }})@endif">
            @if($tpl->is_featured)<span class="badge">{{ site_locale() === 'en' ? 'Featured' : 'Unggulan' }}</span>@endif
          </div>
          <div class="tpl-body">
            <span class="cat">{{ $tpl->category }}</span>
            <h3>{{ $tpl->name }}</h3>
            <p style="font-size:13.5px">{{ $tpl->popularity }} {{ site_locale() === 'en' ? 'people chose this' : 'orang memilih ini' }}</p>
            <div class="tpl-foot">
              <a href="{{ route('templates.show', $tpl->slug) }}" class="btn btn-sm btn-line">{{ site_locale() === 'en' ? 'Preview' : 'Lihat' }}</a>
              <a href="{{ route('order-wizard.start', ['template' => $tpl->slug]) }}" class="btn btn-sm btn-primary">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                {{ site_locale() === 'en' ? 'Buy' : 'Beli' }}
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="center" style="margin-top:36px">
        <a href="{{ route('templates.index') }}" class="btn btn-line">{{ site_locale() === 'en' ? 'View All Designs' : 'Lihat Semua Desain' }} →</a>
      </div>
    </div>
  </section>
  @endif

  <!-- LOGOS -->
  <section class="logos reveal">
    <div class="wrap">
      <p>{{ setting_t('logos.title') }}</p>
      <div class="logos-row">
        @foreach($logos as $lg)<span>{{ $lg->name }}</span>@endforeach
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="section">
    <div class="wrap stats-grid reveal">
      @foreach($stats as $stat)
      <div class="stat {{ $loop->last ? '' : 'stat-div' }}"><b>{{ $stat->value }}<span style="font-size:.6em">{{ $stat->suffix }}</span></b><span>{{ t($stat, 'label') }}</span></div>
      @endforeach
    </div>
  </section>

  <!-- SERVICES -->
  <section class="section services" id="services">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
          <span>{{ setting_t('services.eyebrow') }}</span>
        </span>
        <h2 class="heading">{{ setting_t('services.title') }}</h2>
        <p class="lead">{{ setting_t('services.lead') }}</p>
      </div>
      <div class="svc-grid">
        @foreach($services as $sv)
        <div class="svc reveal">
          <div class="svc-ic">{!! \App\Support\Icons::get($sv->icon) !!}</div>
          <h3>{{ t($sv, 'title') }}</h3>
          <p>{{ t($sv, 'desc') }}</p>
          <ul>
            @foreach(($sv->features ?? []) as $f)
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{{ $f[site_locale()] ?? ($f['id'] ?? '') }}</span></li>
            @endforeach
          </ul>
          @if($sv->slug)
          <a href="{{ route('services.show', $sv->slug) }}" class="svc-more">{{ site_locale() === 'en' ? 'Learn more' : 'Pelajari lebih lanjut' }} →</a>
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- PAKET DOMAIN -->
  @if($packagePlans->count())
  <section class="section">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          <span>{{ setting_t('pricing.eyebrow') ?: (site_locale() === 'en' ? '03 · Packages' : '03 · Paket') }}</span>
        </span>
        <h2 class="heading">{!! setting_t('pricing.title') ?: (site_locale() === 'en' ? 'One package, <em>everything included</em>.' : 'Satu paket, <em>semua sudah termasuk</em>.') !!}</h2>
        <p class="lead">{{ setting_t('pricing.lead') ?: (site_locale() === 'en' ? 'Domain, hosting, SSL, and a fully built website in one transparent price. No hidden fees.' : 'Domain, hosting, SSL, dan website jadi dalam satu harga transparan. Tanpa biaya tersembunyi.') }}</p>
      </div>
      <div class="grid-3">
        @foreach($packagePlans as $plan)
        @php $custom = $plan->price <= 0 || $plan->period === 'custom'; @endphp
        <div class="price-card reveal" style="{{ $plan->badge === 'Paling Lengkap' ? 'outline:2px solid var(--brand)' : '' }}">
          @if($plan->badge)<span class="badge">{{ $plan->badge }}</span>@endif
          <h3>{{ $plan->name }}</h3>
          @if($plan->original_price)<div class="price-old">Rp{{ number_format($plan->original_price, 0, ',', '.') }}</div>@endif
          @if($custom)
          <div class="price-now">Custom <span>{{ site_locale() === 'en' ? 'on request' : 'sesuai kebutuhan' }}</span></div>
          @else
          <div class="price-now">Rp{{ number_format($plan->price, 0, ',', '.') }} <span>{{ $plan->period }}</span></div>
          @endif
          <ul class="price-feat">
            @foreach(($plan->features ?? []) as $f)
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{{ $f }}</span></li>
            @endforeach
          </ul>
          @if($custom || $plan->period === '/tahun')
          <a href="{{ $wa }}" class="btn btn-line btn-block">{{ site_locale() === 'en' ? 'Contact us' : 'Hubungi kami' }}</a>
          @else
          <a href="{{ route('order-wizard.start') }}" class="btn btn-primary btn-block">
            {{ site_locale() === 'en' ? 'Start now' : 'Mulai sekarang' }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          @endif
        </div>
        @endforeach
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-top:36px;padding-top:28px;border-top:1px solid var(--line)">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
          <span style="font-size:13.5px;color:var(--muted)">{{ site_locale() === 'en' ? 'Need add-ons or custom work?' : 'Butuh add-on atau pekerjaan custom?' }}</span>
        </div>
        <a href="{{ route('pricing.index') }}" class="btn-ghost" style="font-weight:600;color:var(--brand-d)">{{ site_locale() === 'en' ? 'See full pricing' : 'Lihat semua harga' }} →</a>
      </div>
    </div>
  </section>
  @endif

  <!-- WHY -->
  <section class="section" id="why">
    <div class="wrap why-grid">
      <div class="reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.4 8.5 8 11 4.6-2.5 8-6 8-11V5z"/></svg>
          <span>{{ setting_t('why.eyebrow') }}</span>
        </span>
        <h2 class="heading">{{ setting_t('why.title') }}</h2>
        <p class="lead" style="margin-bottom:28px">{{ setting_t('why.lead') }}</p>
        <div class="why-points">
          @php $whyIcons = ['design','layers','target','shield']; @endphp
          @for($n=1;$n<=4;$n++)
          <div class="why-pt">
            <div class="ic">{!! \App\Support\Icons::get($whyIcons[$n-1]) !!}</div>
            <div><h4>{{ setting_t("why.p{$n}t") }}</h4><p>{{ setting_t("why.p{$n}d") }}</p></div>
          </div>
          @endfor
        </div>
      </div>
      <div class="why-visual reveal" style="transition-delay:.1s">
        <div class="qm">"</div>
        <blockquote>{{ setting_t('why.quote') }}</blockquote>
        <div class="why-author">
          <div class="av">{{ mb_substr($s['why.authorName'] ?? 'A',0,1) }}</div>
          <div><strong>{{ $s['why.authorName'] ?? '' }}</strong><span>{{ setting_t('why.author') }}</span></div>
        </div>
        <div class="why-mini">
          <div><b>{{ $s['why.mini1v'] ?? '' }}</b><span>{{ setting_t('why.mini1') }}</span></div>
          <div><b>{{ $s['why.mini2v'] ?? '' }}</b><span>{{ setting_t('why.mini2') }}</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROCESS -->
  <section class="section process" id="process">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg>
          <span>{{ setting_t('process.eyebrow') }}</span>
        </span>
        <h2 class="heading">{{ setting_t('process.title') }}</h2>
        <p class="lead">{{ setting_t('process.lead') }}</p>
      </div>
      <div class="proc-grid">
        @foreach($steps as $i => $st)
        <div class="proc reveal" style="transition-delay:{{ $i*.06 }}s">
          <div class="proc-num">{{ $st->number }}</div>
          <h3>{{ t($st, 'title') }}</h3>
          <p>{{ t($st, 'desc') }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- PORTFOLIO -->
  <section class="section" id="portfolio">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18v13H3z"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          <span>{{ setting_t('pf.eyebrow') }}</span>
        </span>
        <h2 class="heading">{{ setting_t('pf.title') }}</h2>
        <p class="lead">{{ setting_t('pf.lead') }}</p>
      </div>
      <div class="pf-grid">
        @foreach($portfolio as $p)
        <article class="pf pf-{{ $p->size }} reveal">
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
      <div class="center" style="margin-top:40px">
        <a href="{{ route('portfolio.index') }}" class="btn btn-line">{{ site_locale() === 'en' ? 'View All Portfolio' : 'Lihat Semua Portofolio' }}</a>
      </div>
    </div>
  </section>

  <!-- TECH -->
  <section class="section tech" id="tech">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg>
          <span>{{ setting_t('tech.eyebrow') }}</span>
        </span>
        <h2 class="heading">{{ setting_t('tech.title') }}</h2>
        <p class="lead">{{ setting_t('tech.lead') }}</p>
      </div>
      <div class="tech-grid">
        @foreach($tech as $i => $tc)
        <div class="tech-card reveal" style="transition-delay:{{ $i*.05 }}s">
          <div class="ic">{!! \App\Support\Icons::get($tc->icon) !!}</div>
          <h3>{{ t($tc, 'title') }}</h3>
          <div class="pills">@foreach(($tc->pills ?? []) as $pill)<span>{{ $pill }}</span>@endforeach</div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  @php
    $avgRating = $testimonials->count() ? round($testimonials->avg('rating'), 1) : 5;
  @endphp
  <section class="section tprem-section" id="testimonials">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          <span>{{ setting_t('testi.eyebrow') }}</span>
        </span>
        <h2 class="heading">{{ setting_t('testi.title') }}</h2>
        <p class="lead">{{ setting_t('testi.lead') }}</p>

        <div class="tprem-summary reveal">
          <div class="tprem-summary-stars">{{ str_repeat('★', 5) }}</div>
          <div class="tprem-summary-text">
            <b>{{ number_format($avgRating, 1) }}</b>/5.0
            <span>{{ site_locale() === 'en' ? 'from' : 'dari' }} {{ $testimonials->count() }}+ {{ site_locale() === 'en' ? 'happy clients' : 'klien puas' }}</span>
          </div>
        </div>
      </div>

      <div class="tprem-grid">
        @foreach($testimonials as $i => $tm)
        <figure class="tprem-card reveal" style="transition-delay:{{ $i*.07 }}s">
          <span class="tprem-mark">&ldquo;</span>
          <div class="tprem-stars">{{ str_repeat('★', $tm->rating) }}{!! str_repeat('<span class="dim">★</span>', max(0, 5 - $tm->rating)) !!}</div>
          <blockquote class="tprem-text">{{ trim(t($tm, 'quote'), '"“”') }}</blockquote>
          <figcaption class="tprem-user">
            <span class="tprem-av" style="background:{{ $tm->gradient }}">{{ $tm->avatar_letter }}</span>
            <span class="tprem-meta">
              <strong>{{ $tm->name }}
                <svg class="tprem-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5L16 9"/></svg>
              </strong>
              <span>{{ t($tm, 'role') }}</span>
            </span>
          </figcaption>
        </figure>
        @endforeach
      </div>
    </div>
  </section>

  @push('styles')
  <style>
    .tprem-section{position:relative;overflow:hidden}
    .tprem-section::before{content:"";position:absolute;inset:0;z-index:-1;background:radial-gradient(680px 380px at 50% -6%,rgba(37,99,235,.07),transparent 60%)}
    .tprem-summary{display:inline-flex;align-items:center;gap:14px;margin-top:24px;padding:10px 18px;background:#fff;border:1px solid var(--line);border-radius:99px;box-shadow:var(--shadow-sm)}
    .tprem-summary-stars{color:#f5b50a;letter-spacing:2px;font-size:15px}
    .tprem-summary-text{font-size:14px;color:var(--muted)}
    .tprem-summary-text b{font-family:var(--display);font-size:17px;color:var(--ink)}
    .tprem-summary-text span{display:inline-block;margin-left:6px;padding-left:10px;border-left:1px solid var(--line-2)}
    .tprem-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:54px}
    .tprem-card{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:34px 30px 28px;box-shadow:var(--shadow-sm);transition:var(--t);overflow:hidden}
    .tprem-card::after{content:"";position:absolute;inset:0 0 auto 0;height:4px;background:linear-gradient(90deg,var(--brand),var(--sky));transform:scaleX(0);transform-origin:left;transition:transform .5s var(--ease)}
    .tprem-card:hover{transform:translateY(-8px);box-shadow:var(--shadow-lg);border-color:var(--brand-tint-2)}
    .tprem-card:hover::after{transform:scaleX(1)}
    .tprem-mark{position:absolute;top:14px;right:26px;font-family:var(--display);font-weight:700;font-size:88px;line-height:1;color:var(--brand-tint);pointer-events:none;transition:var(--t)}
    .tprem-card:hover .tprem-mark{color:var(--brand-tint-2)}
    .tprem-stars{position:relative;z-index:1;color:#f5b50a;letter-spacing:2px;font-size:16px;margin-bottom:16px}
    .tprem-stars .dim{color:var(--line-2)}
    .tprem-text{position:relative;z-index:1;font-size:16px;line-height:1.78;color:var(--ink-2);margin-bottom:24px;font-style:normal}
    .tprem-user{display:flex;align-items:center;gap:14px;padding-top:20px;border-top:1px solid var(--line)}
    .tprem-av{width:52px;height:52px;border-radius:50%;display:grid;place-items:center;font-family:var(--display);font-weight:700;color:#fff;font-size:18px;flex-shrink:0;box-shadow:0 0 0 3px #fff,0 0 0 5px var(--brand-tint-2)}
    .tprem-meta{display:flex;flex-direction:column;min-width:0}
    .tprem-meta strong{display:inline-flex;align-items:center;gap:6px;font-family:var(--display);font-size:15px;color:var(--ink)}
    .tprem-check{width:15px;height:15px;color:var(--brand);flex-shrink:0}
    .tprem-meta span{font-size:13px;color:var(--muted)}
    @media (max-width:920px){.tprem-grid{grid-template-columns:1fr 1fr}}
    @media (max-width:640px){.tprem-grid{grid-template-columns:1fr}.tprem-summary{flex-wrap:wrap;justify-content:center}}
  </style>
  @endpush

  <!-- FAQ -->
  <section class="section faq" id="faq">
    <div class="wrap">
      <div class="sec-head center reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12" y2="17"/></svg>
          <span>FAQ</span>
        </span>
        <h2 class="heading">{{ setting_t('faq.title') }}</h2>
        <p class="lead">{{ setting_t('faq.lead') }}</p>
      </div>
      <div class="faq-wrap">
        @foreach($faqs->take(6) as $i => $fq)
        <div class="faq-item {{ $i === 0 ? 'open' : '' }} reveal">
          <button class="faq-q"><h3>{{ t($fq, 'question') }}</h3><span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
          <div class="faq-a"><div>{{ t($fq, 'answer') }}</div></div>
        </div>
        @endforeach
      </div>
      <div class="center" style="margin-top:32px">
        <a href="{{ route('faq.index') }}" class="btn btn-line">{{ site_locale() === 'en' ? 'View All FAQ' : 'Lihat Semua FAQ' }}</a>
      </div>
    </div>
  </section>

  <!-- CTA / CONTACT -->
  <section class="section" id="contact">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <span class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4z"/></svg>
          <span>{{ setting_t('contact.eyebrow') }}</span>
        </span>
        <h2>{{ setting_t('contact.title') }}</h2>
        <p>{{ setting_t('contact.desc') }}</p>
        <div class="cta-actions">
          <a href="{{ route('order.create') }}" class="btn btn-light">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
            <span>{{ setting_t('contact.cta1') }}</span>
          </a>
          <a href="{{ $wa }}" class="btn btn-outline-light">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-12.2 7.5L3 21l2-5.8A8.5 8.5 0 1 1 21 11.5z"/></svg>
            <span>{{ setting_t('contact.cta2') }}</span>
          </a>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
@if($heroSlides->count() > 1)
<script>
  (function(){
    const slides = document.querySelectorAll('#hero-slides .hero-slide');
    const dots = document.querySelectorAll('#hero-dots .hero-dot');
    let current = 0;
    let timer;

    function show(index){
      current = (index + slides.length) % slides.length;
      slides.forEach((s, i) => s.classList.toggle('active', i === current));
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function restart(){ clearInterval(timer); timer = setInterval(() => show(current + 1), 6000); }

    document.getElementById('hero-next')?.addEventListener('click', () => { show(current + 1); restart(); });
    document.getElementById('hero-prev')?.addEventListener('click', () => { show(current - 1); restart(); });
    dots.forEach((d, i) => d.addEventListener('click', () => { show(i); restart(); }));

    restart();
  })();
</script>
@endif

<script>
  (function(){
    const filterBar = document.getElementById('design-filter');
    if (!filterBar) return;
    const links = filterBar.querySelectorAll('a');
    const cards = document.querySelectorAll('#design-grid .tpl-card');

    links.forEach(link => link.addEventListener('click', (e) => {
      e.preventDefault();
      const filter = link.getAttribute('data-filter');
      links.forEach(l => l.classList.toggle('active', l === link));
      cards.forEach(card => {
        card.style.display = (filter === 'all' || card.getAttribute('data-category') === filter) ? '' : 'none';
      });
    }));
  })();
</script>
@endpush
