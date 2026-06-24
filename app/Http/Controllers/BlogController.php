<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category')->where('is_active', true)->orderByDesc('published_at')->get();
        $categories = BlogCategory::orderBy('sort')->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related = BlogPost::where('is_active', true)->where('id', '!=', $post->id)->orderByDesc('published_at')->take(3)->get();

        return view('blog.show', compact('post', 'related'));
    }
}
