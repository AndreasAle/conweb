<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\Concerns\InteractsWithCurrentStore;
use App\Http\Requests\Store\CategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use InteractsWithCurrentStore;

    public function index(Request $request)
    {
        $store = $this->currentStore($request);

        $categories = $store->categories()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('store.dashboard.categories.index', compact('store', 'categories'));
    }

    public function create(Request $request)
    {
        $store = $this->currentStore($request);
        $category = new ProductCategory(['is_active' => true, 'sort_order' => 0]);

        return view('store.dashboard.categories.form', compact('store', 'category'));
    }

    public function store(CategoryRequest $request)
    {
        $store = $this->currentStore($request);

        $data = $this->prepareData($request, $store);
        $store->categories()->create($data);

        return redirect()->route('store-dashboard.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Request $request, ProductCategory $category)
    {
        $store = $this->currentStore($request);
        $this->authorizeStoreOwnership($request, $category);

        return view('store.dashboard.categories.form', compact('store', 'category'));
    }

    public function update(CategoryRequest $request, ProductCategory $category)
    {
        $this->authorizeStoreOwnership($request, $category);
        $store = $this->currentStore($request);

        $data = $this->prepareData($request, $store, $category);
        $category->update($data);

        return redirect()->route('store-dashboard.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, ProductCategory $category)
    {
        $this->authorizeStoreOwnership($request, $category);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        // Produk yang terkait akan ter-set category_id = null (nullOnDelete di FK).
        $category->delete();

        return redirect()->route('store-dashboard.categories.index')
            ->with('success', 'Kategori dihapus.');
    }

    private function prepareData(CategoryRequest $request, $store, ?ProductCategory $category = null): array
    {
        $data = $request->safe()->except(['image', 'remove_image']);

        $base = Str::slug($data['slug'] ?? $data['name']);
        $data['slug'] = $this->uniqueSlug($store, $base, $category?->id);
        $data['is_active'] = $request->boolean('is_active');

        if ($category && $request->boolean('remove_image') && $category->image) {
            Storage::disk('public')->delete($category->image);
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            if ($category?->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('stores/categories', 'public');
        }

        return $data;
    }

    private function uniqueSlug($store, string $base, ?int $ignoreId): string
    {
        $base = $base ?: 'kategori';
        $slug = $base;
        $i = 2;

        while ($store->categories()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
