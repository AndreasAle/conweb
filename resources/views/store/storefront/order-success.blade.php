@extends('layouts.storefront')
@section('title', 'Pesanan Diterima — '.$store->name)

@php $waUrl = whatsappUrl($store->whatsapp_number, $order->whatsapp_message); @endphp

@push('page-styles')
  .ok{max-width:620px;margin-inline:auto;padding:50px 0 60px;text-align:center}
  .ok-ic{width:84px;height:84px;border-radius:50%;background:#ecfdf3;color:#067647;display:grid;place-items:center;margin:0 auto 22px}
  .ok-ic svg{width:42px;height:42px}
  .ok h1{font-size:30px;margin-bottom:10px}
  .ok p.lead{font-size:16px;color:var(--body);margin-bottom:8px}
  .ok .code{display:inline-block;font-family:var(--display);font-weight:700;color:var(--ink);background:var(--soft);border:1px solid var(--line);padding:8px 16px;border-radius:10px;margin:10px 0 22px;letter-spacing:.02em}
  .ok-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);text-align:left;margin:24px 0;overflow:hidden}
  .ok-card .h{padding:16px 20px;border-bottom:1px solid var(--line);font-family:var(--display);font-weight:700;color:var(--ink)}
  .ok-row{display:flex;justify-content:space-between;gap:10px;padding:12px 20px;border-bottom:1px solid var(--line);font-size:14.5px}
  .ok-row:last-child{border-bottom:none}
  .ok-total{display:flex;justify-content:space-between;padding:16px 20px;background:var(--soft);font-family:var(--display);font-weight:700;font-size:18px;color:var(--ink)}
  .ok-actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
  .ok-hint{font-size:13px;color:var(--muted);margin-top:16px}
@endpush

@section('content')
<div class="wrap">
  <div class="ok">
    <div class="ok-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg></div>
    <h1>Pesanan Diterima!</h1>
    <p class="lead">Terima kasih, {{ $order->customer_name }}. Pesanan Anda sudah kami catat.</p>
    <div class="code">{{ $order->order_code }}</div>

    <div class="ok-card">
      <div class="h">Ringkasan Pesanan</div>
      @foreach($order->items as $it)
        <div class="ok-row">
          <span>{{ $it->product_name }} × {{ $it->quantity }}</span>
          <span>{{ formatRupiah($it->subtotal) }}</span>
        </div>
      @endforeach
      @if($order->discount_amount > 0)
        <div class="ok-row" style="color:#067647"><span>Diskon</span><span>− {{ formatRupiah($order->discount_amount) }}</span></div>
      @endif
      <div class="ok-total"><span>Total</span><span>{{ formatRupiah($order->total) }}</span></div>
    </div>

    <p class="lead" style="font-size:14.5px">Klik tombol di bawah untuk mengirim pesanan ke penjual via WhatsApp dan menyelesaikan konfirmasi.</p>
    <div class="ok-actions" style="margin-top:16px">
      <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-wa" id="wa-go">
        <svg viewBox="0 0 24 24" fill="currentColor" style="width:19px;height:19px"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
        Kirim ke WhatsApp Penjual
      </a>
      <a href="{{ route('store.products', $store->slug) }}" class="btn btn-line">Belanja Lagi</a>
    </div>
    <p class="ok-hint">Jika WhatsApp tidak terbuka otomatis, klik tombol hijau di atas.</p>
  </div>
</div>

@push('scripts')
<script>
  // Buka WhatsApp otomatis (tab baru). Fallback: tombol manual tetap tersedia.
  setTimeout(function(){ try { window.open(@json($waUrl), '_blank'); } catch(e){} }, 900);
</script>
@endpush
@endsection
