<?php

use App\Support\Locale;
use Illuminate\Support\Str;

if (! function_exists('site_locale')) {
    function site_locale(): string
    {
        return Locale::current();
    }
}

if (! function_exists('t')) {
    /** Bilingual model field helper: t($service, 'title') -> title_id or title_en. */
    function t($model, string $field)
    {
        return Locale::field($model, $field);
    }
}

if (! function_exists('setting_t')) {
    /** Bilingual Setting helper: setting_t('hero.title'). */
    function setting_t(string $key, $default = null)
    {
        return Locale::setting($key, $default);
    }
}

if (! function_exists('formatRupiah')) {
    /** Format angka ke Rupiah, contoh: 150000 -> "Rp150.000". */
    function formatRupiah($amount): string
    {
        return 'Rp'.number_format((float) $amount, 0, ',', '.');
    }
}

if (! function_exists('generateOrderCode')) {
    /**
     * Generate kode order unik, contoh: CW-STORE-20260630-AB12CD.
     * Prefix bisa diganti per modul.
     */
    function generateOrderCode(string $prefix = 'CW-STORE'): string
    {
        $random = strtoupper(Str::random(6));

        return sprintf('%s-%s-%s', $prefix, now()->format('Ymd'), $random);
    }
}

if (! function_exists('whatsappUrl')) {
    /**
     * Bangun URL wa.me dengan pesan ter-encode.
     * Menormalkan nomor: 08xx -> 628xx, hilangkan karakter non-digit.
     */
    function whatsappUrl(?string $phone, string $message = ''): string
    {
        $number = preg_replace('/\D+/', '', (string) $phone);

        if ($number === '') {
            return '#';
        }

        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        } elseif (str_starts_with($number, '8')) {
            $number = '62'.$number;
        }

        $url = 'https://wa.me/'.$number;

        if ($message !== '') {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }
}
