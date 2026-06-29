@extends('layouts.store-dashboard')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
@php $isEdit = $category->exists; @endphp
<div class="page-head">
  <div>
    <h1>{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
  </div>
  <a href="{{ route('store-dashboard.categories.index') }}" class="btn btn-line">Kembali</a>
</div>

@if($errors->any())
  <div class="alert alert-error">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    Periksa kembali isian Anda.
  </div>
@endif

<form method="POST" action="{{ $isEdit ? route('store-dashboard.categories.update', $category) : route('store-dashboard.categories.store') }}" enctype="multipart/form-data">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="card card-pad" style="margin-bottom:20px">
    <div class="form-grid">
      <div class="form-row">
        <label>Nama Kategori <span class="req">*</span></label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        @error('name')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Urutan Tampil</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
      </div>
      <div class="form-row full">
        <label>Deskripsi</label>
        <textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea>
      </div>
      <div class="form-row full">
        <label>Gambar Kategori</label>
        @if($isEdit && $category->image)
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px">
            <img src="{{ $category->image_url }}" alt="" style="width:64px;height:64px;border-radius:11px;object-fit:cover;border:1px solid var(--line)">
            <label class="switch"><input type="checkbox" name="remove_image" value="1"> Hapus gambar</label>
          </div>
        @endif
        <input type="file" name="image" accept="image/*">
        @error('image')<div class="err">{{ $message }}</div>@enderror
      </div>
    </div>
    <div style="margin-top:8px">
      <label class="switch"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> Kategori aktif</label>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan' : 'Tambah Kategori' }}</button>
    <a href="{{ route('store-dashboard.categories.index') }}" class="btn btn-line">Batal</a>
  </div>
</form>
@endsection
