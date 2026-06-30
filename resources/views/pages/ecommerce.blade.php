@extends('layouts.app')

@section('title', 'E-commerce by Conweb — Toko Online Mandiri untuk UMKM')
@section('description', 'Punya toko online sendiri tanpa potongan admin marketplace dari Conweb. Katalog produk, checkout WhatsApp, dashboard pesanan, & voucher untuk UMKM Indonesia.')

@push('styles')
<style>
  .cmp{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:10px}
  .cmp-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:32px;box-shadow:var(--shadow-sm)}
  .cmp-card.win{border-color:var(--brand-tint-2);background:linear-gradient(180deg,var(--brand-tint),#fff 40%)}
  .cmp-card h3{font-size:20px;margin-bottom:18px;display:flex;align-items:center;gap:10px}
  .cmp-card ul{display:grid;gap:13px}
  .cmp-card li{display:flex;gap:11px;align-items:flex-start;font-size:14.5px;color:var(--ink-2)}
  .cmp-card li svg{width:19px;height:19px;flex-shrink:0;margin-top:2px}
  .cmp-card .yes{color:var(--ok)}
  .cmp-card .no{color:#ef4444}
  .ecom-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
  .pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
  @media(max-width:880px){.cmp{grid-template-columns:1fr}.ecom-steps{grid-template-columns:1fr 1fr}.pkg-grid{grid-template-columns:1fr}}
  @media(max-width:520px){.ecom-steps{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<section class="page-hero">
  <div class="wrap">
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a> <span>/</span> <span>E-commerce by Conweb</span></div>
    <span class="eyebrow">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
      <span>E-commerce by Conweb</span>
    </span>
    <h1>Punya toko online sendiri, <br>tanpa potongan admin marketplace dari Conweb.</h1>
    <p>Bangun katalog produk, terima order lewat WhatsApp, dan tampil lebih profesional dengan website toko online mandiri untuk UMKM.</p>
    <div class="hero-cta" style="margin-top:26px">
      <a href="{{ route('store-onboarding.packages') }}" class="btn btn-primary">Buat Toko Online Sekarang
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn btn-line">Konsultasi via WhatsApp</a>
    </div>
  </div>
</section>

<!-- FITUR -->
<section class="section services" id="fitur">
  <div class="wrap">
    <div class="sec-head center">
      <h2 class="heading">Semua yang UMKM butuhkan untuk jualan online</h2>
      <p class="lead">Rumah digital utama brand Anda — marketplace tetap bisa dipakai untuk traffic.</p>
    </div>
    <div class="svc-grid cols-4">
      @php
        $features = [
          ['0% komisi dari Conweb', 'Tidak ada komisi penjualan dari Conweb untuk setiap order yang masuk.'],
          ['Katalog produk', 'Foto, harga, deskripsi, kategori — tampil rapi & profesional.'],
          ['Checkout WhatsApp', 'Order otomatis terkirim ke WhatsApp owner beserta rinciannya.'],
          ['Dashboard pesanan', 'Kelola pesanan & ubah status dari satu dashboard.'],
          ['Manajemen produk', 'Tambah, edit, set unggulan, atur stok dengan mudah.'],
          ['Voucher & diskon', 'Buat kode promo persentase atau nominal.'],
          ['SEO produk', 'Meta title, deskripsi, & struktur siap untuk Google.'],
          ['Brand sesuai identitas', 'Warna & logo toko mengikuti brand Anda.'],
        ];
      @endphp
      @foreach($features as [$title, $desc])
        <div class="svc" style="padding:26px">
          <div class="svc-ic" style="width:48px;height:48px;margin-bottom:16px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <h3 style="font-size:18px;margin-bottom:8px">{{ $title }}</h3>
          <p style="font-size:14px;margin-bottom:0">{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- CARA KERJA -->
<section class="section">
  <div class="wrap">
    <div class="sec-head center"><h2 class="heading">Cara kerjanya</h2></div>
    <div class="ecom-steps">
      @foreach([
        ['1','Aktifkan toko','Tim Conweb menyiapkan toko & akun owner Anda.'],
        ['2','Isi produk','Tambah produk, kategori, foto, dan harga via dashboard.'],
        ['3','Bagikan link','Sebar link toko ke WhatsApp, bio IG, & marketplace.'],
        ['4','Terima order','Order masuk ke WhatsApp, kelola statusnya di dashboard.'],
      ] as [$n,$t,$d])
        <div class="proc">
          <div class="proc-num">{{ $n }}</div>
          <h3>{{ $t }}</h3>
          <p>{{ $d }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- PERBANDINGAN -->
<section class="section services">
  <div class="wrap">
    <div class="sec-head center">
      <h2 class="heading">Marketplace vs Conweb Store</h2>
      <p class="lead">Keduanya saling melengkapi. Conweb Store jadi rumah digital utama brand Anda.</p>
    </div>
    <div class="cmp">
      <div class="cmp-card">
        <h3>🛒 Marketplace</h3>
        <ul>
          <li><svg class="no" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg> Ada biaya admin / komisi</li>
          <li><svg class="no" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg> Brand bersaing dengan toko lain</li>
          <li><svg class="no" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg> Data customer milik platform</li>
          <li><svg class="no" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg> Tampilan terbatas</li>
          <li><svg class="yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Cocok untuk traffic</li>
        </ul>
      </div>
      <div class="cmp-card win">
        <h3>🏪 Conweb Store</h3>
        <ul>
          <li><svg class="yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 0% admin dari Conweb</li>
          <li><svg class="yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Brand tampil sendiri</li>
          <li><svg class="yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Data order milik UMKM</li>
          <li><svg class="yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Tampilan sesuai brand</li>
          <li><svg class="yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Cocok untuk trust & repeat order</li>
        </ul>
      </div>
    </div>
  </div>
</section>

@if($packages->isNotEmpty())
<!-- PAKET -->
<section class="section">
  <div class="wrap">
    <div class="sec-head center"><h2 class="heading">Pilihan paket</h2></div>
    <div class="pkg-grid">
      @foreach($packages as $pkg)
        <div class="price-card">
          @if($pkg->is_featured)<span class="badge">Populer</span>@endif
          <h3>{{ $pkg->name }}</h3>
          @if($pkg->tagline)<p style="font-size:13.5px;color:var(--muted);margin-bottom:8px">{{ $pkg->tagline }}</p>@endif
          <div class="price-now">{{ $pkg->formatted_price }}<span>{{ $pkg->price_period }}</span></div>
          @if($pkg->features)
            <ul class="price-feat">
              @foreach($pkg->features as $f)
                <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>{{ $f }}</li>
              @endforeach
            </ul>
          @endif
          <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn btn-primary btn-block">Konsultasi</a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($featuredStores->isNotEmpty())
<!-- TOKO UNGGULAN -->
<section class="section services">
  <div class="wrap">
    <div class="sec-head center"><h2 class="heading">Toko yang sudah online</h2></div>
    <div class="grid-3">
      @foreach($featuredStores as $st)
        <a href="{{ route('store.home', $st->slug) }}" target="_blank" rel="noopener" class="tpl-card" style="display:block">
          <div class="tpl-thumb" style="background:{{ $st->primary_color ?: 'var(--brand)' }};display:flex;align-items:center;justify-content:center">
            @if($st->logo)<img src="{{ $st->logo_url }}" alt="{{ $st->name }}" style="width:80px;height:80px;border-radius:16px;object-fit:cover">@else<span style="font-family:var(--display);font-size:28px;font-weight:700;color:#fff">{{ $st->name }}</span>@endif
          </div>
          <div class="tpl-body">
            <h3>{{ $st->name }}</h3>
            <span class="cat">{{ $st->tagline ?: $st->city }}</span>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- CTA -->
<section class="section">
  <div class="wrap">
    <div class="cta-wrap">
      <span class="eyebrow"><span>Siap jualan online?</span></span>
      <h2>Bangun toko online mandiri untuk brand Anda</h2>
      <p>Konsultasikan kebutuhan toko UMKM Anda dengan tim Conweb. Tanpa komisi penjualan dari Conweb.</p>
      <div class="cta-actions">
        <a href="{{ $wa }}" target="_blank" rel="noopener" class="btn btn-light">Konsultasi via WhatsApp</a>
        <a href="{{ route('pricing.index') }}" class="btn btn-outline-light">Lihat Paket</a>
      </div>
      <p style="font-size:12.5px;color:#8aa0c8;margin-top:18px">Biaya pihak ketiga (payment gateway, ekspedisi, dll.) tetap mengikuti ketentuan masing-masing provider jika digunakan.</p>
    </div>
  </div>
</section>
@endsection
