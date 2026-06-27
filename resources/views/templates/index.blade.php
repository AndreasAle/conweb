@extends('layouts.app')

@section('title', (site_locale() === 'en' ? 'Ready-Made Website Templates for Business — '.$brand.' '.$suffix : 'Template Website Siap Pakai untuk UMKM & Bisnis — '.$brand.' '.$suffix))
@section('description', site_locale() === 'en' ? 'Browse professional, ready-to-use website templates for SMEs and brands. Pick a design and launch fast with ConWeb ID.' : 'Pilih template website profesional siap pakai untuk UMKM & brand. Tinggal pilih desain dan tayang cepat bersama ConWeb ID.')

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <span class="eyebrow">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
        <span>{{ site_locale() === 'en' ? 'Design Collection' : 'Koleksi Desain' }}</span>
      </span>
      <h1>{{ site_locale() === 'en' ? 'Pick a template, preview it, go live' : 'Pilih template, preview, langsung jalan' }}</h1>
      <p>{{ site_locale() === 'en' ? 'Browse ready-made designs for export companies, SMEs, online stores, and corporates. Preview any template with sample content before you order.' : 'Jelajahi desain siap pakai untuk perusahaan ekspor, UMKM, toko online, dan korporat. Preview setiap template dengan konten contoh sebelum memesan.' }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="filter-row reveal">
        <a href="{{ route('templates.index') }}" class="{{ !$category ? 'active' : '' }}">{{ site_locale() === 'en' ? 'All' : 'Semua' }}</a>
        @foreach($categories as $cat)
        <a href="{{ route('templates.index', ['category' => $cat]) }}" class="{{ $category === $cat ? 'active' : '' }}">{{ $cat }}</a>
        @endforeach
      </div>

      <div class="grid-3">
        @forelse($templates as $tpl)
        <div class="tpl-card reveal">
          <div class="tpl-thumb" style="@if($tpl->thumbnail)background-image:url('{{ asset('storage/'.$tpl->thumbnail) }}')@else background:linear-gradient(135deg,{{ $tpl->primary_color }},{{ $tpl->secondary_color }})@endif">
            @if($tpl->is_featured)<span class="badge">{{ site_locale() === 'en' ? 'Featured' : 'Unggulan' }}</span>@endif
          </div>
          <div class="tpl-body">
            <span class="cat">{{ $tpl->category }}</span>
            <h3>{{ $tpl->name }}</h3>
            <p style="font-size:13.5px">{{ t($tpl, 'tagline') }}</p>
            <span class="price" style="display:block;margin-top:12px">{{ $tpl->price_label ?: ($tpl->popularity.' '.(site_locale() === 'en' ? 'people chose this' : 'orang memilih ini')) }}</span>
            <div class="tpl-foot">
              <a href="{{ route('templates.show', $tpl->slug) }}" class="btn btn-sm btn-line">{{ site_locale() === 'en' ? 'Preview' : 'Lihat' }}</a>
              <a href="{{ route('order-wizard.start', ['template' => $tpl->slug]) }}" class="btn btn-sm btn-primary">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                {{ site_locale() === 'en' ? 'Choose' : 'Pilih' }}
              </a>
            </div>
          </div>
        </div>
        @empty
        <p>{{ site_locale() === 'en' ? 'No templates yet.' : 'Belum ada template.' }}</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
