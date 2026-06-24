@extends('layouts.app')

@section('title', (site_locale() === 'en' ? 'Order Now' : 'Pesan Sekarang').' — '.$brand.' '.$suffix)

@section('content')
  <section class="page-hero" style="padding-bottom:0">
    <div class="wrap reveal">
      <span class="eyebrow">{{ site_locale() === 'en' ? 'Order' : 'Pesan' }}</span>
      <h1>{{ site_locale() === 'en' ? 'Tell us what you need' : 'Ceritakan kebutuhan Anda' }}</h1>
      <p>{{ site_locale() === 'en' ? "Fill the form below — we'll redirect you to WhatsApp with your details ready to send." : 'Isi form di bawah — kami akan arahkan ke WhatsApp dengan detail Anda yang sudah terisi otomatis.' }}</p>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="form-card reveal">
        @if($errors->any())
        <div class="alert alert-error">
          <ul style="padding-left:18px">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if($reference)
        <div class="form-note">
          {{ site_locale() === 'en' ? 'You are ordering:' : 'Anda memesan:' }} <strong>{{ $reference }}</strong>
        </div>
        @endif

        <form method="POST" action="{{ route('order.store') }}">
          @csrf
          <input type="hidden" name="type" value="{{ $type }}">
          <input type="hidden" name="reference" value="{{ $reference }}">

          <div class="form-row">
            <label for="name">{{ site_locale() === 'en' ? 'Full Name' : 'Nama Lengkap' }}</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
          </div>
          <div class="form-row">
            <label for="whatsapp">{{ site_locale() === 'en' ? 'WhatsApp Number' : 'Nomor WhatsApp' }}</label>
            <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx" required>
          </div>
          <div class="form-row">
            <label for="email">Email ({{ site_locale() === 'en' ? 'optional' : 'opsional' }})</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
          </div>
          <div class="form-row">
            <label for="message">{{ site_locale() === 'en' ? 'Message (optional)' : 'Pesan Tambahan (opsional)' }}</label>
            <textarea id="message" name="message" rows="4">{{ old('message') }}</textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-block">
            {{ site_locale() === 'en' ? 'Send & Continue to WhatsApp' : 'Kirim & Lanjut ke WhatsApp' }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-12.2 7.5L3 21l2-5.8A8.5 8.5 0 1 1 21 11.5z"/></svg>
          </button>
        </form>
      </div>
    </div>
  </section>
@endsection
