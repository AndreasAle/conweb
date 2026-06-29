<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StorePackage;

class EcommerceController extends Controller
{
    /** Halaman fitur publik "E-commerce by Conweb". */
    public function index()
    {
        $packages = StorePackage::active()->orderBy('sort_order')->get();
        $featuredStores = Store::active()->featured()->latest()->limit(6)->get();

        return view('pages.ecommerce', compact('packages', 'featuredStores'));
    }
}
