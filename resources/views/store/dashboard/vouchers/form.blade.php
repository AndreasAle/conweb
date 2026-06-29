@extends('layouts.store-dashboard')
@section('title', $voucher->exists ? 'Edit Voucher' : 'Tambah Voucher')

@section('content')
@php $isEdit = $voucher->exists; @endphp
<div class="page-head">
  <div><h1>{{ $isEdit ? 'Edit Voucher' : 'Tambah Voucher' }}</h1></div>
  <a href="{{ route('store-dashboard.vouchers.index') }}" class="btn btn-line">Kembali</a>
</div>

@if($errors->any())
  <div class="alert alert-error">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    Periksa kembali isian Anda.
  </div>
@endif

<form method="POST" action="{{ $isEdit ? route('store-dashboard.vouchers.update', $voucher) : route('store-dashboard.vouchers.store') }}">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="card card-pad" style="margin-bottom:20px">
    <div class="form-grid">
      <div class="form-row">
        <label>Kode Voucher <span class="req">*</span></label>
        <input type="text" name="code" value="{{ old('code', $voucher->code) }}" required style="text-transform:uppercase" placeholder="HEMAT10">
        @error('code')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Tipe Diskon <span class="req">*</span></label>
        <select name="type">
          <option value="percentage" @selected(old('type', $voucher->type)==='percentage')>Persentase (%)</option>
          <option value="fixed" @selected(old('type', $voucher->type)==='fixed')>Nominal (Rp)</option>
        </select>
      </div>
      <div class="form-row">
        <label>Nilai Diskon <span class="req">*</span></label>
        <input type="number" name="value" value="{{ old('value', $voucher->value) }}" min="1" required>
        <div class="hint">Persentase: 1–100. Nominal: dalam Rupiah.</div>
        @error('value')<div class="err">{{ $message }}</div>@enderror
      </div>
      <div class="form-row">
        <label>Maksimal Diskon (Rp)</label>
        <input type="number" name="max_discount" value="{{ old('max_discount', $voucher->max_discount) }}" min="0">
        <div class="hint">Untuk batasi diskon tipe persentase.</div>
      </div>
      <div class="form-row">
        <label>Minimal Belanja (Rp)</label>
        <input type="number" name="min_order_amount" value="{{ old('min_order_amount', $voucher->min_order_amount) }}" min="0">
      </div>
      <div class="form-row">
        <label>Batas Pemakaian</label>
        <input type="number" name="usage_limit" value="{{ old('usage_limit', $voucher->usage_limit) }}" min="1" placeholder="Kosongkan = tak terbatas">
      </div>
      <div class="form-row">
        <label>Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ old('start_date', $voucher->start_date?->format('Y-m-d')) }}">
      </div>
      <div class="form-row">
        <label>Tanggal Berakhir</label>
        <input type="date" name="end_date" value="{{ old('end_date', $voucher->end_date?->format('Y-m-d')) }}">
        @error('end_date')<div class="err">{{ $message }}</div>@enderror
      </div>
    </div>
    <div style="margin-top:8px">
      <label class="switch"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $voucher->is_active ?? true))> Voucher aktif</label>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan' : 'Tambah Voucher' }}</button>
    <a href="{{ route('store-dashboard.vouchers.index') }}" class="btn btn-line">Batal</a>
  </div>
</form>
@endsection
