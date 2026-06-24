@php
    $defaultMark = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="2.4"/><circle cx="5" cy="18" r="2.4"/><circle cx="19" cy="18" r="2.4"/><path d="M10.3 6.6 6.7 15.4M13.7 6.6l3.6 8.8M7.4 18h9.2"/></svg>';
@endphp
<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <a href="{{ route('home') }}" class="logo">
          <span class="logo-mark">@if($logo)<img src="{{ asset('storage/'.$logo) }}" alt="{{ $brand }}">@else{!! $defaultMark !!}@endif</span>
          {{ $brand }}<b style="color:var(--sky)">.</b>{{ $suffix }}
        </a>
        <p>{{ setting_t('foot.desc') }}</p>
        <div class="foot-social">
          <a href="{{ $s['social.github'] ?? '#' }}" aria-label="GitHub"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.58 2 12.25c0 4.53 2.87 8.37 6.84 9.73.5.1.68-.22.68-.49l-.01-1.7c-2.78.62-3.37-1.37-3.37-1.37-.45-1.18-1.11-1.5-1.11-1.5-.91-.63.07-.62.07-.62 1 .07 1.53 1.06 1.53 1.06.89 1.56 2.34 1.11 2.91.85.09-.66.35-1.11.63-1.37-2.22-.26-4.56-1.14-4.56-5.07 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.3.1-2.71 0 0 .84-.27 2.75 1.05A9.4 9.4 0 0 1 12 6.84c.85 0 1.71.12 2.51.34 1.91-1.32 2.75-1.05 2.75-1.05.55 1.41.2 2.45.1 2.71.64.72 1.03 1.63 1.03 2.75 0 3.94-2.34 4.81-4.57 5.06.36.32.68.94.68 1.9l-.01 2.82c0 .27.18.6.69.49A10.04 10.04 0 0 0 22 12.25C22 6.58 17.52 2 12 2z"/></svg></a>
          <a href="{{ $s['social.linkedin'] ?? '#' }}" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zM8.34 18.34V10.4H5.67v7.94zM7 9.24a1.55 1.55 0 1 0 0-3.1 1.55 1.55 0 0 0 0 3.1zm11.34 9.1v-4.36c0-2.33-1.25-3.42-2.91-3.42a2.5 2.5 0 0 0-2.27 1.25v-1.07h-2.67v7.6h2.67v-4.2c0-1.11.21-2.18 1.58-2.18 1.35 0 1.37 1.26 1.37 2.25v4.13z"/></svg></a>
          <a href="{{ $s['social.instagram'] ?? '#' }}" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><line x1="17.5" y1="6.5" x2="17.5" y2="6.5"/></svg></a>
          <a href="mailto:{{ $email }}" aria-label="Email"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg></a>
        </div>
      </div>
      <div class="foot-col">
        <h4>{{ site_locale() === 'en' ? 'Products' : 'Produk' }}</h4>
        <a href="{{ route('templates.index') }}">{{ site_locale() === 'en' ? 'Templates' : 'Template Website' }}</a>
        <a href="{{ route('services.index') }}">{{ site_locale() === 'en' ? 'Services' : 'Layanan' }}</a>
        <a href="{{ route('pricing.index') }}">{{ site_locale() === 'en' ? 'Pricing' : 'Paket & Harga' }}</a>
        <a href="{{ route('portfolio.index') }}">{{ site_locale() === 'en' ? 'Portfolio' : 'Portofolio' }}</a>
      </div>
      <div class="foot-col">
        <h4>{{ site_locale() === 'en' ? 'Resources' : 'Sumber Daya' }}</h4>
        <a href="{{ route('about.index') }}">{{ site_locale() === 'en' ? 'About Us' : 'Tentang Kami' }}</a>
        <a href="{{ route('community.index') }}">{{ site_locale() === 'en' ? 'Community' : 'Komunitas' }}</a>
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('faq.index') }}">FAQ</a>
      </div>
      <div class="foot-col">
        <h4>{{ site_locale() === 'en' ? 'Contact' : 'Kontak' }}</h4>
        <a href="mailto:{{ $email }}">{{ $email }}</a>
        <a href="{{ $wa }}">WhatsApp</a>
        <a href="{{ route('order.create') }}">{{ site_locale() === 'en' ? 'Order Now' : 'Pesan Sekarang' }}</a>
      </div>
    </div>
    <div class="foot-bottom">
      <p>© {{ $s['foot.copyrightYear'] ?? date('Y') }} {{ $brand }} {{ $suffix }}. {{ setting_t('foot.rights') }}</p>
      <p class="made">{{ setting_t('foot.made') }} <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7-4.5-9.5-9C.8 8.6 2.3 5 5.5 5c1.9 0 3.2 1 4.5 2.5C11.3 6 12.6 5 14.5 5 17.7 5 19.2 8.6 21.5 12 19 16.5 12 21 12 21z"/></svg></p>
    </div>
  </div>
</footer>
