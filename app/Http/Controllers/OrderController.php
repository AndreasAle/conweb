<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Service;
use App\Models\Setting;
use App\Models\WebTemplate;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $type = 'custom';
        $reference = null;

        if ($slug = $request->query('template')) {
            $template = WebTemplate::where('slug', $slug)->first();
            if ($template) {
                $type = 'template';
                $reference = $template->name;
            }
        } elseif ($slug = $request->query('service')) {
            $service = Service::where('slug', $slug)->first();
            if ($service) {
                $type = 'service';
                $reference = t($service, 'title');
            }
        } elseif ($package = $request->query('package')) {
            $type = 'package';
            $reference = $package;
        }

        return view('order.create', compact('type', 'reference'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'whatsapp' => 'required|string|max:30',
            'email' => 'nullable|email|max:160',
            'type' => 'required|in:template,service,package,custom',
            'reference' => 'nullable|string|max:160',
            'message' => 'nullable|string|max:2000',
        ]);

        $lead = Lead::create($data + ['status' => 'new']);

        $text = "Halo, saya {$lead->name}, ingin menggunakan jasa ConWeb.";
        if ($lead->reference) {
            $text .= " Saya tertarik dengan: {$lead->reference}.";
        }
        if ($lead->message) {
            $text .= " Pesan tambahan: {$lead->message}";
        }

        $waBase = Setting::get('site.whatsapp', 'https://wa.me/6280000000000');
        $separator = str_contains($waBase, '?') ? '&' : '?';
        $waLink = $waBase.$separator.'text='.rawurlencode($text);

        return redirect()->away($waLink);
    }
}
