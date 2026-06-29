<?php

namespace App\Http\Controllers\Store\Concerns;

use App\Models\Store;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Helper untuk controller dashboard owner: mengambil toko aktif milik user
 * (sudah di-resolve middleware EnsureStoreOwner) dan memastikan resource anak
 * (produk, kategori, dst) benar-benar milik toko tersebut.
 */
trait InteractsWithCurrentStore
{
    protected function currentStore(Request $request): Store
    {
        $store = $request->attributes->get('currentStore')
            ?? $request->user()?->primaryStore();

        abort_unless($store instanceof Store, 403, 'Toko tidak ditemukan.');

        return $store;
    }

    /**
     * Pastikan model anak (punya kolom store_id) milik toko saat ini.
     * Mencegah owner mengakses/mengubah data toko lain (IDOR).
     */
    protected function authorizeStoreOwnership(Request $request, $model): void
    {
        if ((int) $model->store_id !== (int) $this->currentStore($request)->id) {
            throw new NotFoundHttpException;
        }
    }
}
