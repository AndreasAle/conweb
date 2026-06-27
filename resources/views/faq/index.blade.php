@extends('layouts.app')

@php $en = site_locale() === 'en'; @endphp

@section('title', ($en ? 'FAQ — Questions About Our Web Services — '.$brand.' '.$suffix : 'FAQ — Pertanyaan Seputar Jasa Website — '.$brand.' '.$suffix))
@section('description', $en ? 'Frequently asked questions about ConWeb ID website, app, and custom system services, pricing, and process.' : 'Pertanyaan yang sering diajukan seputar jasa pembuatan website, aplikasi, harga, dan proses kerja ConWeb ID.')

@push('head')
@php
  $faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faqs->map(fn ($fq) => [
    '@type' => 'Question',
    'name' => strip_tags(t($fq, 'question')),
    'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags(t($fq, 'answer'))],
  ])->values()->all()];
@endphp
<script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@push('styles')
<style>
  .faq-search{position:relative;max-width:560px;margin:0 auto 8px}
  .faq-search svg{position:absolute;left:16px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:var(--muted)}
  .faq-search input{width:100%;padding:15px 16px 15px 46px;border-radius:14px;border:1px solid var(--line-2);font-family:var(--sans);font-size:15px;color:var(--ink);background:#fff;box-shadow:var(--shadow-sm)}
  .faq-search input:focus{outline:2px solid var(--brand-l);border-color:var(--brand)}
  .faq-empty{text-align:center;color:var(--muted);padding:30px;display:none}
  .help-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:54px}
  @media(max-width:820px){.help-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
  <section class="page-hero">
    <div class="wrap reveal center" style="max-width:760px;margin-inline:auto">
      <div class="breadcrumb" style="justify-content:center"><a href="{{ route('home') }}">{{ $en ? 'Home' : 'Beranda' }}</a><span>/</span><span>FAQ</span></div>
      <span class="eyebrow">FAQ</span>
      <h1>{{ setting_t('faq.title') }}</h1>
      <p style="margin-inline:auto">{{ setting_t('faq.lead') }}</p>
      <div class="faq-search reveal" style="margin-top:28px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" id="faq-search" placeholder="{{ $en ? 'Search questions…' : 'Cari pertanyaan…' }}" autocomplete="off">
      </div>
    </div>
  </section>

  {{-- quick help cards --}}
  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="help-grid">
        @php
        $help = $en
          ? [['deploy','Getting started','Learn how to place your first order and what to prepare.',route('order-wizard.start'),'Start order'],['target','Pricing & plans','See transparent pricing for domains and build packages.',route('pricing.index'),'View pricing'],['shield','Support','Reach our team directly on WhatsApp for anything else.',$wa,'Chat now']]
          : [['deploy','Cara memulai','Pelajari cara membuat pesanan pertama dan apa yang perlu disiapkan.',route('order-wizard.start'),'Mulai pesan'],['target','Harga & paket','Lihat harga transparan untuk domain dan paket pembuatan.',route('pricing.index'),'Lihat harga'],['shield','Dukungan','Hubungi tim kami langsung via WhatsApp untuk hal lainnya.',$wa,'Chat sekarang']];
        @endphp
        @foreach($help as $h)
        <div class="svc reveal" style="padding:28px">
          <div class="svc-ic" style="width:48px;height:48px;margin-bottom:16px">{!! \App\Support\Icons::get($h[0]) !!}</div>
          <h3 style="font-size:18px;margin-bottom:8px">{{ $h[1] }}</h3>
          <p style="font-size:14px;margin-bottom:16px">{{ $h[2] }}</p>
          <a href="{{ $h[3] }}" class="svc-more">{{ $h[4] }} <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section faq" style="padding-top:0">
    <div class="wrap">
      <div class="sec-head center reveal">
        <h2 class="heading">{{ $en ? 'All questions' : 'Semua pertanyaan' }}</h2>
      </div>
      <div class="faq-wrap" id="faq-list">
        @foreach($faqs as $i => $fq)
        <div class="faq-item {{ $i === 0 ? 'open' : '' }} reveal" data-q="{{ \Illuminate\Support\Str::lower(t($fq,'question').' '.t($fq,'answer')) }}">
          <button class="faq-q"><h3>{{ t($fq, 'question') }}</h3><span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
          <div class="faq-a"><div>{{ t($fq, 'answer') }}</div></div>
        </div>
        @endforeach
      </div>
      <p class="faq-empty" id="faq-empty">{{ $en ? 'No questions match your search.' : 'Tidak ada pertanyaan yang cocok.' }}</p>

      <div class="center" style="margin-top:44px">
        <p class="lead" style="margin-inline:auto;margin-bottom:18px">{{ $en ? "Still have questions? Chat with us directly." : 'Masih ada pertanyaan? Chat langsung dengan kami.' }}</p>
        <a href="{{ $wa }}" class="btn btn-primary">{{ $en ? 'Chat on WhatsApp' : 'Chat via WhatsApp' }}</a>
      </div>
    </div>
  </section>

  @push('scripts')
  <script>
    const faqSearch = document.getElementById('faq-search');
    if (faqSearch) {
      faqSearch.addEventListener('input', () => {
        const q = faqSearch.value.trim().toLowerCase();
        let shown = 0;
        document.querySelectorAll('#faq-list .faq-item').forEach(item => {
          const match = item.dataset.q.includes(q);
          item.style.display = match ? '' : 'none';
          if (match) shown++;
        });
        document.getElementById('faq-empty').style.display = shown ? 'none' : 'block';
      });
    }
  </script>
  @endpush
@endsection
