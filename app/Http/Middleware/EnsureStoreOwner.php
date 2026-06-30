<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Memastikan user yang login memiliki sebuah toko (Conweb Store), lalu
 * meng-share instance toko aktif tersebut ke request & view sebagai
 * `currentStore`. Owner dashboard selalu beroperasi pada toko milik user.
 */
class EnsureStoreOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $store = $user?->primaryStore();

        if (! $store) {
            return redirect()
                ->route('store-onboarding.packages')
                ->with('error', 'Anda belum memiliki toko. Pilih paket Conweb Store untuk mulai membuka toko online Anda.');
        }

        // Bagikan ke seluruh view dashboard + binding agar mudah diakses.
        $request->attributes->set('currentStore', $store);
        view()->share('currentStore', $store);

        return $next($request);
    }
}
