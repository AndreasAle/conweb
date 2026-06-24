<?php

use App\Support\Locale;

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
