@extends('layouts.app')

@php
$en = site_locale() === 'en';
$featured = $posts->first();
$rest = $posts->slice(1);
@endphp

@section('title', ($en ? 'Blog — Digital Growth Tips — '.$brand.' '.$suffix : 'Blog & Tips Digital untuk Bisnis — '.$brand.' '.$suffix))
@section('description', $en ? 'Insights, tips, and trends on websites, digitalization, and online business growth from ConWeb ID.' : 'Wawasan, tips, dan tren seputar website, digitalisasi, dan pertumbuhan bisnis online dari ConWeb ID.')

@push('styles')
<style>
  .blog-feat{display:grid;grid-template-columns:1.1fr .9fr;align-items:stretch}
  @media(max-width:820px){.blog-feat{grid-template-columns:1fr}.blog-feat .blog-thumb{min-height:220px}.blog-feat .blog-body{padding:28px}}
</style>
@endpush

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('home') }}">{{ $en ? 'Home' : 'Beranda' }}</a><span>/</span><span>Blog</span></div>
      <span class="eyebrow">{{ $en ? 'Journal' : 'Jurnal' }}</span>
      <h1>{{ $en ? 'Insights on digital growth' : 'Wawasan seputar pertumbuhan digital' }}</h1>
      <p>{{ $en ? 'Tips, trends, and stories to help your business grow online.' : 'Tips, tren, dan cerita untuk membantu bisnis Anda tumbuh secara digital.' }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      @if($featured)
      {{-- featured post --}}
      <a href="{{ route('blog.show', $featured->slug) }}" class="blog-card blog-feat reveal" style="margin-bottom:48px">
        <div class="blog-thumb" style="height:100%;min-height:320px;@if($featured->cover_image)background-image:url('{{ asset('storage/'.$featured->cover_image) }}')@endif"></div>
        <div class="blog-body" style="padding:40px;display:flex;flex-direction:column;justify-content:center">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
            <span class="tag"><span class="dot"></span>{{ $en ? 'Featured' : 'Unggulan' }}</span>
            @if($featured->category)<span class="cat">{{ t($featured->category, 'name') }}</span>@endif
          </div>
          <h3 style="font-size:clamp(22px,3vw,30px);margin:0 0 12px">{{ t($featured, 'title') }}</h3>
          <p style="font-size:15.5px;margin-bottom:18px">{{ t($featured, 'excerpt') }}</p>
          <div class="blog-meta">{{ $featured->author }} · {{ $featured->published_at?->translatedFormat('d M Y') }}</div>
          <span class="svc-more" style="margin-top:18px">{{ $en ? 'Read article' : 'Baca artikel' }} <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        </div>
      </a>
      @endif

      @if($categories->count())
      <div class="filter-row reveal" id="blog-filter">
        <a href="#" class="active" data-cat="all">{{ $en ? 'All' : 'Semua' }}</a>
        @foreach($categories as $c)
        <a href="#" data-cat="{{ t($c, 'name') }}">{{ t($c, 'name') }}</a>
        @endforeach
      </div>
      @endif

      <div class="grid-3" id="blog-grid">
        @forelse($rest as $post)
        <article class="blog-card reveal" data-cat="{{ $post->category ? t($post->category, 'name') : '' }}">
          <a href="{{ route('blog.show', $post->slug) }}">
            <div class="blog-thumb" @if($post->cover_image) style="background-image:url('{{ asset('storage/'.$post->cover_image) }}')" @endif></div>
          </a>
          <div class="blog-body">
            @if($post->category)<span class="cat">{{ t($post->category, 'name') }}</span>@endif
            <h3><a href="{{ route('blog.show', $post->slug) }}">{{ t($post, 'title') }}</a></h3>
            <p>{{ t($post, 'excerpt') }}</p>
            <div class="blog-meta">{{ $post->author }} · {{ $post->published_at?->translatedFormat('d M Y') }}</div>
          </div>
        </article>
        @empty
        @if(!$featured)
        <p>{{ $en ? 'No articles yet.' : 'Belum ada artikel.' }}</p>
        @endif
        @endforelse
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <span class="eyebrow">{{ $en ? 'Stay in the loop' : 'Tetap terhubung' }}</span>
        <h2>{{ $en ? 'Ideas worth your inbox' : 'Wawasan yang layak Anda simak' }}</h2>
        <p>{{ $en ? 'Have a topic you’d like us to cover? Reach out and let’s talk.' : 'Ada topik yang ingin kami bahas? Hubungi kami dan mari berdiskusi.' }}</p>
        <div class="cta-actions">
          <a href="{{ $wa }}" class="btn btn-light">{{ $en ? 'Chat on WhatsApp' : 'Chat via WhatsApp' }}</a>
        </div>
      </div>
    </div>
  </section>

  @push('scripts')
  <script>
    const blogFilter = document.getElementById('blog-filter');
    if (blogFilter) {
      blogFilter.addEventListener('click', e => {
        const link = e.target.closest('a'); if (!link) return;
        e.preventDefault();
        blogFilter.querySelectorAll('a').forEach(a => a.classList.remove('active'));
        link.classList.add('active');
        const cat = link.dataset.cat;
        document.querySelectorAll('#blog-grid .blog-card').forEach(card => {
          card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
        });
      });
    }
  </script>
  @endpush
@endsection
