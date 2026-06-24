@php
    use App\Support\OrderWizard;
    $tplObj = OrderWizard::template();
    $domainName = OrderWizard::get('domain_name');
    $domainTld = OrderWizard::get('domain_tld');
    $careYears = $totals['care_years'] ?? 0;
@endphp
<div class="ow-card">
  <span class="ow-summary-tag">
    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
    Ringkasan Pesanan
  </span>

  <div class="ow-summary-row">
    <div><strong>ConWeb Launch</strong><span class="muted">Domain, hosting, SSL & pembuatan</span></div>
    <div class="amt">Rp{{ number_format($totals['launch_price'] ?? 0, 0, ',', '.') }}</div>
  </div>

  @if($careYears > 0)
  <div class="ow-summary-row">
    <div><strong>ConWeb Care</strong><span class="muted">Perawatan {{ $careYears }} tahun</span></div>
    <div class="amt">Rp{{ number_format($totals['care_total'] ?? 0, 0, ',', '.') }}</div>
  </div>
  @endif

  @if($domainName)
  <div class="ow-summary-row">
    <div><strong>Domain</strong><span class="muted">{{ $domainName }}{{ $domainTld }}</span></div>
    <div class="amt" style="color:var(--ok)">Termasuk</div>
  </div>
  @endif

  @if($tplObj)
  <div class="ow-summary-row">
    <div><strong>Template</strong><span class="muted">{{ $tplObj->name }}</span></div>
    <div class="amt" style="color:var(--ok)">Termasuk</div>
  </div>
  @endif

  @if(!empty($totals['addon_total']))
  <div class="ow-summary-row">
    <div><strong>Add-on</strong><span class="muted">Layanan tambahan</span></div>
    <div class="amt">Rp{{ number_format($totals['addon_total'], 0, ',', '.') }}</div>
  </div>
  @endif

  @if(!empty($totals['discount_amount']))
  <div class="ow-summary-row">
    <div><strong>Diskon</strong><span class="muted">{{ $totals['promo_code'] }}</span></div>
    <div class="amt" style="color:var(--ok)">-Rp{{ number_format($totals['discount_amount'], 0, ',', '.') }}</div>
  </div>
  @endif

  <div class="ow-summary-total">
    <b>Total</b>
    <span class="val" id="ow-sidebar-total">Rp{{ number_format($totals['total'] ?? 0, 0, ',', '.') }}</span>
  </div>
</div>
