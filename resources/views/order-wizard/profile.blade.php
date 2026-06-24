@extends('order-wizard.layout')

@section('title', 'Data Diri — '.$brand.' '.$suffix)

@section('step')
  <div class="ow-main-head">
    <div>
      <div class="ow-eyebrow">03 · Data Diri</div>
      <h1>Lengkapi data diri <em style="color:var(--brand-d);font-style:italic">untuk aktivasi domain</em>.</h1>
      <p class="lead">Hanya 3 kolom. Data ini dibutuhkan untuk pendaftaran domain dan konfirmasi pesanan.</p>
    </div>
    <div class="ow-nav">
      <a href="{{ route('order-wizard.template') }}" class="btn btn-line btn-sm">← Sebelumnya</a>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-error">
    <ul style="padding-left:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
  @endif

  <form method="POST" action="{{ route('order-wizard.profile.store') }}" style="max-width:480px">
    @csrf
    <div class="form-row">
      <label>Nama Lengkap</label>
      <input type="text" name="name" value="{{ old('name', \App\Support\OrderWizard::get('customer_name') ?? auth()->user()?->name) }}" required>
    </div>
    <div class="form-row">
      <label>Email <span style="color:var(--muted);font-weight:400">(bukti pembayaran dikirim ke sini)</span></label>
      <input type="email" name="email" value="{{ old('email', \App\Support\OrderWizard::get('customer_email') ?? auth()->user()?->email) }}" required>
    </div>
    <div class="form-row">
      <label>No. Handphone <span style="color:var(--muted);font-weight:400">(konfirmasi via WhatsApp)</span></label>
      <input type="text" name="phone" value="{{ old('phone', \App\Support\OrderWizard::get('customer_phone') ?? auth()->user()?->phone) }}" placeholder="08xxxxxxxxxx" required>
    </div>
    <div class="form-note">Data kamu aman bersama kami. Tidak dibagikan ke pihak ketiga selain untuk keperluan aktivasi domain & pembayaran.</div>
    <button type="submit" class="btn btn-primary">Selanjutnya →</button>
  </form>
@endsection
