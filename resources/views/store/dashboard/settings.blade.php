@extends('layouts.store-dashboard')
@section('title', 'Pengaturan Toko')

@section('content')
<div class="page-head">
  <div>
    <h1>Pengaturan Toko</h1>
    <p>Atur identitas, kontak, brand, dan SEO toko Anda.</p>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-error">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    Ada {{ $errors->count() }} isian yang perlu diperbaiki.
  </div>
@endif

<form method="POST" action="{{ route('store-dashboard.settings.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="card card-pad" style="margin-bottom:20px">
    <h3 style="font-size:16px;margin-bottom:18px">Identitas Toko</h3>
    <div class="form-grid">
      <div class="form-row">
        <label>Nama Toko <span class="req">*</span></label>
        <input type="text" name="name" value="{{ old('name', $store->name) }}" required>
        @error('name')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Slug (URL) <span class="req">*</span></label>
        <input type="text" name="slug" value="{{ old('slug', $store->slug) }}" required>
        <div class="hint">URL toko: {{ url('/store') }}/<strong>{{ $store->slug }}</strong></div>
        @error('slug')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row full">
        <label>Tagline</label>
        <input type="text" name="tagline" value="{{ old('tagline', $store->tagline) }}" placeholder="Slogan singkat toko">
      </div>
      <div class="form-row full">
        <label>Deskripsi</label>
        <textarea name="description" rows="4" placeholder="Ceritakan tentang toko Anda">{{ old('description', $store->description) }}</textarea>
      </div>
    </div>
  </div>

  <div class="card card-pad" style="margin-bottom:20px">
    <h3 style="font-size:16px;margin-bottom:18px">Kontak & Alamat</h3>
    <div class="form-grid">
      <div class="form-row">
        <label>Nomor WhatsApp <span class="req">*</span></label>
        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $store->whatsapp_number) }}" required placeholder="08xxxxxxxxxx">
        <div class="hint">Order customer dikirim ke nomor ini.</div>
        @error('whatsapp_number')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $store->email) }}">
      </div>
      <div class="form-row full">
        <label>Alamat</label>
        <input type="text" name="address" value="{{ old('address', $store->address) }}">
      </div>
      <div class="form-row">
        <label>Kota</label>
        <input type="text" name="city" value="{{ old('city', $store->city) }}">
      </div>
      <div class="form-row">
        <label>Provinsi</label>
        <input type="text" name="province" value="{{ old('province', $store->province) }}">
      </div>
      <div class="form-row">
        <label>Kode Pos</label>
        <input type="text" name="postal_code" value="{{ old('postal_code', $store->postal_code) }}">
      </div>
    </div>
  </div>

  <div class="card card-pad" style="margin-bottom:20px">
    <h3 style="font-size:16px;margin-bottom:18px">Logo, Banner & Brand</h3>
    <div class="form-grid">
      <div class="form-row">
        <label>Logo</label>
        @if($store->logo)
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px">
            <img src="{{ $store->logo_url }}" alt="Logo" style="width:56px;height:56px;border-radius:11px;object-fit:cover;border:1px solid var(--line)">
            <label class="switch"><input type="checkbox" name="remove_logo" value="1"> Hapus logo</label>
          </div>
        @endif
        <input type="file" name="logo" accept="image/*">
        @error('logo')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Banner</label>
        @if($store->banner)
          <div style="margin-bottom:10px">
            <img src="{{ $store->banner_url }}" alt="Banner" style="width:100%;max-height:90px;border-radius:11px;object-fit:cover;border:1px solid var(--line)">
            <label class="switch" style="margin-top:8px"><input type="checkbox" name="remove_banner" value="1"> Hapus banner</label>
          </div>
        @endif
        <input type="file" name="banner" accept="image/*">
        @error('banner')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Warna Utama</label>
        <input type="color" name="primary_color" value="{{ old('primary_color', $store->primary_color ?: '#2563eb') }}" style="height:46px;padding:4px">
      </div>
      <div class="form-row">
        <label>Warna Sekunder</label>
        <input type="color" name="secondary_color" value="{{ old('secondary_color', $store->secondary_color ?: '#0a1530') }}" style="height:46px;padding:4px">
      </div>
    </div>
  </div>

  <div class="card card-pad" style="margin-bottom:20px">
    <h3 style="font-size:16px;margin-bottom:18px">Marketplace & Sosial Media</h3>
    <div class="form-grid">
      <div class="form-row"><label>Instagram</label><input type="url" name="instagram_url" value="{{ old('instagram_url', $store->instagram_url) }}" placeholder="https://instagram.com/..."></div>
      <div class="form-row"><label>TikTok</label><input type="url" name="tiktok_url" value="{{ old('tiktok_url', $store->tiktok_url) }}" placeholder="https://tiktok.com/@..."></div>
      <div class="form-row"><label>Shopee</label><input type="url" name="shopee_url" value="{{ old('shopee_url', $store->shopee_url) }}" placeholder="https://shopee.co.id/..."></div>
      <div class="form-row"><label>Tokopedia</label><input type="url" name="tokopedia_url" value="{{ old('tokopedia_url', $store->tokopedia_url) }}" placeholder="https://tokopedia.com/..."></div>
    </div>
  </div>

  <div class="card card-pad" style="margin-bottom:20px">
    <h3 style="font-size:16px;margin-bottom:18px">SEO</h3>
    <div class="form-grid">
      <div class="form-row full"><label>Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title', $store->meta_title) }}"></div>
      <div class="form-row full"><label>Meta Description</label><textarea name="meta_description" rows="2" maxlength="255">{{ old('meta_description', $store->meta_description) }}</textarea></div>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    <a href="{{ route('store-dashboard.index') }}" class="btn btn-line">Batal</a>
  </div>
</form>
@endsection
