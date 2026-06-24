<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = PortfolioItem::where('is_active', true)->orderBy('sort')->get();

        return view('portfolio.index', compact('portfolio'));
    }
}
