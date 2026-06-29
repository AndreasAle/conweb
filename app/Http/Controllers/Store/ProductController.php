<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\Concerns\InteractsWithCurrentStore;
use App\Http\Requests\Store\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use InteractsWithCurrentStore;

    public function index(Request $request)
    {
        $store = $this->currentStore($request);

        $products = $store->products()
            ->with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('store.dashboard.products.index', compact('store', 'products'));
    }

    public function create(Request $request)
    {
        $store = $this->currentStore($request);
        $product = new Product(['is_active' => true]);
        $categories = $store->categories()->orderBy('name')->get();

        return view('store.dashboard.products.form', compact('store', 'product', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        $store = $this->currentStore($request);

        $data = $this->prepareData($request, $store);
        $store->products()->create($data);

        return redirect()->route('store-dashboard.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product)
    {
        $store = $this->currentStore($request);
        $this->authorizeStoreOwnership($request, $product);
        $categories = $store->categories()->orderBy('name')->get();

        return view('store.dashboard.products.form', compact('store', 'product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorizeStoreOwnership($request, $product);
        $store = $this->currentStore($request);

        $data = $this->prepareData($request, $store, $product);
        $product->update($data);

        return redirect()->route('store-dashboard.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeStoreOwnership($request, $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        foreach ($product->gallery ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }
        $product->delete();

        return redirect()->route('store-dashboard.products.index')
            ->with('success', 'Produk dihapus.');
    }

    /** Susun payload tervalidasi + slug unik per toko + upload gambar. */
    private function prepareData(ProductRequest $request, $store, ?Product $product = null): array
    {
        $data = $request->safe()->except(['image', 'remove_image']);

        // Slug unik per toko (auto dari nama bila kosong).
        $base = Str::slug($data['slug'] ?? $data['name']);
        $data['slug'] = $this->uniqueSlug($store, $base, $product?->id);

        // Checkbox toggles -> boolean tegas.
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        // Kategori bukan milik toko ini? Buang.
        if (! empty($data['category_id'])) {
            $owned = $store->categories()->whereKey($data['category_id'])->exists();
            if (! $owned) {
                $data['category_id'] = null;
            }
        }

        // Gambar utama
        if ($product && $request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            if ($product?->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('stores/products', 'public');
        }

        return $data;
    }

    private function uniqueSlug($store, string $base, ?int $ignoreId): string
    {
        $base = $base ?: 'produk';
        $slug = $base;
        $i = 2;

        while ($store->products()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
