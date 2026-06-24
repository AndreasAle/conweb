@extends('order-wizard.layout')

@section('title', 'Pilih Template — '.$brand.' '.$suffix)

@section('step')
  @php $selectedSlug = \App\Support\OrderWizard::get('template_slug'); @endphp
  <div class="ow-main-head">
    <div>
      <div class="ow-eyebrow">02 · Pilih Template</div>
      <h1>Pilih desain yang <em style="color:var(--brand-d);font-style:italic">mewakili brand</em>.</h1>
      <p class="lead">Kamu masih bisa ganti template ini kapan saja sebelum pembayaran.</p>
    </div>
    <div class="ow-nav">
      <a href="{{ route('order-wizard.domain') }}" class="btn btn-line btn-sm">← Sebelumnya</a>
    </div>
  </div>

  <form method="GET" action="{{ route('order-wizard.template') }}" style="display:flex;gap:10px;margin-bottom:22px;flex-wrap:wrap">
    <input type="text" name="q" value="{{ $search }}" placeholder="Cari template..." style="flex:1;min-width:180px;padding:11px 14px;border-radius:12px;border:1px solid var(--line-2)">
    <select name="category" onchange="this.form.submit()" style="padding:11px 14px;border-radius:12px;border:1px solid var(--line-2)">
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
      <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
      @endforeach
    </select>
    <button class="btn btn-line btn-sm">Cari</button>
  </form>

  <div class="grid-3">
    @forelse($templates as $tpl)
    <div class="tpl-card" style="{{ $selectedSlug === $tpl->slug ? 'outline:2px solid var(--brand)' : '' }}">
      <div class="tpl-thumb" style="@if($tpl->thumbnail)background-image:url('{{ asset('storage/'.$tpl->thumbnail) }}')@else background:linear-gradient(135deg,{{ $tpl->primary_color }},{{ $tpl->secondary_color }})@endif">
        @if($selectedSlug === $tpl->slug)<span class="badge">✓ Terpilih</span>@endif
      </div>
      <div class="tpl-body">
        <span class="cat">{{ $tpl->category }}</span>
        <h3>{{ $tpl->name }}</h3>
        <p style="font-size:13.5px">{{ $tpl->popularity }} orang memilih ini</p>
        <div class="tpl-foot">
          <a href="{{ route('templates.show', $tpl->slug) }}" target="_blank" class="btn btn-sm btn-line">Lihat</a>
          <form method="POST" action="{{ route('order-wizard.template.store') }}">
            @csrf
            <input type="hidden" name="slug" value="{{ $tpl->slug }}">
            <button class="btn btn-sm {{ $selectedSlug === $tpl->slug ? 'btn-line' : 'btn-primary' }}">{{ $selectedSlug === $tpl->slug ? 'Terpilih' : 'Pilih' }}</button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <p>Tidak ada template ditemukan.</p>
    @endforelse
  </div>
@endsection
