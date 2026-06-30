@php
    $defaultMark = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="2.4"/><circle cx="5" cy="18" r="2.4"/><circle cx="19" cy="18" r="2.4"/><path d="M10.3 6.6 6.7 15.4M13.7 6.6l3.6 8.8M7.4 18h9.2"/></svg>';
    $en = site_locale() === 'en';

    // Struktur menu: link tunggal atau dropdown bergrup. Mengurangi 8 menu sejajar
    // menjadi 5 item agar navbar tidak menumpuk. Semua route lama tetap dipakai.
    $caret = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>';

    $navMenu = [
        ['type' => 'dropdown', 'id' => 'Layanan', 'en' => 'Services', 'match' => ['services.*', 'templates.*'], 'children' => [
            ['route' => 'services.index',  'id' => 'Layanan Website', 'en' => 'Web Services', 'desc_id' => 'Website UMKM & company profile', 'desc_en' => 'UMKM & company profile sites'],
            ['route' => 'templates.index', 'id' => 'Template Website', 'en' => 'Templates',    'desc_id' => 'Pilih desain siap pakai',       'desc_en' => 'Ready-to-use designs'],
        ]],
        ['type' => 'link', 'route' => 'ecommerce.index', 'id' => 'Toko Online', 'en' => 'Online Store'],
        ['type' => 'link', 'route' => 'pricing.index',   'id' => 'Paket',       'en' => 'Pricing'],
        ['type' => 'link', 'route' => 'portfolio.index', 'id' => 'Portofolio',  'en' => 'Portfolio'],
        ['type' => 'dropdown', 'id' => 'Lainnya', 'en' => 'More', 'match' => ['community.*', 'blog.*', 'faq.*'], 'children' => [
            ['route' => 'community.index', 'id' => 'Komunitas', 'en' => 'Community', 'desc_id' => 'Belajar & berjejaring bareng UMKM', 'desc_en' => 'Learn & network with UMKM'],
            ['route' => 'blog.index',      'id' => 'Blog',      'en' => 'Blog',      'desc_id' => 'Tips & insight bisnis online',       'desc_en' => 'Online business tips & insight'],
            ['route' => 'faq.index',       'id' => 'FAQ',       'en' => 'FAQ',       'desc_id' => 'Pertanyaan yang sering diajukan',    'desc_en' => 'Frequently asked questions'],
        ]],
    ];

    $isGroupActive = function (array $patterns) {
        foreach ($patterns as $p) {
            if (request()->routeIs($p)) return true;
        }
        return false;
    };
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
      @foreach($navMenu as $item)
        @if($item['type'] === 'link')
          <a href="{{ route($item['route']) }}" class="{{ request()->routeIs($item['route'].'*') ? 'active' : '' }}">{{ $en ? $item['en'] : $item['id'] }}</a>
        @else
          <div class="nav-item">
            <button type="button" class="nav-dd-trigger {{ $isGroupActive($item['match']) ? 'active' : '' }}" aria-haspopup="true">
              {{ $en ? $item['en'] : $item['id'] }} {!! $caret !!}
            </button>
            <div class="nav-dd">
              @foreach($item['children'] as $child)
                <a href="{{ route($child['route']) }}">
                  <strong>{{ $en ? $child['en'] : $child['id'] }}</strong>
                  <span>{{ $en ? $child['desc_en'] : $child['desc_id'] }}</span>
                </a>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach
    </div>
    <div class="nav-right">
      <div class="lang">
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}" class="{{ site_locale() === 'id' ? 'active' : '' }}">ID</a>
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="{{ $en ? 'active' : '' }}">EN</a>
      </div>
      @auth
      <a href="{{ route('account.index') }}" class="{{ request()->routeIs('account.*') ? 'active' : '' }}" style="font-size:14px;font-weight:600;color:var(--ink-2)">{{ $en ? 'My Account' : 'Akun Saya' }}</a>
      @else
      <a href="{{ route('login') }}" style="font-size:14px;font-weight:600;color:var(--ink-2)">{{ $en ? 'Sign in' : 'Masuk' }}</a>
      @endauth
      <a href="{{ route('order-wizard.start') }}" class="btn btn-primary">{{ $en ? 'Order Now' : 'Pesan Sekarang' }}</a>
      <button class="burger" id="burger" aria-label="Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
      </button>
    </div>
  </div>
</nav>

<div class="drawer" id="drawer">
  @foreach($navMenu as $item)
    @if($item['type'] === 'link')
      <a href="{{ route($item['route']) }}">{{ $en ? $item['en'] : $item['id'] }}</a>
    @else
      <div class="drawer-group">
        <span class="drawer-label">{{ $en ? $item['en'] : $item['id'] }}</span>
        @foreach($item['children'] as $child)
          <a href="{{ route($child['route']) }}">{{ $en ? $child['en'] : $child['id'] }}</a>
        @endforeach
      </div>
    @endif
  @endforeach
  @auth
  <a href="{{ route('account.index') }}">{{ $en ? 'My Account' : 'Akun Saya' }}</a>
  @else
  <a href="{{ route('login') }}">{{ $en ? 'Sign in' : 'Masuk' }}</a>
  @endauth
  <a href="{{ route('order-wizard.start') }}" class="btn btn-primary">{{ $en ? 'Order Now' : 'Pesan Sekarang' }}</a>
  <div class="drawer-lang">
    <a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}" class="{{ site_locale() === 'id' ? 'active' : '' }}">Indonesia</a>
    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="{{ $en ? 'active' : '' }}">English</a>
  </div>
</div>
