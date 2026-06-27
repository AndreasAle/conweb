<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\WebTemplate;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];
        $add = function (string $path, ?string $lastmod = null, string $freq = 'weekly', string $priority = '0.7') use (&$urls) {
            $urls[] = [
                'loc' => url($path),
                'lastmod' => $lastmod ?: Carbon::now()->toAtomString(),
                'changefreq' => $freq,
                'priority' => $priority,
            ];
        };

        // Halaman utama
        $add('/', null, 'daily', '1.0');
        foreach (['/layanan', '/paket', '/portofolio', '/template', '/komunitas', '/blog', '/faq', '/tentang'] as $p) {
            $add($p, null, 'weekly', '0.8');
        }

        // Konten dinamis
        foreach (Service::where('is_active', true)->whereNotNull('slug')->get() as $s) {
            $add('/layanan/'.$s->slug, $s->updated_at?->toAtomString(), 'monthly', '0.7');
        }
        foreach (WebTemplate::where('is_active', true)->get() as $t) {
            $add('/template/'.$t->slug, $t->updated_at?->toAtomString(), 'monthly', '0.6');
        }
        foreach (BlogPost::where('is_active', true)->get() as $b) {
            $add('/blog/'.$b->slug, ($b->updated_at ?? $b->published_at)?->toAtomString(), 'monthly', '0.6');
        }

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
