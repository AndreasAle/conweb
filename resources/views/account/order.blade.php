@extends('layouts.app')

@section('title', 'Progres '.$order->order_code.' — '.$brand.' '.$suffix)

@php $stages = \App\Models\Order::WORK_STAGES; $current = $order->stageIndex(); @endphp

@push('styles')
<style>
  .track-grid{display:grid;grid-template-columns:1.4fr .9fr;gap:32px;align-items:start}
  .track-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius-lg);padding:32px;box-shadow:var(--shadow-sm)}
  .track-top{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:8px}
  .track-progress{height:10px;border-radius:99px;background:var(--soft-2);overflow:hidden;margin:18px 0 4px}
  .track-progress i{display:block;height:100%;border-radius:99px;background:linear-gradient(90deg,var(--brand),var(--sky));transition:width .6s var(--ease)}
  /* timeline */
  .timeline{position:relative;margin-top:30px;padding-left:8px}
  .tl-item{position:relative;display:flex;gap:18px;padding-bottom:26px}
  .tl-item:last-child{padding-bottom:0}
  .tl-line{position:absolute;left:19px;top:40px;bottom:-6px;width:2px;background:var(--line-2)}
  .tl-item.done .tl-line{background:linear-gradient(180deg,var(--brand),var(--sky))}
  .tl-dot{width:40px;height:40px;border-radius:50%;flex-shrink:0;display:grid;place-items:center;background:#fff;border:2px solid var(--line-2);color:var(--muted);z-index:1;transition:var(--t)}
  .tl-dot svg{width:18px;height:18px}
  .tl-item.done .tl-dot{background:var(--brand);border-color:var(--brand);color:#fff}
  .tl-item.current .tl-dot{background:#fff;border-color:var(--brand);color:var(--brand-d);box-shadow:0 0 0 5px var(--brand-tint)}
  .tl-body h4{font-size:16px;margin-bottom:3px;color:var(--ink)}
  .tl-item:not(.done):not(.current) .tl-body h4{color:var(--muted)}
  .tl-body p{font-size:13.5px;color:var(--body)}
  .tl-badge{display:inline-block;margin-top:6px;font-family:var(--display);font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;padding:3px 9px;border-radius:99px}
  .tl-badge.now{background:var(--brand-tint);color:var(--brand-d)}
  .tl-badge.ok{background:rgba(34,197,94,.12);color:#15803d}
  .sum-row{display:flex;justify-content:space-between;gap:12px;padding:10px 0;font-size:14px;border-bottom:1px solid var(--line)}
  .sum-row:last-of-type{border-bottom:none}
  .sum-row span{color:var(--muted)}
  .sum-row strong{color:var(--ink);font-family:var(--display)}
  .note-box{background:var(--soft);border:1px solid var(--line);border-radius:14px;padding:16px 18px;margin-top:18px;font-size:14px;color:var(--ink-2)}
  @media(max-width:880px){.track-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
  <section class="page-hero">
    <div class="wrap reveal">
      <div class="breadcrumb"><a href="{{ route('account.index') }}">Akun</a><span>/</span><span>{{ $order->order_code }}</span></div>
      <h1>Progres pengerjaan</h1>
      <p>Pantau status pembuatan <strong>{{ $order->domain_name }}{{ $order->domain_tld }}</strong> tahap demi tahap.</p>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap track-grid">
      {{-- timeline --}}
      <div class="track-card reveal">
        <div class="track-top">
          <div>
            <span style="font-family:var(--display);font-size:12px;color:var(--muted)">{{ $order->order_code }}</span>
            <h2 style="font-size:20px">{{ $order->stageLabel() }}</h2>
          </div>
          <span class="ostatus {{ $order->isDone() ? 'done' : '' }}" style="display:inline-flex;align-items:center;gap:7px;font-family:var(--display);font-size:12.5px;font-weight:600;padding:6px 12px;border-radius:99px;background:{{ $order->isDone() ? 'rgba(34,197,94,.12)' : 'var(--brand-tint)' }};color:{{ $order->isDone() ? '#15803d' : 'var(--brand-d)' }}">{{ $order->progressPercent() }}% selesai</span>
        </div>
        <div class="track-progress"><i style="width:{{ $order->progressPercent() }}%"></i></div>

        <div class="timeline">
          @foreach($stages as $key => $stage)
          @php $idx = array_search($key, array_keys($stages), true); $state = $idx < $current ? 'done' : ($idx === $current ? 'current' : ''); @endphp
          <div class="tl-item {{ $state }}">
            @if(!$loop->last)<span class="tl-line"></span>@endif
            <div class="tl-dot">
              @if($state === 'done')
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
              @else
              <strong style="font-family:var(--display);font-size:14px">{{ $idx + 1 }}</strong>
              @endif
            </div>
            <div class="tl-body">
              <h4>{{ $stage['label'] }}</h4>
              <p>{{ $stage['desc'] }}</p>
              @if($state === 'current')<span class="tl-badge now">Sedang berjalan</span>@elseif($state === 'done')<span class="tl-badge ok">Selesai</span>@endif
              @if($state === 'current' && $order->work_note)
              <div class="note-box">📌 {{ $order->work_note }}</div>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- summary --}}
      <div class="track-card reveal">
        <h3 style="font-size:17px;margin-bottom:16px">Ringkasan Pesanan</h3>
        <div class="sum-row"><span>Domain</span><strong>{{ $order->domain_name }}{{ $order->domain_tld }}</strong></div>
        @if($order->template)<div class="sum-row"><span>Template</span><strong>{{ $order->template->name }}</strong></div>@endif
        <div class="sum-row"><span>Durasi</span><strong>{{ $order->duration_years }} tahun</strong></div>
        <div class="sum-row"><span>Status bayar</span><strong style="text-transform:capitalize">{{ $order->payment_status }}</strong></div>
        <div class="sum-row"><span>Total</span><strong style="color:var(--brand-d)">Rp{{ number_format($order->total_amount,0,',','.') }}</strong></div>
        @if($order->status_updated_at)
        <p style="font-size:12.5px;color:var(--muted);margin-top:14px">Diperbarui {{ $order->status_updated_at->translatedFormat('d M Y, H:i') }}</p>
        @endif
        <a href="{{ $wa }}" class="btn btn-line btn-block" style="margin-top:18px">Tanya tim via WhatsApp</a>
      </div>
    </div>
  </section>
@endsection
