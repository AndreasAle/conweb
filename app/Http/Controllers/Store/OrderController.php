<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\Concerns\InteractsWithCurrentStore;
use App\Models\StoreOrder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    use InteractsWithCurrentStore;

    public function index(Request $request)
    {
        $store = $this->currentStore($request);

        $orders = $store->orders()
            ->withCount('items')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(fn ($w) => $w->where('order_code', 'like', $term)
                    ->orWhere('customer_name', 'like', $term)
                    ->orWhere('customer_phone', 'like', $term));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.dashboard.orders.index', compact('store', 'orders'));
    }

    public function show(Request $request, StoreOrder $order)
    {
        $this->authorizeStoreOwnership($request, $order);
        $store = $this->currentStore($request);
        $order->load('items');

        return view('store.dashboard.orders.show', compact('store', 'order'));
    }

    public function updateStatus(Request $request, StoreOrder $order)
    {
        $this->authorizeStoreOwnership($request, $order);

        $validated = $request->validate([
            'status' => ['required', Rule::in(StoreOrder::STATUSES)],
            'payment_status' => ['nullable', Rule::in(StoreOrder::PAYMENT_STATUSES)],
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
