@extends('layouts.app')

@php
  $en = site_locale() === 'en';
  $content = trim((string) t($post, 'content'));
  $paras = array_values(array_filter(preg_split('/\n+/', $content), fn ($p) => trim($p) !== ''));
  $words = max(1, str_word_count(strip_tags($content)));
  $readMin = max(1, (int) ceil($words / 200));
  $initial = strtoupper(mb_substr($post->author ?: 'C', 0, 1));
  $url = route('blog.show', $post->slug);
  $shareText = rawurlencode(t($post, 'title').' — '.$url);
@endphp

@section('title', t($post, 'title').' — '.$brand.' '.$suffix)
@section('description', t($post, 'excerpt'))

@push('styles')
<style>
  .reading-bar{position:fixed;top:0;left:0;height:3px;width:0;z-index:200;background:linear-gradient(90deg,var(--brand),var(--sky));transition:width .1s linear}
  .article-hero{position:relative;padding:calc(var(--nav-h) + 56px) 0 40px;overflow:hidden}
  .article-hero::before{content:"";position:absolute;inset:0;z-index:-2;background:radial-gradient(820px 440px at 80% -10%,rgba(56,189,248,.14),transparent 60%),radial-gradient(680px 460px at 6% 0%,rgba(37,99,235,.10),transparent 58%),linear-gradient(180deg,var(--soft) 0%,#fff 70%)}
  .article-wrap{width:min(100% - 40px,760px);margin-inline:auto}
  .article-cat{display:inline-flex;align-items:center;gap:8px;font-family:var(--display);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--brand-d);background:var(--brand-tint);border:1px solid var(--brand-tint-2);padding:7px 14px;border-radius:99px;margin-bottom:20px}
  .article-title{font-size:clamp(30px,5vw,50px);line-height:1.1;letter-spacing:-.03em;margin-bottom:18px}
  .article-excerpt{font-size:clamp(17px,2vw,20px);color:var(--body);line-height:1.6;margin-bottom:28px}
  .article-meta{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
  .article-meta .av{width:48px;height:48px;border-radius:50%;display:grid;place-items:center;font-family:var(--display);font-weight:700;color:#fff;font-size:18px;background:linear-gradient(135deg,var(--brand-l),var(--brand-d))}
  .article-meta .who strong{display:block;font-family:var(--display);font-size:15px;color:var(--ink)}
  .article-meta .who span{font-size:13px;color:var(--muted)}
  .article-meta .sep{width:5px;height:5px;border-radius:50%;background:var(--line-2)}
  .article-cover{width:min(100% - 40px,980px);margin:0 auto 8px;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg);border:1px solid var(--line);aspect-ratio:16/8;background:var(--soft-2)}
  .article-cover img{width:100%;height:100%;object-fit:cover;display:block}
  .article-layout{position:relative;display:grid;grid-template-columns:64px minmax(0,1fr);gap:32px;width:min(100% - 40px,860px);margin-inline:auto}
  .share-rail{position:sticky;top:calc(var(--nav-h) + 24px);align-self:start;display:flex;flex-direction:column;gap:10px}
  .share-rail span.lbl{font-family:var(--display);font-size:10.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);writing-mode:vertical-rl;margin:0 auto 4px}
  .share-btn{width:44px;height:44px;border-radius:12px;display:grid;place-items:center;background:#fff;border:1px solid var(--line-2);color:var(--ink-2);box-shadow:var(--shadow-sm);transition:var(--t);cursor:pointer}
  .share-btn:hover{color:#fff;background:var(--brand);border-color:var(--brand);transform:translateY(-2px)}
  .share-btn svg{width:19px;height:19px}
  .article-body{font-size:17.5px;line-height:1.9;color:var(--ink-2)}
  .article-body p{margin-bottom:24px}
  .article-body p:first-of-type::first-letter{font-family:var(--display);font-weight:700;font-size:64px;line-height:.8;float:left;margin:6px 14px 0 0;color:var(--brand-d)}
  .article-body h2{font-size:26px;margin:40px 0 14px}
  .article-body h3{font-size:21px;margin:32px 0 12px}
  .article-body a{color:var(--brand-d);font-weight:600;text-decoration:underline;text-underline-offset:3px}
  .article-body blockquote{border-left:3px solid var(--brand);background:var(--soft);padding:18px 24px;border-radius:0 14px 14px 0;font-family:var(--display);font-size:19px;color:var(--ink);margin:28px 0;font-style:italic}
  .tags-row{display:flex;flex-wrap:wrap;gap:8px;margin-top:36px;padding-top:28px;border-top:1px solid var(--line)}
  .author-box{display:flex;gap:18px;align-items:flex-start;background:var(--soft);border:1px solid var(--line);border-radius:var(--radius-lg);padding:28px;margin-top:36px}
  .author-box .av{width:64px;height:64px;border-radius:50%;flex-shrink:0;display:grid;place-items:center;font-family:var(--display);font-weight:700;color:#fff;font-size:24px;background:linear-gradient(135deg,var(--brand-l),var(--brand-d))}
  .author-box h4{font-size:18px;margin-bottom:4px}
  .author-box p{font-size:14.5px;color:var(--body);margin:0}
  .share-bottom{display:flex;align-items:center;gap:10px;margin-top:28px}
  .share-bottom .share-btn{width:42px;height:42px}
  #copy-toast{position:fixed;left:50%;bottom:30px;transform:translateX(-50%) translateY(20px);background:var(--ink);color:#fff;font-size:14px;padding:12px 20px;border-radius:12px;box-shadow:var(--shadow-lg);opacity:0;visibility:hidden;transition:var(--t);z-index:210}
  #copy-toast.show{opacity:1;visibility:visible;transform:translateX(-50%) translateY(0)}
  @media(max-width:760px){
    .article-layout{grid-template-columns:1fr;gap:0}
    .share-rail{display:none}
  }
</style>
@endpush

@section('content')
  <div class="reading-bar" id="reading-bar"></div>

  <article>
    <header class="article-hero">
      <div class="article-wrap reveal">
        <div class="breadcrumb"><a href="{{ route('blog.index') }}">Blog</a><span>/</span><span>{{ $en ? 'Article' : 'Artikel' }}</span></div>
        @if($post->category)
        <span class="article-cat">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v12H5.2L4 17.2V4z"/></svg>
          {{ t($post->category, 'name') }}
        </span>
        @endif
        <h1 class="article-title">{{ t($post, 'title') }}</h1>
        <p class="article-excerpt">{{ t($post, 'excerpt') }}</p>
        <div class="article-meta">
          <div class="av">{{ $initial }}</div>
          <div class="who">
            <strong>{{ $post->author ?: $brand }}</strong>
            <span>{{ $post->published_at?->translatedFormat('d F Y') }}</span>
          </div>
          <span class="sep"></span>
          <div class="who"><span>{{ $readMin }} {{ $en ? 'min read' : 'menit baca' }}</span></div>
        </div>
      </div>
    </header>

    @if($post->cover_image)
    <figure class="article-cover reveal">
      <img src="{{ asset('storage/'.$post->cover_image) }}" alt="{{ t($post, 'title') }}">
    </figure>
    @endif

    <div class="section" style="padding-top:48px">
      <div class="article-layout">
        {{-- sticky share rail --}}
        <aside class="share-rail">
          <span class="lbl">{{ $en ? 'Share' : 'Bagikan' }}</span>
          <a class="share-btn" href="https://wa.me/?text={{ $shareText }}" target="_blank" rel="noopener" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38c1.45.79 3.08 1.21 4.79 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm5.8 14.16c-.24.68-1.42 1.32-1.95 1.36-.5.05-.99.23-3.35-.7-2.82-1.11-4.6-3.97-4.74-4.16-.14-.19-1.13-1.5-1.13-2.86 0-1.36.71-2.03.97-2.31.24-.26.53-.33.71-.33h.51c.16 0 .39-.06.6.46.24.56.81 1.96.88 2.1.07.14.12.31.02.5-.1.19-.15.31-.29.48-.14.17-.3.38-.43.51-.14.14-.29.29-.12.57.17.28.74 1.22 1.59 1.98 1.1.98 2.02 1.28 2.3 1.42.28.14.45.12.61-.07.16-.19.7-.82.89-1.1.19-.28.37-.23.62-.14.25.09 1.6.76 1.87.9.28.14.46.21.53.33.07.12.07.66-.17 1.34z"/></svg>
          </a>
          <a class="share-btn" href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($url) }}" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12z"/></svg>
          </a>
          <a class="share-btn" href="https://twitter.com/intent/tweet?text={{ $shareText }}" target="_blank" rel="noopener" aria-label="X">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24h-6.66l-5.22-6.82-5.97 6.82H1.66l7.73-8.84L1.25 2.25H8.1l4.71 6.23 5.43-6.23zm-1.16 17.52h1.83L7.01 4.13H5.04l12.04 15.64z"/></svg>
          </a>
          <button type="button" class="share-btn" id="copy-link" aria-label="{{ $en ? 'Copy link' : 'Salin tautan' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          </button>
        </aside>

        {{-- article body --}}
        <div>
          <div class="article-body reveal">
            @forelse($paras as $p)
            <p>{!! nl2br(e($p)) !!}</p>
            @empty
            <p>{{ $en ? 'Content coming soon.' : 'Konten segera hadir.' }}</p>
            @endforelse
          </div>

          @if($post->category)
          <div class="tags-row reveal">
            <span class="tag">#{{ Str::slug(t($post->category, 'name')) }}</span>
            <span class="tag">#{{ Str::slug($brand) }}</span>
          </div>
          @endif

          {{-- mobile/bottom share --}}
          <div class="share-bottom reveal">
            <span class="muted" style="font-size:13.5px;font-weight:600">{{ $en ? 'Share this article:' : 'Bagikan artikel ini:' }}</span>
            <a class="share-btn" href="https://wa.me/?text={{ $shareText }}" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38c1.45.79 3.08 1.21 4.79 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg></a>
            <a class="share-btn" href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($url) }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12z"/></svg></a>
            <button type="button" class="share-btn" onclick="document.getElementById('copy-link').click()" aria-label="{{ $en ? 'Copy link' : 'Salin tautan' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg></button>
          </div>

          {{-- author box --}}
          <div class="author-box reveal">
            <div class="av">{{ $initial }}</div>
            <div>
              <h4>{{ $post->author ?: $brand }}</h4>
              <p>{{ $en ? 'Part of the '.$brand.' team — sharing insights to help Indonesian businesses grow online.' : 'Bagian dari tim '.$brand.' — berbagi wawasan untuk membantu bisnis Indonesia tumbuh secara digital.' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  {{-- CTA --}}
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="cta-wrap reveal">
        <span class="eyebrow">{{ $en ? 'Ready to grow?' : 'Siap bertumbuh?' }}</span>
        <h2>{{ $en ? 'Turn this idea into your own website' : 'Wujudkan ide ini jadi website Anda' }}</h2>
        <p>{{ $en ? 'Domain, hosting, SSL, and a fully built site — all in one transparent package.' : 'Domain, hosting, SSL, dan website jadi — semua dalam satu paket transparan.' }}</p>
        <div class="cta-actions">
          <a href="{{ route('order-wizard.start') }}" class="btn btn-light">{{ $en ? 'Start now' : 'Mulai sekarang' }}</a>
          <a href="{{ route('pricing.index') }}" class="btn btn-outline-light">{{ $en ? 'See pricing' : 'Lihat harga' }}</a>
        </div>
      </div>
    </div>
  </section>

  @if($related->count())
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head center reveal"><h2 class="heading">{{ $en ? 'More Articles' : 'Artikel Lainnya' }}</h2></div>
      <div class="grid-3">
        @foreach($related as $r)
        <article class="blog-card reveal">
          <a href="{{ route('blog.show', $r->slug) }}"><div class="blog-thumb" @if($r->cover_image) style="background-image:url('{{ asset('storage/'.$r->cover_image) }}')" @endif></div></a>
          <div class="blog-body">
            @if($r->category)<span class="cat">{{ t($r->category, 'name') }}</span>@endif
            <h3><a href="{{ route('blog.show', $r->slug) }}">{{ t($r, 'title') }}</a></h3>
            <p>{{ t($r, 'excerpt') }}</p>
            <div class="blog-meta">{{ $r->author }} · {{ $r->published_at?->translatedFormat('d M Y') }}</div>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <div id="copy-toast">{{ $en ? 'Link copied!' : 'Tautan disalin!' }}</div>

  @push('scripts')
  <script>
    // reading progress bar
    const bar = document.getElementById('reading-bar');
    const articleEl = document.querySelector('.article-body');
    function updateBar(){
      if(!articleEl) return;
      const start = articleEl.offsetTop;
      const end = start + articleEl.offsetHeight - window.innerHeight;
      const pct = Math.min(100, Math.max(0, ((window.scrollY - start) / (end - start)) * 100));
      bar.style.width = pct + '%';
    }
    window.addEventListener('scroll', updateBar, {passive:true});
    window.addEventListener('resize', updateBar); updateBar();

    // copy link
    const copyBtn = document.getElementById('copy-link');
    const toast = document.getElementById('copy-toast');
    if(copyBtn){
      copyBtn.addEventListener('click', async () => {
        try { await navigator.clipboard.writeText(@json($url)); }
        catch(e){ const t=document.createElement('input'); t.value=@json($url); document.body.appendChild(t); t.select(); document.execCommand('copy'); t.remove(); }
        toast.classList.add('show');
        setTimeout(()=>toast.classList.remove('show'), 1800);
      });
    }
  </script>
  @endpush
@endsection
