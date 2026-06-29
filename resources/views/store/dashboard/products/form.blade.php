@extends('layouts.store-dashboard')
@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')
@php $isEdit = $product->exists; @endphp
<div class="page-head">
  <div>
    <h1>{{ $isEdit ? 'Edit Produk' : 'Tambah Produk' }}</h1>
    <p>{{ $isEdit ? $product->name : 'Lengkapi detail produk baru.' }}</p>
  </div>
  <a href="{{ route('store-dashboard.products.index') }}" class="btn btn-line">Kembali</a>
</div>

@if($errors->any())
  <div class="alert alert-error">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    Periksa kembali isian Anda.
  </div>
@endif

<form method="POST" action="{{ $isEdit ? route('store-dashboard.products.update', $product) : route('store-dashboard.products.store') }}" enctype="multipart/form-data">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="card card-pad" style="margin-bottom:20px">
    <div class="form-grid">
      <div class="form-row">
        <label>Nama Produk <span class="req">*</span></label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
        @error('name')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Kategori</label>
        <select name="category_id">
          <option value="">— Tanpa kategori —</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
        @if($categories->isEmpty())<div class="hint">Belum ada kategori. <a href="{{ route('store-dashboard.categories.create') }}" style="color:var(--brand-d)">Buat kategori</a>.</div>@endif
      </div>
      <div class="form-row">
        <label>Harga (Rp) <span class="req">*</span></label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required>
        @error('price')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Harga Coret (Rp)</label>
        <input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" min="0">
        <div class="hint">Isi jika produk sedang promo (harus ≥ harga jual).</div>
        @error('compare_price')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" placeholder="Kosongkan = tak terbatas">
      </div>
      <div class="form-row">
        <label>SKU</label>
        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}">
      </div>
      <div class="form-row">
        <label>Berat (gram)</label>
        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" min="0">
      </div>
      <div class="form-row full">
        <label>Deskripsi Singkat</label>
        <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" maxlength="255">
      </div>
      <div class="form-row full">
        <label>Deskripsi Lengkap</label>
        <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
      </div>
    </div>
  </div>

  <div class="card card-pad" style="margin-bottom:20px">
    <h3 style="font-size:16px;margin-bottom:16px">Gambar Produk</h3>
    @if($isEdit && $product->image)
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
        <img src="{{ $product->product_image_url }}" alt="" style="width:80px;height:80px;border-radius:11px;object-fit:cover;border:1px solid var(--line)">
        <label class="switch"><input type="checkbox" name="remove_image" value="1"> Hapus gambar</label>
      </div>
    @endif
    <input type="file" name="image" accept="image/*">
    <div class="hint">JPG/PNG/WebP, maks 3 MB.</div>
    @error('image')<div class="err">{{ $message }}</div>@enderror
  </div>

  <div class="card card-pad" style="margin-bottom:20px">
    <div style="display:flex;gap:24px;flex-wrap:wrap">
      <label class="switch"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Produk aktif</label>
      <label class="switch"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> Tampilkan sebagai unggulan</label>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
    <a href="{{ route('store-dashboard.products.index') }}" class="btn btn-line">Batal</a>
  </div>
</form>
@endsection
