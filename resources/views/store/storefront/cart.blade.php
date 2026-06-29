@extends('layouts.storefront')
@section('title', 'Keranjang — '.$store->name)

@push('page-styles')
  .cart{display:grid;grid-template-columns:1.7fr 1fr;gap:28px;padding:36px 0 50px;align-items:start}
  .cart h1{font-size:28px;margin-bottom:20px}
  .citem{display:flex;gap:14px;padding:16px 0;border-bottom:1px solid var(--line)}
  .citem img{width:84px;height:84px;border-radius:12px;object-fit:cover;border:1px solid var(--line);flex-shrink:0}
  .citem .info{flex:1;min-width:0}
  .citem h3{font-size:15.5px;margin-bottom:4px}
  .citem .price{font-family:var(--display);font-weight:600;color:var(--brand);font-size:14.5px}
  .citem .row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:10px;flex-wrap:wrap}
  .qty{display:inline-flex;align-items:center;border:1px solid var(--line-2);border-radius:10px;overflow:hidden}
  .qty button{width:34px;height:38px;font-size:17px;background:var(--soft)}
  .qty input{width:42px;height:38px;text-align:center;border:none;font-family:var(--display);font-weight:600}
  .summary{background:var(--soft);border:1px solid var(--line);border-radius:var(--radius);padding:22px;position:sticky;top:86px}
  .summary h2{font-size:18px;margin-bottom:16px}
  .sum-row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:14.5px}
  .sum-row.total{font-size:19px;font-family:var(--display);color:var(--ink);font-weight:700;padding-top:12px;margin-top:6px;border-top:1px dashed var(--line-2)}
  .voucher-box{display:flex;gap:8px;margin:6px 0 16px}
  .voucher-box input{flex:1;padding:10px 12px;border-radius:10px;border:1px solid var(--line-2);font-family:var(--sans);text-transform:uppercase}
  .voucher-on{display:flex;justify-content:space-between;align-items:center;background:#ecfdf3;border:1px solid #abefc6;border-radius:10px;padding:10px 12px;margin-bottom:14px;font-size:13.5px;color:#067647}
  @media(max-width:820px){.cart{grid-template-columns:1fr}.summary{position:static}}
@endpush

@section('content')
<div class="wrap">
  <div style="padding-top:30px"><h1>Keranjang Belanja</h1></div>

  @if($items->isEmpty())
    <div class="empty-state" style="padding:70px 20px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
      <h3>Keranjang masih kosong</h3>
      <p style="margin-bottom:16px">Yuk pilih produk favoritmu.</p>
      <a href="{{ route('store.products', $store->slug) }}" class="btn btn-primary">Mulai Belanja</a>
    </div>
  @else
    <div class="cart">
      <div>
        @foreach($items as $line)
          @php $p = $line['product']; @endphp
          <div class="citem">
            <img src="{{ $p->product_image_url }}" alt="{{ $p->name }}">
            <div class="info">
              <h3>{{ $p->name }}</h3>
              <div class="price">{{ $p->formatted_price }}</div>
              <div class="row">
                <form method="POST" action="{{ route('store.cart.update', $store->slug) }}" class="qty-form">
                  @csrf @method('PATCH')
                  <input type="hidden" name="product_id" value="{{ $p->id }}">
                  <div class="qty">
                    <button type="button" onclick="step(this,-1)">−</button>
                    <input type="number" name="quantity" value="{{ $line['quantity'] }}" min="1" max="{{ $p->stock ?? 999 }}" onchange="this.form.submit()">
                    <button type="button" onclick="step(this,1)">+</button>
                  </div>
                </form>
                <div style="display:flex;align-items:center;gap:14px">
                  <strong style="font-family:var(--display)">{{ formatRupiah($line['subtotal']) }}</strong>
                  <form method="POST" action="{{ route('store.cart.remove', $store->slug) }}" onsubmit="return confirm('Hapus item ini?')">
                    @csrf @method('DELETE')
                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                    <button class="btn btn-line btn-sm" style="color:var(--danger);border-color:#fecdca">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        <a href="{{ route('store.products', $store->slug) }}" class="btn btn-line btn-sm" style="margin-top:18px">← Lanjut belanja</a>
      </div>

      <div class="summary">
        <h2>Ringkasan</h2>

        @if($voucher)
          <div class="voucher-on">
            <span>Voucher <strong>{{ $voucher->code }}</strong> aktif</span>
            <form method="POST" action="{{ route('store.cart.voucher.remove', $store->slug) }}">
              @csrf @method('DELETE')
              <button style="color:#067647;font-weight:600;text-decoration:underline">Hapus</button>
            </form>
          </div>
        @else
          <form method="POST" action="{{ route('store.cart.voucher', $store->slug) }}" class="voucher-box">
            @csrf
            <input type="text" name="code" placeholder="Kode voucher" required>
            <button class="btn btn-line btn-sm">Pakai</button>
          </form>
        @endif

        <div class="sum-row"><span>Subtotal</span><span>{{ formatRupiah($subtotal) }}</span></div>
        @if($discount > 0)<div class="sum-row" style="color:#067647"><span>Diskon</span><span>− {{ formatRupiah($discount) }}</span></div>@endif
        <div class="sum-row total"><span>Total</span><span>{{ formatRupiah($total) }}</span></div>

        <a href="{{ route('store.checkout', $store->slug) }}" class="btn btn-primary btn-block" style="margin-top:16px">Lanjut ke Checkout</a>
      </div>
    </div>
  @endif
</div>

@push('scripts')
<script>
  function step(btn,d){var inp=btn.parentNode.querySelector('input');var v=parseInt(inp.value||'1')+d;var max=parseInt(inp.max||'999');if(v<1)v=1;if(v>max)v=max;inp.value=v;inp.form.submit();}
</script>
@endpush
@endsection
