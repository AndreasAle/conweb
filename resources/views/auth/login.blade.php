@extends('layouts.auth')

@section('title', 'Masuk')

@section('form')
  <div class="top"><a href="{{ route('home') }}" class="back">← Kembali ke beranda</a></div>
  <h1>Masuk ke akunmu</h1>
  <p class="sub">Selamat datang kembali! Lanjutkan pesanan dan pantau progres web-mu.</p>

  @if($errors->any())
  <div class="alert alert-error">{{ $errors->first() }}</div>
  @endif
  @if(session('status'))
  <div class="alert alert-ok">{{ session('status') }}</div>
  @endif

  <a href="{{ route('google.redirect') }}" class="btn btn-google">
    <svg viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.27-4.74 3.27-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.99.66-2.26 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84A11 11 0 0 0 12 23z"/><path fill="#FBBC05" d="M5.84 14.1a6.6 6.6 0 0 1 0-4.2V7.06H2.18a11 11 0 0 0 0 9.88l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84C6.71 7.31 9.14 5.38 12 5.38z"/></svg>
    Masuk dengan Google
  </a>

  <div class="divider">atau pakai email</div>

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="••••••••" required>
    </div>
    <div class="row-between">
      <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
    </div>
    <button type="submit" class="btn btn-primary">Masuk</button>
  </form>

  <p class="alt">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
@endsection
