<?php

namespace App\Support;

use App\Models\Setting;

class Locale
{
    protected static string $current = 'id';

    public static function set(string $locale): void
    {
        self::$current = in_array($locale, ['id', 'en'], true) ? $locale : 'id';
    }

    public static function current(): string
    {
        return self::$current;
    }

    /** Read a bilingual model field, e.g. field($service, 'title') -> title_id / title_en. */
    public static function field($model, string $field)
    {
        if (! $model) {
            return null;
        }

        return $model->{"{$field}_".self::$current} ?? $model->{"{$field}_id"} ?? null;
    }

    /** Read a bilingual dot-notation Setting key, e.g. setting('hero.title'). */
    public static function setting(string $key, $default = null)
    {
        return Setting::get("{$key}.".self::$current, Setting::get("{$key}.id", $default));
    }
}
