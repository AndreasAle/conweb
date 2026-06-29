<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    /** Pastikan toko aktif; kalau nonaktif, 404 untuk publik. */
    private function ensureActive(Store $store): void
    {
        abort_unless($store->is_active, 404);
    }

    public function home(Store $store)
    {
        $this->ensureActive($store);

        $featured = $store->products()->active()->featured()->latest()->limit(8)->get();
        $latest = $store->products()->active()->latest()->limit(8)->get();
        $categories = $store->categories()->active()
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')->orderBy('name')->get();

        return view('store.storefront.home', compact('store', 'featured', 'latest', 'categories'));
    }

    public function products(Request $request, Store $store)
    {
        $this->ensureActive($store);

        $categories = $store->categories()->active()->orderBy('sort_order')->orderBy('name')->get();
        $activeCategory = $request->filled('category')
            ? $categories->firstWhere('slug', $request->string('category')->value())
            : null;

        $products = $store->products()->active()
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))
            ->when($activeCategory, fn ($q) => $q->where('category_id', $activeCategory->id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('store.storefront.products', compact('store', 'products', 'categories', 'activeCategory'));
    }

    public function product(Store $store, Product $product)
    {
        $this->ensureActive($store);

        // Scoped binding sudah memastikan $product milik $store, tapi pastikan aktif.
        abort_unless($product->is_active, 404);

        $related = $store->products()->active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->latest()->limit(4)->get();

        return view('store.storefront.product', compact('store', 'product', 'related'));
    }
}
