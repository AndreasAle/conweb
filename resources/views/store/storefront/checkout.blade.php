@extends('layouts.storefront')
@section('title', 'Checkout — '.$store->name)

@push('page-styles')
  .co{display:grid;grid-template-columns:1.5fr 1fr;gap:28px;padding:36px 0 50px;align-items:start}
  .co h1{font-size:28px;margin-bottom:6px}
  .co .lead{color:var(--muted);font-size:14.5px;margin-bottom:22px}
  .field{margin-bottom:16px}
  .field label{display:block;font-family:var(--display);font-size:13.5px;font-weight:600;color:var(--ink-2);margin-bottom:7px}
  .field .req{color:var(--danger)}
  .field input,.field textarea{width:100%;padding:12px 14px;border-radius:11px;border:1px solid var(--line-2);font-family:var(--sans);font-size:14.5px;background:#fff}
  .field input:focus,.field textarea:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px rgba(37,99,235,.12)}
  .field .err{color:var(--danger);font-size:12.5px;margin-top:6px;font-weight:500}
  .summary{background:var(--soft);border:1px solid var(--line);border-radius:var(--radius);padding:22px;position:sticky;top:86px}
  .summary h2{font-size:18px;margin-bottom:14px}
  .co-item{display:flex;justify-content:space-between;gap:10px;font-size:14px;padding:8px 0;border-bottom:1px solid var(--line)}
  .co-item span:first-child{color:var(--ink-2)}
  .sum-row{display:flex;justify-content:space-between;margin:10px 0;font-size:14.5px}
  .sum-row.total{font-size:19px;font-family:var(--display);color:var(--ink);font-weight:700;padding-top:12px;border-top:1px dashed var(--line-2)}
  .note-wa{background:#fff;border:1px solid var(--line);border-radius:11px;padding:12px 14px;font-size:13px;color:var(--muted);margin-top:14px;display:flex;gap:9px}
  .note-wa svg{width:18px;height:18px;color:#25d366;flex-shrink:0;margin-top:1px}
  @media(max-width:820px){.co{grid-template-columns:1fr}.summary{position:static}}
@endpush

@section('content')
<div class="wrap">
  <form method="POST" action="{{ route('store.checkout.store', $store->slug) }}" class="co">
    @csrf
    <div>
      <h1>Checkout</h1>
      <p class="lead">Isi data Anda. Pesanan dikirim ke penjual via WhatsApp untuk dikonfirmasi.</p>

      <div class="field">
        <label>Nama Lengkap <span class="req">*</span></label>
        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
        @error('customer_name')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="field">
        <label>Nomor WhatsApp <span class="req">*</span></label>
        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="08xxxxxxxxxx">
        @error('customer_phone')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="field">
        <label>Email (opsional)</label>
        <input type="email" name="customer_email" value="{{ old('customer_email') }}">
        @error('customer_email')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="field">
        <label>Alamat Pengiriman (opsional)</label>
        <textarea name="customer_address" rows="3">{{ old('customer_address') }}</textarea>
      </div>
      <div class="field">
        <label>Catatan untuk penjual (opsional)</label>
        <textarea name="customer_note" rows="2">{{ old('customer_note') }}</textarea>
      </div>
    </div>

    <div class="summary">
      <h2>Pesanan Anda</h2>
      @foreach($items as $line)
        <div class="co-item">
          <span>{{ $line['product']->name }} <strong>×{{ $line['quantity'] }}</strong></span>
          <span>{{ formatRupiah($line['subtotal']) }}</span>
        </div>
      @endforeach
      <div class="sum-row" style="margin-top:14px"><span>Subtotal</span><span>{{ formatRupiah($subtotal) }}</span></div>
      @if($discount > 0)<div class="sum-row" style="color:#067647"><span>Diskon</span><span>− {{ formatRupiah($discount) }}</span></div>@endif
      <div class="sum-row total"><span>Total</span><span>{{ formatRupiah($total) }}</span></div>

      <button type="submit" class="btn btn-wa btn-block" style="margin-top:16px">
        <svg viewBox="0 0 24 24" fill="currentColor" style="width:19px;height:19px"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
        Pesan via WhatsApp
      </button>
      <div class="note-wa">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
        <span>Setelah klik, Anda diarahkan ke WhatsApp penjual dengan rincian pesanan otomatis.</span>
      </div>
    </div>
  </form>
</div>
@endsection
