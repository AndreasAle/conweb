@extends('layouts.app')

@section('title', 'Lengkapi Data Toko — '.$brand.' '.$suffix)

@section('content')
<style>
  .su-wrap{max-width:760px;margin-inline:auto}
  .su-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius,18px);padding:24px;margin-bottom:20px;box-shadow:var(--shadow-sm)}
  .su-card h3{font-size:16px;margin-bottom:16px}
  .su-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  .su-field{margin-bottom:16px}
  .su-field.full{grid-column:1/-1}
  .su-field label{display:block;font-family:var(--display);font-size:13.5px;font-weight:600;color:var(--ink-2);margin-bottom:7px}
  .su-field input,.su-field textarea,.su-field select{width:100%;padding:12px 14px;border-radius:12px;border:1px solid var(--line-2);font-size:14px;font-family:var(--sans);background:#fff}
  .su-field input:focus,.su-field textarea:focus,.su-field select:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px var(--brand-tint)}
  .su-field .hint{font-size:12px;color:var(--muted);margin-top:5px}
  .su-field input[type=color]{height:46px;padding:5px;cursor:pointer}
  .su-tpls{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
  .su-tpl{border:1px solid var(--line-2);border-radius:12px;overflow:hidden;cursor:pointer;transition:.2s}
  .su-tpl:hover{border-color:var(--brand)}
  .su-tpl.sel{border-color:var(--brand);box-shadow:0 0 0 3px rgba(37,99,235,.12)}
  .su-tpl img{width:100%;aspect-ratio:16/10;object-fit:cover;background:var(--soft-2)}
  .su-tpl span{display:block;padding:8px 10px;font-size:13px;font-family:var(--display);font-weight:600;color:var(--ink-2)}
  .su-tpl input{display:none}
  @media(max-width:600px){.su-grid,.su-tpls{grid-template-columns:1fr}}
</style>

<section class="page-hero" style="padding-bottom:18px">
  <div class="wrap su-wrap">
    <div class="eyebrow">Paket {{ $purchase->package_name }} · Lunas ✓</div>
    <h1 style="font-size:28px">Lengkapi Data Toko</h1>
    <p class="lead" style="color:var(--body);max-width:560px">Isi profil tokomu. Setelah disimpan, toko langsung aktif dan bisa kamu kelola dari dashboard.</p>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="wrap su-wrap">
    @if($errors->any())
      <div class="alert alert-error" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#b91c1c;padding:13px 16px;border-radius:12px;margin-bottom:18px">
        <strong>Periksa kembali:</strong> {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('store-onboarding.setup.store', $purchase->order_code) }}" enctype="multipart/form-data" id="su-form">
      @csrf

      <div class="su-card">
        <h3>Identitas Toko</h3>
        <div class="su-grid">
          <div class="su-field">
            <label>Nama Toko <span style="color:var(--danger,#ef4444)">*</span></label>
            <input type="text" name="name" id="su-name" value="{{ old('name') }}" required>
          </div>
          <div class="su-field">
            <label>Slug (URL Toko) <span style="color:var(--danger,#ef4444)">*</span></label>
            <input type="text" name="slug" id="su-slug" value="{{ old('slug') }}" required>
            <span class="hint">{{ url('/store') }}/<b id="su-slug-preview">nama-toko</b></span>
          </div>
          <div class="su-field full">
            <label>Tagline</label>
            <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="Mis. Keripik singkong renyah khas Bandung">
          </div>
          <div class="su-field full">
            <label>Deskripsi Toko</label>
            <textarea name="description" rows="3" placeholder="Ceritakan tentang toko & produkmu...">{{ old('description') }}</textarea>
          </div>
        </div>
      </div>

      <div class="su-card">
        <h3>Kontak & Lokasi</h3>
        <div class="su-grid">
          <div class="su-field">
            <label>Nomor WhatsApp <span style="color:var(--danger,#ef4444)">*</span></label>
            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $purchase->customer_phone) }}" placeholder="08xxxxxxxxxx" required>
            <span class="hint">Pesanan customer akan masuk ke nomor ini.</span>
          </div>
          <div class="su-field">
            <label>Email Toko</label>
            <input type="email" name="email" value="{{ old('email', $purchase->customer_email) }}">
          </div>
          <div class="su-field full">
            <label>Alamat</label>
            <input type="text" name="address" value="{{ old('address') }}">
          </div>
          <div class="su-field">
            <label>Kota</label>
            <input type="text" name="city" value="{{ old('city') }}">
          </div>
          <div class="su-field">
            <label>Provinsi</label>
            <input type="text" name="province" value="{{ old('province') }}">
          </div>
        </div>
      </div>

      <div class="su-card">
        <h3>Branding & Sosial</h3>
        <div class="su-grid">
          <div class="su-field">
            <label>Logo Toko</label>
            <input type="file" name="logo" accept="image/*">
            <span class="hint">JPG/PNG/WebP, maks 3 MB.</span>
          </div>
          <div class="su-field">
            <label>Banner Toko</label>
            <input type="file" name="banner" accept="image/*">
            <span class="hint">JPG/PNG/WebP, maks 4 MB.</span>
          </div>
          <div class="su-field">
            <label>Warna Brand Utama</label>
            <input type="color" name="primary_color" value="{{ old('primary_color', '#2563eb') }}">
          </div>
          <div class="su-field"></div>
          <div class="su-field">
            <label>Instagram</label>
            <input type="url" name="instagram_url" value="{{ old('instagram_url') }}" placeholder="https://instagram.com/...">
          </div>
          <div class="su-field">
            <label>TikTok</label>
            <input type="url" name="tiktok_url" value="{{ old('tiktok_url') }}" placeholder="https://tiktok.com/@...">
          </div>
          <div class="su-field">
            <label>Shopee</label>
            <input type="url" name="shopee_url" value="{{ old('shopee_url') }}" placeholder="https://shopee.co.id/...">
          </div>
          <div class="su-field">
            <label>Tokopedia</label>
            <input type="url" name="tokopedia_url" value="{{ old('tokopedia_url') }}" placeholder="https://tokopedia.com/...">
          </div>
        </div>
      </div>

      @if($templates->isNotEmpty())
      <div class="su-card">
        <h3>Template Tampilan Toko</h3>
        <div class="su-tpls">
          @foreach($templates as $tpl)
            <label class="su-tpl">
              <input type="radio" name="store_template_id" value="{{ $tpl->id }}" {{ old('store_template_id') == $tpl->id ? 'checked' : '' }}>
              @if($tpl->preview_image)<img src="{{ asset('storage/'.$tpl->preview_image) }}" alt="{{ $tpl->name }}">@else<img src="https://placehold.co/320x200?text={{ urlencode($tpl->name) }}" alt="{{ $tpl->name }}">@endif
              <span>{{ $tpl->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
      @endif

      <button type="submit" class="btn btn-primary btn-block" id="su-submit">
        Buat &amp; Aktifkan Toko
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
      </button>
    </form>
  </div>
</section>

<script>
  (function(){
    const name = document.getElementById('su-name');
    const slug = document.getElementById('su-slug');
    const preview = document.getElementById('su-slug-preview');
    let slugEdited = {{ old('slug') ? 'true' : 'false' }};
    const slugify = s => s.toString().toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
    function sync(){ if(!slugEdited){ slug.value = slugify(name.value); } preview.textContent = slug.value || 'nama-toko'; }
    name.addEventListener('input', sync);
    slug.addEventListener('input', () => { slugEdited = true; slug.value = slugify(slug.value); preview.textContent = slug.value || 'nama-toko'; });
    sync();

    // highlight template terpilih
    document.querySelectorAll('.su-tpl input').forEach(r => r.addEventListener('change', () => {
      document.querySelectorAll('.su-tpl').forEach(t => t.classList.remove('sel'));
      if (r.checked) r.closest('.su-tpl').classList.add('sel');
    }));
    const presel = document.querySelector('.su-tpl input:checked'); if(presel) presel.closest('.su-tpl').classList.add('sel');

    document.getElementById('su-form').addEventListener('submit', function(){
      const b = document.getElementById('su-submit'); b.disabled = true; b.style.opacity = '.7'; b.textContent = 'Menyimpan...';
    });
  })();
</script>
@endsection
