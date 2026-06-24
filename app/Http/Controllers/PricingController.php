<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;

class PricingController extends Controller
{
    public function index()
    {
        $domains = PricingPlan::where('is_active', true)->where('type', 'domain')->orderBy('sort')->get();
        $packages = PricingPlan::where('is_active', true)->where('type', 'package')->orderBy('sort')->get();

        return view('pricing.index', compact('domains', 'packages'));
    }
}
