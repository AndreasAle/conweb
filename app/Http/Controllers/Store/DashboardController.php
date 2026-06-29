<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\Concerns\InteractsWithCurrentStore;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use InteractsWithCurrentStore;

    public function index(Request $request)
    {
        $store = $this->currentStore($request);

        $stats = [
            'products' => $store->products()->count(),
            'orders' => $store->orders()->count(),
            'pending' => $store->orders()->where('status', 'pending')->count(),
            // Omzet = total dari order yang tidak dibatalkan.
            'revenue' => (int) $store->orders()->where('status', '!=', 'cancelled')->sum('total'),
        ];

        $recentOrders = $store->orders()->latest()->limit(8)->get();

        return view('store.dashboard.index', compact('store', 'stats', 'recentOrders'));
    }
}
