<?php

namespace App\Http\Controllers;

use App\Models\WebTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $templates = WebTemplate::where('is_active', true)
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderBy('sort')
            ->get();

        $categories = WebTemplate::where('is_active', true)->pluck('category')->unique()->values();

        return view('templates.index', compact('templates', 'categories', 'category'));
    }

    public function show(string $slug)
    {
        $template = WebTemplate::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $related = WebTemplate::where('is_active', true)
            ->where('id', '!=', $template->id)
            ->where('category', $template->category)
            ->orderByDesc('is_featured')
            ->orderByDesc('popularity')
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $related = $related->concat(
                WebTemplate::where('is_active', true)
                    ->where('id', '!=', $template->id)
                    ->whereNotIn('id', $related->pluck('id'))
                    ->orderByDesc('is_featured')
                    ->orderByDesc('popularity')
                    ->take(3 - $related->count())
                    ->get()
            );
        }

        return view('templates.show', compact('template', 'related'));
    }
}
