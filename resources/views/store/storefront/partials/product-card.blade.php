{{-- expects: $store, $product --}}
<div class="pcard">
  <a href="{{ route('store.product', [$store->slug, $product->slug]) }}" class="thumb">
    @if($product->is_on_sale)<span class="badge badge-sale">-{{ $product->discount_percent }}%</span>@endif
    <img src="{{ $product->product_image_url }}" alt="{{ $product->name }}" loading="lazy">
  </a>
  <div class="body">
    <h3><a href="{{ route('store.product', [$store->slug, $product->slug]) }}">{{ $product->name }}</a></h3>
    <div class="price">
      {{ $product->formatted_price }}
      @if($product->is_on_sale)<s>{{ $product->formatted_compare_price }}</s>@endif
    </div>
    <div class="acts">
      <form method="POST" action="{{ route('store.cart.add', $store->slug) }}" style="flex:1">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button class="btn btn-primary btn-sm btn-block" @disabled(! $product->in_stock)>
          {{ $product->in_stock ? '+ Keranjang' : 'Stok habis' }}
        </button>
      </form>
    </div>
  </div>
</div>
