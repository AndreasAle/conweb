<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort')->get();

        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $others = Service::where('is_active', true)->where('id', '!=', $service->id)->orderBy('sort')->take(3)->get();

        return view('services.show', compact('service', 'others'));
    }
}
