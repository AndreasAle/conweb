@extends('layouts.auth')

@section('title', 'Verifikasi Email')

@section('form')
  <div class="top">
    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="back" style="border:none;background:none;cursor:pointer">← Keluar</button></form>
  </div>
  <h1>Verifikasi email kamu</h1>
  <p class="sub">Kami mengirim kode 6 digit ke <strong>{{ $email }}</strong>. Masukkan di bawah ini.</p>

  @if($errors->any())
  <div class="alert alert-error">{{ $errors->first() }}</div>
  @endif
  @if(session('status'))
  <div class="alert alert-ok">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('verify.submit') }}" id="otp-form">
    @csrf
    <input type="hidden" name="code" id="otp-code">
    <div class="otp-row" id="otp-row">
      @for($i = 0; $i < 6; $i++)
      <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" data-otp @if($i===0) autofocus @endif>
      @endfor
    </div>
    <button type="submit" class="btn btn-primary">Verifikasi</button>
  </form>

  <form method="POST" action="{{ route('verify.resend') }}">
    @csrf
    <p class="alt">Tidak menerima kode? <button type="submit" style="border:none;background:none;cursor:pointer;color:var(--brand-d);font-weight:700;font-family:var(--sans)">Kirim ulang</button></p>
  </form>

  @push('scripts')
  <script>
    const boxes = Array.from(document.querySelectorAll('[data-otp]'));
    const hidden = document.getElementById('otp-code');
    function sync(){ hidden.value = boxes.map(b => b.value).join(''); }
    boxes.forEach((box, i) => {
      box.addEventListener('input', e => {
        box.value = box.value.replace(/\D/g,'').slice(0,1);
        if(box.value && i < boxes.length-1) boxes[i+1].focus();
        sync();
        if(hidden.value.length === 6) document.getElementById('otp-form').requestSubmit();
      });
      box.addEventListener('keydown', e => {
        if(e.key === 'Backspace' && !box.value && i > 0) boxes[i-1].focus();
      });
      box.addEventListener('paste', e => {
        e.preventDefault();
        const digits = (e.clipboardData.getData('text')||'').replace(/\D/g,'').slice(0,6).split('');
        digits.forEach((d,j) => { if(boxes[j]) boxes[j].value = d; });
        sync(); (boxes[digits.length] || boxes[5]).focus();
        if(hidden.value.length === 6) document.getElementById('otp-form').requestSubmit();
      });
    });
  </script>
  @endpush
@endsection
