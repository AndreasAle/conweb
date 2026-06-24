@extends('layouts.app')

@section('title', 'Terima Kasih — '.$brand.' '.$suffix)

@section('content')
  <section class="section" style="padding-top:calc(var(--nav-h) + 80px)">
    <div class="wrap" style="max-width:560px;text-align:center">
      <div style="width:72px;height:72px;border-radius:50%;background:rgba(34,197,94,.12);display:grid;place-items:center;margin-inline:auto;margin-bottom:24px">
        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#22c55e" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
      </div>
      <h1 class="heading">Terima kasih!</h1>

      @if($order)
      <p class="lead" style="margin-inline:auto;margin-bottom:18px">
        Pesanan <strong>{{ $order->order_code }}</strong> untuk domain <strong>{{ $order->domain_name }}{{ $order->domain_tld }}</strong> sudah kami catat.
      </p>

      <div class="form-note" style="text-align:left;margin-bottom:22px">
        Satu langkah lagi: kirim draft detail pesananmu ke tim kami via WhatsApp agar bisa diproses. Tombol di bawah sudah berisi semua ringkasan pesananmu — tinggal tekan <strong>Kirim</strong>.
      </div>

      @if($waUrl)
      <a href="{{ $waUrl }}" id="ow-wa-link" class="btn btn-primary btn-block" style="margin-bottom:14px" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38c1.45.79 3.08 1.21 4.79 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm5.8 14.16c-.24.68-1.42 1.32-1.95 1.36-.5.05-.99.23-3.35-.7-2.82-1.11-4.6-3.97-4.74-4.16-.14-.19-1.13-1.5-1.13-2.86 0-1.36.71-2.03.97-2.31.24-.26.53-.33.71-.33.18 0 .35 0 .51.01.16.01.39-.06.6.46.24.56.81 1.96.88 2.1.07.14.12.31.02.5-.1.19-.15.31-.29.48-.14.17-.3.38-.43.51-.14.14-.29.29-.12.57.17.28.74 1.22 1.59 1.98 1.1.98 2.02 1.28 2.3 1.42.28.14.45.12.61-.07.16-.19.7-.82.89-1.1.19-.28.37-.23.62-.14.25.09 1.6.76 1.87.9.28.14.46.21.53.33.07.12.07.66-.17 1.34z"/></svg>
        Kirim Detail via WhatsApp
      </a>
      @endif

      <a href="{{ route('home') }}" class="btn btn-line btn-block">Kembali ke Beranda</a>

      @if($waUrl)
      <script>
        setTimeout(function(){ window.location.href = @json($waUrl); }, 1200);
      </script>
      @endif
      @else
      <p class="lead" style="margin-inline:auto;margin-bottom:18px">Pesanan tidak ditemukan.</p>
      <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
      @endif
    </div>
  </section>
@endsection
