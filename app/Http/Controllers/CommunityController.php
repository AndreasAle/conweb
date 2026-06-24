<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use App\Models\Testimonial;

class CommunityController extends Controller
{
    public function index()
    {
        $stats = Stat::where('is_active', true)->orderBy('sort')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort')->get();

        return view('community.index', compact('stats', 'testimonials'));
    }
}
