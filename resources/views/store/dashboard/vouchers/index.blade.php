@extends('layouts.store-dashboard')
@section('title', 'Voucher')

@section('content')
<div class="page-head">
  <div>
    <h1>Voucher & Diskon</h1>
    <p>Buat kode promo untuk customer Anda.</p>
  </div>
  <a href="{{ route('store-dashboard.vouchers.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Tambah Voucher
  </a>
</div>

<div class="card">
  @if($vouchers->isEmpty())
    <div class="empty">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v14"/></svg>
      <h3>Belum ada voucher</h3>
      <p>Buat voucher untuk menarik lebih banyak pembeli.</p>
      <a href="{{ route('store-dashboard.vouchers.create') }}" class="btn btn-primary" style="margin-top:14px">Tambah Voucher</a>
    </div>
  @else
    <div class="table-wrap">
      <table class="tbl">
        <thead><tr><th>Kode</th><th>Tipe</th><th>Nilai</th><th>Min. Order</th><th>Dipakai</th><th>Periode</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @foreach($vouchers as $v)
          <tr>
            <td><strong>{{ $v->code }}</strong></td>
            <td>{{ $v->type === 'percentage' ? 'Persentase' : 'Nominal' }}</td>
            <td>{{ $v->type === 'percentage' ? $v->value.'%' : formatRupiah($v->value) }}</td>
            <td>{{ $v->min_order_amount ? formatRupiah($v->min_order_amount) : '—' }}</td>
            <td>{{ $v->used_count }}{{ $v->usage_limit ? ' / '.$v->usage_limit : '' }}</td>
            <td style="font-size:12.5px;color:var(--muted)">
              {{ $v->start_date?->format('d/m/y') ?? '—' }} – {{ $v->end_date?->format('d/m/y') ?? '∞' }}
            </td>
            <td>@if($v->is_active)<span class="badge badge-green">Aktif</span>@else<span class="badge badge-gray">Nonaktif</span>@endif</td>
            <td>
              <div style="display:flex;gap:6px;justify-content:flex-end">
                <a href="{{ route('store-dashboard.vouchers.edit', $v) }}" class="btn btn-line btn-sm">Edit</a>
                <form method="POST" action="{{ route('store-dashboard.vouchers.destroy', $v) }}" onsubmit="return confirm('Hapus voucher ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

{{ $vouchers->links('store.partials.pagination') }}
@endsection
