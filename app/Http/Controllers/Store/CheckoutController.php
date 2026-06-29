<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CheckoutRequest;
use App\Models\Store;
use App\Services\Store\CartService;
use App\Services\Store\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private CheckoutService $checkout,
    ) {}

    private function ensureActive(Store $store): void
    {
        abort_unless($store->is_active, 404);
    }

    public function show(Store $store)
    {
        $this->ensureActive($store);

        if ($this->cart->isEmpty($store)) {
            return redirect()->route('store.cart', $store->slug)
                ->with('error', 'Keranjang masih kosong.');
        }

        $items = $this->cart->items($store);
        $subtotal = $this->cart->subtotal($store);
        $discount = $this->cart->discount($store);
        $total = $this->cart->total($store);

        return view('store.storefront.checkout', compact('store', 'items', 'subtotal', 'discount', 'total'));
    }

    public function store(CheckoutRequest $request, Store $store)
    {
        $this->ensureActive($store);

        if ($this->cart->isEmpty($store)) {
            return redirect()->route('store.cart', $store->slug)
                ->with('error', 'Keranjang masih kosong.');
        }

        $order = $this->checkout->place($store, $request->validated());

        return redirect()->route('store.order-success', [$store->slug, $order->order_code]);
    }

    public function success(Store $store, string $orderCode)
    {
        $this->ensureActive($store);

        $order = $store->orders()->where('order_code', $orderCode)->with('items')->firstOrFail();

        return view('store.storefront.order-success', compact('store', 'order'));
    }
}
