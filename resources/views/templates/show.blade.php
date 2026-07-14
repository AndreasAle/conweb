@extends('layouts.app')

@section('title', $template->name.' — '.(site_locale() === 'en' ? 'Template Preview' : 'Preview Template'))

@php
  $en = site_locale() === 'en';
  $hasThumb = (bool) $template->thumbnail;
  $includes = $en
    ? ['Full setup by Conweb team', 'Domain + hosting + SSL (1 year)', 'Responsive on all devices', 'Basic SEO & speed optimization', 'Content tailored to your business', 'Project guidance until live']
    : ['Pengerjaan penuh oleh tim Conweb', 'Domain + hosting + SSL (1 tahun)', 'Responsif di semua perangkat', 'Optimasi SEO & kecepatan dasar', 'Konten disesuaikan dengan bisnismu', 'Pendampingan project sampai live'];
@endphp

@if($template->chatbot_enabled)
@php $bizName = $template->chatbot_business_name ?: $template->name; @endphp
@push('chat-config')
<script>
  window.__CW_CONFIG__ = {
    template: @json($template->slug),
    title: @json($bizName),
    status: @json(($en ? 'Assistant' : 'Asisten').' '.$bizName.' · online'),
    greetingTitle: @json(($en ? 'Hi! Welcome to ' : 'Hai! Selamat datang di ').$bizName.' 👋'),
    greeting: @json($template->chatbot_greeting ?: ($en
        ? 'Ask me anything about our products, prices, hours, or how to order.'
        : 'Tanya apa saja soal produk, harga, jam buka, atau cara pesan ya.')),
    chips: @json($en
        ? ['What do you offer?', 'What are the prices?', 'Opening hours?', 'How to order?']
        : ['Ada produk/menu apa?', 'Berapa harganya?', 'Jam buka?', 'Cara pesan?'])
  };
</script>
@endpush
@endif

@push('styles')
<style>
  .td-hero{position:relative;padding:calc(var(--nav-h) + 40px) 0 50px;overflow:hidden;
    background:radial-gradient(1100px 480px at 78% -10%, var(--brand-tint-2), transparent 60%), var(--soft)}
  .td-hero::before{content:"";position:absolute;inset:0;
    background:linear-gradient(135deg,{{ $template->primary_color }}14,{{ $template->secondary_color }}08);pointer-events:none}
  .td-hero .wrap{position:relative}
  .td-crumb{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted);margin-bottom:22px}
  .td-crumb a{color:var(--muted);transition:.2s}
  .td-crumb a:hover{color:var(--brand)}
  .td-crumb svg{width:14px;height:14px}

  .td-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center}
  .td-info .eyebrow{margin-bottom:16px}
  .td-info h1{font-size:clamp(30px,4.2vw,46px);line-height:1.08;color:var(--ink);letter-spacing:-.5px}
  .td-info .tagline{font-size:16px;color:var(--body);margin-top:14px;max-width:46ch}
  .td-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-top:22px}
  .td-pill{display:inline-flex;align-items:center;gap:7px;font-size:13px;font-weight:600;padding:8px 14px;
    border-radius:999px;background:var(--bg);border:1px solid var(--line-2);color:var(--ink-2)}
  .td-pill svg{width:15px;height:15px;color:var(--brand)}
  .td-pill.price{background:var(--brand);border-color:var(--brand);color:#fff}
  .td-cta{display:flex;gap:12px;flex-wrap:wrap;margin-top:30px}

  /* Device mockup */
  .td-device{position:relative;border-radius:22px;overflow:hidden;box-shadow:var(--shadow-lg);
    border:1px solid var(--line);background:#fff;transform:perspective(1400px) rotateY(-4deg) rotateX(1.5deg);
    transition:transform .5s var(--ease)}
  .td-device:hover{transform:perspective(1400px) rotateY(0) rotateX(0)}
  .td-device-bar{display:flex;align-items:center;gap:7px;padding:11px 14px;background:var(--soft);border-bottom:1px solid var(--line)}
  .td-device-bar i{width:9px;height:9px;border-radius:50%}
  .td-device-bar i:nth-child(1){background:#ff6058}.td-device-bar i:nth-child(2){background:#febc2e}.td-device-bar i:nth-child(3){background:#28c840}
  .td-device-shot{aspect-ratio:16/11;
    background:linear-gradient(150deg,{{ $template->primary_color }},{{ $template->secondary_color }} 150%)}
  .td-device-shot.has-img{background-image:url('{{ $hasThumb ? asset('storage/'.$template->thumbnail) : '' }}');
    background-size:contain;background-position:center;background-repeat:no-repeat}
  .td-device-glow{position:absolute;inset:auto -40px -60px -40px;height:120px;filter:blur(50px);opacity:.5;
    background:linear-gradient(90deg,{{ $template->primary_color }},{{ $template->secondary_color }});z-index:-1}

  /* Live preview */
  .td-preview{padding:64px 0;background:var(--bg)}
  .td-sec-head{text-align:center;max-width:560px;margin:0 auto 34px}
  .td-sec-head h2{font-size:clamp(24px,3vw,32px);color:var(--ink)}
  .td-sec-head p{color:var(--body);margin-top:8px}
  .td-frame{max-width:1140px;margin-inline:auto;border-radius:20px;overflow:hidden;box-shadow:var(--shadow-lg);border:1px solid var(--line);background:#fff}
  .td-frame-bar{display:flex;align-items:center;gap:8px;padding:12px 16px;border-bottom:1px solid var(--line);background:var(--soft)}
  .td-frame-bar i{width:10px;height:10px;border-radius:50%;background:#dbe3f2}
  .td-frame-bar i:nth-child(1){background:#ff6058}.td-frame-bar i:nth-child(2){background:#febc2e}.td-frame-bar i:nth-child(3){background:#28c840}
  .td-frame-bar span{margin-left:8px;font-family:var(--display);font-size:12px;color:var(--muted);background:#fff;border:1px solid var(--line);border-radius:8px;padding:5px 12px;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
  .td-frame iframe{width:100%;height:760px;border:0;display:block}
  .td-empty{padding:96px 40px;text-align:center;background:linear-gradient(150deg,{{ $template->secondary_color }},{{ $template->primary_color }} 160%);color:#fff}
  .td-empty .ic{width:60px;height:60px;border-radius:18px;display:grid;place-items:center;margin:0 auto 18px;background:rgba(255,255,255,.14)}
  .td-empty .ic svg{width:28px;height:28px}
  .td-empty h3{color:#fff;font-size:22px;margin-bottom:10px}
  .td-empty p{color:rgba(255,255,255,.85);max-width:440px;margin:0 auto 22px}
  .td-hint{text-align:center;font-size:13px;color:var(--muted);margin-top:14px}

  /* Includes */
  .td-includes{padding:64px 0;background:var(--soft)}
  .td-inc-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;max-width:860px;margin:0 auto}
  .td-inc{display:flex;align-items:flex-start;gap:12px;padding:18px 20px;background:var(--bg);border:1px solid var(--line);border-radius:var(--radius)}
  .td-inc .chk{flex:0 0 26px;width:26px;height:26px;border-radius:8px;display:grid;place-items:center;background:var(--brand-tint);color:var(--brand)}
  .td-inc .chk svg{width:15px;height:15px}
  .td-inc span{font-size:14.5px;color:var(--ink-2);font-weight:500;padding-top:2px}

  /* Related */
  .td-related{padding:64px 0;background:var(--bg)}

  /* Final CTA */
  .td-final{padding:30px 0 80px;background:var(--bg)}
  .td-final-card{position:relative;overflow:hidden;border-radius:var(--radius-lg);padding:54px 40px;text-align:center;
    background:linear-gradient(135deg,var(--navy),var(--navy-2));color:#fff;box-shadow:var(--shadow-lg)}
  .td-final-card::before{content:"";position:absolute;inset:0;background:radial-gradient(600px 280px at 80% 0,{{ $template->primary_color }}55,transparent 60%)}
  .td-final-card>*{position:relative}
  .td-final-card h2{color:#fff;font-size:clamp(24px,3vw,32px)}
  .td-final-card p{color:rgba(255,255,255,.82);max-width:480px;margin:10px auto 26px}

  @media (max-width:900px){
    .td-grid{grid-template-columns:1fr;gap:34px}
    .td-device{transform:none}
    .td-inc-grid{grid-template-columns:1fr}
    .td-frame iframe{height:560px}
  }
</style>
@endpush

@section('content')
  {{-- HERO --}}
  <section class="td-hero">
    <div class="wrap">
      <nav class="td-crumb reveal">
        <a href="{{ route('templates.index') }}">{{ $en ? 'Templates' : 'Template' }}</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        <span>{{ $template->category }}</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        <span style="color:var(--ink-2);font-weight:600">{{ $template->name }}</span>
      </nav>

      <div class="td-grid">
        <div class="td-info reveal">
          <span class="eyebrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
            <span>{{ $template->category }}{{ $template->is_featured ? ($en ? ' · Featured' : ' · Unggulan') : '' }}</span>
          </span>
          <h1>{{ $template->name }}</h1>
          @if(t($template, 'tagline'))<p class="tagline">{{ t($template, 'tagline') }}</p>@endif

          <div class="td-meta">
            @if($template->price_label || $template->price > 0)
            <span class="td-pill price">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
              {{ $template->price_label ?: 'Rp'.number_format((float) $template->price, 0, ',', '.') }}
            </span>
            @endif
            <span class="td-pill">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              {{ $template->popularity }} {{ $en ? 'chose this' : 'orang memilih' }}
            </span>
          </div>

          <div class="td-cta">
            <a href="{{ route('order-wizard.start', ['template' => $template->slug]) }}" class="btn btn-primary">
              <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
              {{ $en ? 'Choose & Order Now' : 'Pilih & Pesan Sekarang' }}
            </a>
            @if($template->preview_url)
            <a href="{{ $template->preview_url }}" target="_blank" rel="noopener" class="btn btn-line">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6M10 14 21 3"/></svg>
              {{ $en ? 'Open Live Demo' : 'Buka Demo Langsung' }}
            </a>
            @endif
          </div>
        </div>

        <div class="td-info-visual reveal">
          <div class="td-device">
            <div class="td-device-bar"><i></i><i></i><i></i></div>
            <div class="td-device-shot {{ $hasThumb ? 'has-img' : '' }}"></div>
          </div>
          <div class="td-device-glow"></div>
        </div>
      </div>
    </div>
  </section>

  {{-- LIVE PREVIEW --}}
  <section class="td-preview">
    <div class="wrap">
      <div class="td-sec-head reveal">
        <h2>{{ $en ? 'Live Preview' : 'Preview Langsung' }}</h2>
        <p>{{ $en ? 'See the design in action before you decide.' : 'Lihat tampilan desainnya langsung sebelum memutuskan.' }}</p>
      </div>

      @if($template->preview_url)
      <div class="td-frame reveal">
        <div class="td-frame-bar"><i></i><i></i><i></i><span>{{ $template->preview_url }}</span></div>
        <iframe src="{{ $template->preview_url }}" loading="lazy" referrerpolicy="no-referrer"></iframe>
      </div>
      <p class="td-hint">{{ $en ? "If the preview doesn't load, the site may block embedding — use \"Open Live Demo\" instead." : 'Jika preview tidak muncul, situs mungkin memblokir embed — gunakan tombol "Buka Demo Langsung".' }}</p>
      @else
      <div class="td-frame reveal">
        <div class="td-empty">
          <span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg></span>
          <h3>{{ $en ? 'Preview not available yet' : 'Preview belum tersedia' }}</h3>
          <p>{{ $en ? 'This template preview link has not been set up yet. Contact us for a live demo, or pick it and our team will walk you through it.' : 'Link preview untuk template ini belum diatur. Hubungi kami untuk demo langsung, atau pilih saja dan tim kami akan menunjukkannya.' }}</p>
          <a href="{{ route('order-wizard.start', ['template' => $template->slug]) }}" class="btn btn-light btn-sm">{{ $en ? 'Choose This Template' : 'Pilih Template Ini' }}</a>
        </div>
      </div>
      @endif
    </div>
  </section>

  {{-- INCLUDES --}}
  <section class="td-includes">
    <div class="wrap">
      <div class="td-sec-head reveal">
        <h2>{{ $en ? "What you get" : 'Yang kamu dapat' }}</h2>
        <p>{{ $en ? 'Every template comes fully handled by our team — not just a design file.' : 'Setiap template dikerjakan penuh oleh tim kami — bukan sekadar file desain.' }}</p>
      </div>
      <div class="td-inc-grid reveal">
        @foreach($includes as $item)
        <div class="td-inc">
          <span class="chk"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span>
          <span>{{ $item }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- RELATED --}}
  @if($related->isNotEmpty())
  <section class="td-related">
    <div class="wrap">
      <div class="td-sec-head reveal">
        <h2>{{ $en ? 'You might also like' : 'Mungkin kamu juga suka' }}</h2>
        <p>{{ $en ? 'Other templates that pair well with your business.' : 'Template lain yang cocok untuk bisnismu.' }}</p>
      </div>
      <div class="grid-3">
        @foreach($related as $tpl)
        <div class="tpl-card reveal">
          <div class="tpl-thumb" style="@if($tpl->thumbnail)background-image:url('{{ asset('storage/'.$tpl->thumbnail) }}')@else background:linear-gradient(135deg,{{ $tpl->primary_color }},{{ $tpl->secondary_color }})@endif">
            @if($tpl->is_featured)<span class="badge">{{ $en ? 'Featured' : 'Unggulan' }}</span>@endif
          </div>
          <div class="tpl-body">
            <span class="cat">{{ $tpl->category }}</span>
            <h3>{{ $tpl->name }}</h3>
            <p style="font-size:13.5px">{{ t($tpl, 'tagline') }}</p>
            <span class="price" style="display:block;margin-top:12px">{{ $tpl->price_label ?: ($tpl->popularity.' '.($en ? 'people chose this' : 'orang memilih ini')) }}</span>
            <div class="tpl-foot">
              <a href="{{ route('templates.show', $tpl->slug) }}" class="btn btn-sm btn-line">{{ $en ? 'Preview' : 'Lihat' }}</a>
              <a href="{{ route('order-wizard.start', ['template' => $tpl->slug]) }}" class="btn btn-sm btn-primary">{{ $en ? 'Choose' : 'Pilih' }}</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- FINAL CTA --}}
  <section class="td-final">
    <div class="wrap">
      <div class="td-final-card reveal">
        <h2>{{ $en ? 'Ready to launch with '.$template->name.'?' : 'Siap launching dengan '.$template->name.'?' }}</h2>
        <p>{{ $en ? 'Pick this template and our team handles the rest — design, content, domain, and hosting.' : 'Pilih template ini dan tim kami urus sisanya — desain, konten, domain, dan hosting.' }}</p>
        <a href="{{ route('order-wizard.start', ['template' => $template->slug]) }}" class="btn btn-light">{{ $en ? 'Choose This Template & Order Now' : 'Pilih Template Ini & Pesan Sekarang' }}</a>
      </div>
    </div>
  </section>
@endsection
