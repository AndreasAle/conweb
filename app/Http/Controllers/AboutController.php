<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function index()
    {
        $stats = Stat::where('is_active', true)->orderBy('sort')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort')->take(3)->get();

        return view('about.index', compact('stats', 'testimonials'));
    }
}
