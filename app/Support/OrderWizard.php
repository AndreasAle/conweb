<?php

namespace App\Support;

use App\Models\PromoCode;
use App\Models\Setting;
use App\Models\WebTemplate;

/**
 * Session-backed state for the Domain -> Template -> Profile -> Checkout wizard.
 */
class OrderWizard
{
    const SESSION_KEY = 'order_wizard';

    public static function data(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public static function put(array $data): void
    {
        session([self::SESSION_KEY => array_merge(self::data(), $data)]);
    }

    public static function get(string $key, $default = null)
    {
        return self::data()[$key] ?? $default;
    }

    public static function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public static function template(): ?WebTemplate
    {
        $slug = self::get('template_slug');

        return $slug ? WebTemplate::where('slug', $slug)->first() : null;
    }

    public static function hasDomain(): bool
    {
        return (bool) self::get('domain_name') && (bool) self::get('domain_tld');
    }

    public static function hasTemplate(): bool
    {
        return (bool) self::get('template_slug');
    }

    public static function hasProfile(): bool
    {
        return (bool) self::get('customer_name') && (bool) self::get('customer_phone');
    }

    /** ConWeb Launch — biaya pembuatan web baru (tahun 1, sudah termasuk domain, hosting & SSL). */
    public static function launchPrice(): float
    {
        return (float) Setting::get('order.launch_price', 1500000);
    }

    /** ConWeb Care — biaya perpanjangan & perawatan per tahun berikutnya. */
    public static function carePrice(): float
    {
        return (float) Setting::get('order.care_price', 1250000);
    }

    public static function adminFee(): float
    {
        return (float) Setting::get('order.admin_fee', 0);
    }

    public static function durationOptions(): array
    {
        return [
            1 => ['label' => 'Launch (1 Tahun)', 'note' => 'Pembuatan + 1 tahun aktif', 'discount_pct' => 0, 'badge' => null],
            2 => ['label' => 'Launch + 1 Tahun Care', 'note' => '+1 tahun perawatan', 'discount_pct' => 5, 'badge' => 'Rekomendasi'],
            3 => ['label' => 'Launch + 2 Tahun Care', 'note' => '+2 tahun perawatan', 'discount_pct' => 10, 'badge' => 'Paling Hemat'],
        ];
    }

    /** Add-on / layanan tambahan — mengikuti tabel ADDS ON pricelist. */
    const ADDONS = [
        'tambah_halaman'      => ['label' => 'Tambah Halaman', 'price' => 200000],
        'edit_konten'         => ['label' => 'Edit Konten Ringan', 'price' => 150000],
        'desain_banner'       => ['label' => 'Desain Banner', 'price' => 150000],
        'setup_gbp'           => ['label' => 'Setup Google Business Profile', 'price' => 300000],
        'seo_basic'           => ['label' => 'SEO Basic Tambahan', 'price' => 350000],
        'maintenance_bulanan' => ['label' => 'Maintenance Bulanan (per bulan)', 'price' => 350000],
    ];

    /**
     * Full price breakdown for the current wizard state (or a given duration override).
     *
     * Model: tahun ke-1 = ConWeb Launch; tahun berikutnya = ConWeb Care (perawatan).
     * Domain, hosting, SSL & template sudah termasuk di paket (tidak ditagih terpisah).
     */
    public static function totals(?int $duration = null): array
    {
        $duration = max(1, $duration ?? (int) self::get('duration_years', 1));

        $launch = self::launchPrice();
        $care = self::carePrice();

        $durationOption = self::durationOptions()[$duration] ?? self::durationOptions()[1];
        $discountPct = $durationOption['discount_pct'];

        $renewalYears = max(0, $duration - 1);
        $careGross = $care * $renewalYears;
        $careTotal = $careGross * (1 - $discountPct / 100);

        $addonKeys = self::get('addons', []);
        $addonTotal = 0;
        foreach ((array) $addonKeys as $key) {
            $addonTotal += self::ADDONS[$key]['price'] ?? 0;
        }

        $subtotal = $launch + $careTotal + self::adminFee() + $addonTotal;

        $promoCode = self::get('promo_code');
        $discountAmount = 0;
        if ($promoCode) {
            $promo = PromoCode::where('code', $promoCode)->first();
            if ($promo && $promo->isValid()) {
                $discountAmount = $promo->discountFor($subtotal);
            }
        }

        $total = max(0, $subtotal - $discountAmount);

        return [
            'duration' => $duration,
            'launch_price' => round($launch),
            'care_years' => $renewalYears,
            'care_total' => round($careTotal),
            'care_gross' => round($careGross),
            // domain & template sudah termasuk paket → tampil sebagai "Termasuk".
            'domain_price' => 0,
            'template_price' => 0,
            'hosting_total' => 0,
            'discount_pct' => $discountPct,
            'admin_fee' => self::adminFee(),
            'addon_total' => $addonTotal,
            'subtotal' => round($subtotal),
            'promo_code' => $promoCode,
            'discount_amount' => round($discountAmount),
            'total' => round($total),
        ];
    }

    /** Nomor WhatsApp admin tujuan order (format internasional, mis. 6281…). */
    public static function adminWhatsapp(): string
    {
        $raw = (string) Setting::get('order.whatsapp_admin', '6281532963501');
        $digits = preg_replace('/\D+/', '', $raw);
        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Susun draft pesan pesanan (lengkap dengan semua isian user) untuk dikirim
     * ke WhatsApp admin. Dibangun dari record Order agar bisa dipakai ulang.
     */
    public static function buildOrderMessage(\App\Models\Order $order): string
    {
        $rp = fn ($n) => 'Rp'.number_format((float) $n, 0, ',', '.');

        $durationLabel = self::durationOptions()[(int) $order->duration_years]['label']
            ?? ($order->duration_years.' tahun');

        $lines = [];
        $lines[] = '*PESANAN BARU — ConWeb*';
        $lines[] = 'Kode: *'.$order->order_code.'*';
        $lines[] = '';
        $lines[] = '👤 *Data Pemesan*';
        $lines[] = 'Nama  : '.$order->customer_name;
        $lines[] = 'Email : '.$order->customer_email;
        $lines[] = 'No HP : '.$order->customer_phone;
        $lines[] = '';
        $lines[] = '🌐 *Detail Website*';
        $lines[] = 'Domain   : '.$order->domain_name.$order->domain_tld;
        $lines[] = 'Template : '.($order->template?->name ?? '-');
        $lines[] = 'Durasi   : '.$durationLabel;
        $lines[] = '';
        $lines[] = '🧾 *Rincian Paket*';
        $lines[] = 'ConWeb Launch (domain, hosting, SSL & pembuatan)';

        $addonKeys = (array) ($order->addons ?? []);
        if ($addonKeys) {
            $lines[] = '';
            $lines[] = '➕ *Add-on*';
            foreach ($addonKeys as $key) {
                if (isset(self::ADDONS[$key])) {
                    $lines[] = '• '.self::ADDONS[$key]['label'].' ('.$rp(self::ADDONS[$key]['price']).')';
                }
            }
        }

        if ((float) $order->discount_amount > 0) {
            $lines[] = '';
            $lines[] = 'Promo : '.($order->promo_code ?: '-').' (-'.$rp($order->discount_amount).')';
        }

        $lines[] = '';
        $lines[] = '💰 *TOTAL: '.$rp($order->total_amount).'*';
        $lines[] = '';
        $lines[] = '_Mohon dikonfirmasi untuk proses selanjutnya. Pembayaran masih manual (gateway belum aktif)._';

        return implode("\n", $lines);
    }

    /** Tautan wa.me ke admin dengan draft pesanan sudah terisi. */
    public static function orderWhatsappUrl(\App\Models\Order $order): string
    {
        return 'https://wa.me/'.self::adminWhatsapp().'?text='.rawurlencode(self::buildOrderMessage($order));
    }
}
