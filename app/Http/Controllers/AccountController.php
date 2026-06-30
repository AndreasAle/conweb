<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('template')->get();
        $purchases = Auth::user()->storePurchases()->with(['package', 'store'])->get();

        return view('account.index', compact('orders', 'purchases'));
    }

    public function order(string $code)
    {
        $order = Order::with('template')
            ->where('order_code', $code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('account.order', compact('order'));
    }
}
