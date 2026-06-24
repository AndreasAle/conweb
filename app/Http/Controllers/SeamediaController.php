<?php

namespace App\Http\Controllers;

use App\Models\SeamediaAddon;
use App\Models\SeamediaPackage;
use App\Models\SeamediaService;
use App\Models\SeamediaShowcase;
use App\Models\Setting;

class SeamediaController extends Controller
{
    public function index()
    {
        $s = Setting::all_cached();
        $set = fn ($key, $default = '') => $s['seamedia.'.$key] ?? $default;

        $showcases = SeamediaShowcase::where('is_active', true)->orderBy('sort')->get();

        return view('seamedia.landing', [
            'set' => $set,
            'packages' => SeamediaPackage::where('is_active', true)->orderBy('sort')->get(),
            'services' => SeamediaService::where('is_active', true)->orderBy('sort')->get(),
            'addons' => SeamediaAddon::where('is_active', true)->orderBy('sort')->get(),
            'showcases' => $showcases,
            'categories' => $showcases->pluck('category')->filter()->unique()->values(),
        ]);
    }
}
