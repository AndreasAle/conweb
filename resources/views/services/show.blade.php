@extends('layouts.app')

@section('title', t($service, 'title').' — '.$brand.' '.$suffix)
@section('description', \Illuminate\Support\Str::limit(strip_tags(t($service, 'hero_subtitle') ?: t($service, 'desc') ?: ''), 155))

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('services.index') }}">{{ site_locale() === 'en' ? 'Services' : 'Layanan' }}</a> / {{ t($service, 'title') }}</div>
      <h1>{{ $service->hero_title_id ? t($service, 'hero_title') : t($service, 'title') }}</h1>
      <p>{{ $service->hero_subtitle_id ? t($service, 'hero_subtitle') : t($service, 'desc') }}</p>
      <div style="margin-top:24px"><a href="{{ route('order.create', ['service' => $service->slug]) }}" class="btn btn-primary">{{ site_locale() === 'en' ? 'Order Now' : 'Pesan Sekarang' }}</a></div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap" style="display:grid;grid-template-columns:1.4fr .8fr;gap:48px">
      <div class="reveal">
        @if($service->body_id)
        <div style="font-size:15.5px;line-height:1.8;color:var(--ink-2)">{!! nl2br(e(t($service, 'body'))) !!}</div>
        @else
        <p style="font-size:15.5px;line-height:1.8">{{ t($service, 'desc') }}</p>
        @endif
        <ul style="margin-top:24px;display:grid;gap:12px">
          @foreach(($service->features ?? []) as $f)
          <li style="display:flex;gap:11px;align-items:flex-start;font-size:14.5px;color:var(--ink-2)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:19px;height:19px;flex-shrink:0;color:var(--brand);margin-top:2px"><polyline points="20 6 9 17 4 12"/></svg><span>{{ $f[site_locale()] ?? '' }}</span></li>
          @endforeach
        </ul>
      </div>
      <div class="reveal">
        <div class="form-card" style="margin-inline:0">
          <div class="svc-ic" style="margin-bottom:16px">{!! \App\Support\Icons::get($service->icon) !!}</div>
          <h3 style="margin-bottom:10px">{{ site_locale() === 'en' ? 'Interested in this service?' : 'Tertarik dengan layanan ini?' }}</h3>
          <p style="font-size:14px;margin-bottom:20px">{{ site_locale() === 'en' ? 'Tell us your needs and we will reply via WhatsApp.' : 'Sampaikan kebutuhan Anda, kami balas via WhatsApp.' }}</p>
          <a href="{{ route('order.create', ['service' => $service->slug]) }}" class="btn btn-primary btn-block">{{ site_locale() === 'en' ? 'Order Now' : 'Pesan Sekarang' }}</a>
        </div>
      </div>
    </div>

    @if($others->count())
    <div class="wrap" style="margin-top:80px">
      <div class="sec-head center reveal">
        <h2 class="heading">{{ site_locale() === 'en' ? 'Other Services' : 'Layanan Lainnya' }}</h2>
      </div>
      <div class="grid-3">
        @foreach($others as $sv)
        <div class="svc reveal">
          <div class="svc-ic">{!! \App\Support\Icons::get($sv->icon) !!}</div>
          <h3>{{ t($sv, 'title') }}</h3>
          <p>{{ t($sv, 'desc') }}</p>
          @if($sv->slug)
          <a href="{{ route('services.show', $sv->slug) }}" class="svc-more">{{ site_locale() === 'en' ? 'Learn more' : 'Pelajari lebih lanjut' }} →</a>
          @endif
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </section>
@endsection
