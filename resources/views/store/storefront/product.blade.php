@extends('layouts.storefront')
@section('title', ($product->meta_title ?: $product->name).' — '.$store->name)
@section('description', $product->meta_description ?: Str::limit(strip_tags($product->short_description ?: $product->description ?: ''), 155))

@push('head')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Product',
  'name' => $product->name,
  'image' => $product->product_image_url,
  'description' => strip_tags($product->short_description ?: $product->description ?: $product->name),
  'sku' => $product->sku,
  'brand' => ['@type' => 'Brand', 'name' => $store->name],
  'offers' => [
    '@type' => 'Offer',
    'priceCurrency' => 'IDR',
    'price' => (int) $product->price,
    'availability' => $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
    'url' => route('store.product', [$store->slug, $product->slug]),
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@push('page-styles')
  .pd{display:grid;grid-template-columns:1fr 1fr;gap:40px;padding:36px 0 50px}
  .pd-gallery .main{aspect-ratio:1;border-radius:var(--radius);overflow:hidden;background:var(--soft);border:1px solid var(--line)}
  .pd-gallery .main img{width:100%;height:100%;object-fit:cover}
  .pd-thumbs{display:flex;gap:10px;margin-top:12px;flex-wrap:wrap}
  .pd-thumbs img{width:70px;height:70px;border-radius:10px;object-fit:cover;border:1px solid var(--line-2);cursor:pointer}
  .pd-thumbs img:hover{border-color:var(--brand)}
  .crumb{font-size:13px;color:var(--muted);margin-bottom:14px}
  .crumb a{color:var(--brand)}
  .pd-info h1{font-size:clamp(24px,3.4vw,32px);margin-bottom:12px}
  .pd-price{font-family:var(--display);font-weight:700;font-size:30px;color:var(--ink);margin-bottom:6px}
  .pd-price s{font-size:18px;color:var(--muted);font-weight:500;margin-left:10px}
  .pd-stock{font-size:14px;margin-bottom:18px}
  .pd-desc{font-size:15px;color:var(--body);line-height:1.8;margin:18px 0;white-space:pre-line}
  .qty{display:inline-flex;align-items:center;border:1px solid var(--line-2);border-radius:11px;overflow:hidden}
  .qty button{width:42px;height:46px;font-size:20px;color:var(--ink);background:var(--soft)}
  .qty input{width:54px;height:46px;text-align:center;border:none;font-family:var(--display);font-weight:600;font-size:15px}
  .pd-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;align-items:center}
  @media(max-width:760px){.pd{grid-template-columns:1fr;gap:24px}}
@endpush

@section('content')
<div class="wrap">
  <div class="pd">
    <div class="pd-gallery">
      <div class="main"><img src="{{ $product->product_image_url }}" alt="{{ $product->name }}" id="pd-main"></div>
      @if(count($product->gallery_urls))
        <div class="pd-thumbs">
          <img src="{{ $product->product_image_url }}" onclick="document.getElementById('pd-main').src=this.src" alt="">
          @foreach($product->gallery_urls as $g)
            <img src="{{ $g }}" onclick="document.getElementById('pd-main').src=this.src" alt="" loading="lazy">
          @endforeach
        </div>
      @endif
    </div>

    <div class="pd-info">
      <div class="crumb">
        <a href="{{ route('store.products', $store->slug) }}">Produk</a>
        @if($product->category) / <a href="{{ route('store.products', [$store->slug, 'category' => $product->category->slug]) }}">{{ $product->category->name }}</a>@endif
        / {{ Str::limit($product->name, 30) }}
      </div>
      <h1>{{ $product->name }}</h1>
      <div class="pd-price">
        {{ $product->formatted_price }}
        @if($product->is_on_sale)<s>{{ $product->formatted_compare_price }}</s> <span class="badge badge-sale" style="vertical-align:middle">-{{ $product->discount_percent }}%</span>@endif
      </div>
      <div class="pd-stock">
        @if($product->in_stock)
          <span style="color:#067647">● {{ $product->stock === null ? 'Tersedia' : 'Stok: '.$product->stock }}</span>
        @else
          <span style="color:var(--danger)">● Stok habis</span>
        @endif
      </div>

      @if($product->short_description)<p style="font-size:15.5px;color:var(--ink-2);font-weight:500">{{ $product->short_description }}</p>@endif

      <form method="POST" action="{{ route('store.cart.add', $store->slug) }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="pd-actions">
          <div class="qty">
            <button type="button" onclick="chg(-1)">−</button>
            <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock ?? 999 }}" readonly>
            <button type="button" onclick="chg(1)">+</button>
          </div>
          <button type="submit" class="btn btn-primary" @disabled(! $product->in_stock)>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            Tambah ke Keranjang
          </button>
        </div>
      </form>

      <div class="pd-actions">
        <a href="{{ whatsappUrl($store->whatsapp_number, 'Halo '.$store->name.', saya tertarik dengan produk: '.$product->name.' ('.$product->formatted_price.'). '.route('store.product', [$store->slug, $product->slug])) }}"
           target="_blank" rel="noopener" class="btn btn-wa">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
          Tanya / Order via WhatsApp
        </a>
      </div>

      @if($product->description)
        <div class="pd-desc">{{ $product->description }}</div>
      @endif
    </div>
  </div>

  @if($related->isNotEmpty())
    <section class="sec" style="padding-top:10px">
      <div class="sec-head"><h2 style="font-size:22px">Produk Lainnya</h2></div>
      <div class="prod-grid">
        @foreach($related as $product)
          @include('store.storefront.partials.product-card')
        @endforeach
      </div>
    </section>
  @endif
</div>

@push('scripts')
<script>
  function chg(d){var i=document.getElementById('qty');var v=parseInt(i.value||'1')+d;var max=parseInt(i.max||'999');if(v<1)v=1;if(v>max)v=max;i.value=v;}
</script>
@endpush
@endsection
