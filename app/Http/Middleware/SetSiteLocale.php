<?php

namespace App\Http\Middleware;

use App\Support\Locale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSiteLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->query('lang');

        if (in_array($lang, ['id', 'en'], true)) {
            session(['site_locale' => $lang]);
        }

        Locale::set(session('site_locale', 'id'));

        return $next($request);
    }
}
