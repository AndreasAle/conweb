@php
    $defaultMark = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="2.4"/><circle cx="5" cy="18" r="2.4"/><circle cx="19" cy="18" r="2.4"/><path d="M10.3 6.6 6.7 15.4M13.7 6.6l3.6 8.8M7.4 18h9.2"/></svg>';
    $navItems = [
        ['route' => 'templates.index', 'label_id' => 'Template', 'label_en' => 'Templates'],
        ['route' => 'services.index', 'label_id' => 'Layanan', 'label_en' => 'Services'],
        ['route' => 'pricing.index', 'label_id' => 'Paket', 'label_en' => 'Pricing'],
        ['route' => 'ecommerce.index', 'label_id' => 'Toko Online', 'label_en' => 'Online Store'],
        ['route' => 'portfolio.index', 'label_id' => 'Portofolio', 'label_en' => 'Portfolio'],
        ['route' => 'community.index', 'label_id' => 'Komunitas', 'label_en' => 'Community'],
        ['route' => 'blog.index', 'label_id' => 'Blog', 'label_en' => 'Blog'],
        ['route' => 'faq.index', 'label_id' => 'FAQ', 'label_en' => 'FAQ'],
    ];
@endphp
<nav class="nav" id="nav">
  <div class="wrap nav-in">
    <a href="{{ route('home') }}" class="logo">
      <span class="logo-mark">
        @if($logo)<img src="{{ asset('storage/'.$logo) }}" alt="{{ $brand }} Logo">@else{!! $defaultMark !!}@endif
      </span>
      {{ $brand }}<b>.</b>{{ $suffix }}
    </a>
    <div class="nav-links">
      @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}" class="{{ request()->routeIs($item['route'].'*') ? 'active' : '' }}">{{ site_locale() === 'en' ? $item['label_en'] : $item['label_id'] }}</a>
      @endforeach
    </div>
    <div class="nav-right">
      <div class="lang">
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}" class="{{ site_locale() === 'id' ? 'active' : '' }}">ID</a>
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="{{ site_locale() === 'en' ? 'active' : '' }}">EN</a>
      </div>
      @auth
      <a href="{{ route('account.index') }}" class="{{ request()->routeIs('account.*') ? 'active' : '' }}" style="font-size:14px;font-weight:600;color:var(--ink-2)">{{ site_locale() === 'en' ? 'My Account' : 'Akun Saya' }}</a>
      @else
      <a href="{{ route('login') }}" style="font-size:14px;font-weight:600;color:var(--ink-2)">{{ site_locale() === 'en' ? 'Sign in' : 'Masuk' }}</a>
      @endauth
      <a href="{{ route('order-wizard.start') }}" class="btn btn-primary">{{ site_locale() === 'en' ? 'Order Now' : 'Pesan Sekarang' }}</a>
      <button class="burger" id="burger" aria-label="Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
      </button>
    </div>
  </div>
</nav>

<div class="drawer" id="drawer">
  @foreach($navItems as $item)
    <a href="{{ route($item['route']) }}">{{ site_locale() === 'en' ? $item['label_en'] : $item['label_id'] }}</a>
  @endforeach
  @auth
  <a href="{{ route('account.index') }}">{{ site_locale() === 'en' ? 'My Account' : 'Akun Saya' }}</a>
  @else
  <a href="{{ route('login') }}">{{ site_locale() === 'en' ? 'Sign in' : 'Masuk' }}</a>
  @endauth
  <a href="{{ route('order-wizard.start') }}" class="btn btn-primary">{{ site_locale() === 'en' ? 'Order Now' : 'Pesan Sekarang' }}</a>
  <div class="drawer-lang">
    <a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}" class="{{ site_locale() === 'id' ? 'active' : '' }}">Indonesia</a>
    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="{{ site_locale() === 'en' ? 'active' : '' }}">English</a>
  </div>
</div>
