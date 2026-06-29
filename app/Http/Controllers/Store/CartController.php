<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\Store\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    private function ensureActive(Store $store): void
    {
        abort_unless($store->is_active, 404);
    }

    public function show(Store $store)
    {
        $this->ensureActive($store);

        $items = $this->cart->items($store);
        $subtotal = $this->cart->subtotal($store);
        $voucher = $this->cart->getVoucher($store);
        $discount = $this->cart->discount($store);
        $total = $this->cart->total($store);

        return view('store.storefront.cart', compact('store', 'items', 'subtotal', 'voucher', 'discount', 'total'));
    }

    public function add(Request $request, Store $store)
    {
        $this->ensureActive($store);

        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        $this->cart->add($store, $data['product_id'], $data['quantity'] ?? 1);

        return redirect()->route('store.cart', $store->slug)
            ->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Store $store)
    {
        $this->ensureActive($store);

        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $this->cart->update($store, $data['product_id'], $data['quantity']);

        return redirect()->route('store.cart', $store->slug);
    }

    public function remove(Request $request, Store $store)
    {
        $this->ensureActive($store);

        $data = $request->validate(['product_id' => ['required', 'integer']]);
        $this->cart->remove($store, $data['product_id']);

        return redirect()->route('store.cart', $store->slug)->with('success', 'Item dihapus.');
    }

    public function applyVoucher(Request $request, Store $store)
    {
        $this->ensureActive($store);

        $data = $request->validate(['code' => ['required', 'string', 'max:40']]);

        if ($this->cart->setVoucher($store, $data['code'])) {
            return redirect()->route('store.cart', $store->slug)->with('success', 'Voucher diterapkan.');
        }

        return redirect()->route('store.cart', $store->slug)
            ->with('error', 'Kode voucher tidak valid atau tidak memenuhi syarat.');
    }

    public function removeVoucher(Store $store)
    {
        $this->ensureActive($store);
        $this->cart->forgetVoucher($store);

        return redirect()->route('store.cart', $store->slug);
    }
}
