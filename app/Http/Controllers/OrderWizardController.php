<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PricingPlan;
use App\Models\PromoCode;
use App\Models\WebTemplate;
use App\Services\DokuService;
use App\Services\FonnteService;
use App\Support\DomainAvailability;
use App\Support\OrderWizard;
use Illuminate\Http\Request;

class OrderWizardController extends Controller
{
    public function start(Request $request)
    {
        OrderWizard::clear();

        if ($slug = $request->query('template')) {
            $template = WebTemplate::where('slug', $slug)->where('is_active', true)->first();
            if ($template) {
                OrderWizard::put(['template_slug' => $template->slug]);
            }
        }

        return redirect()->route('order-wizard.domain');
    }

    public function domain()
    {
        $tlds = PricingPlan::where('type', 'domain')->where('is_active', true)->orderBy('sort')->get();

        return view('order-wizard.domain', [
            'tlds' => $tlds,
            'totals' => OrderWizard::totals(),
            'currentStep' => 'domain',
        ]);
    }

    public function checkDomain(Request $request)
    {
        $name = trim((string) $request->query('name'));

        if ($name === '' || strlen($name) < 3) {
            return response()->json(['error' => 'Nama domain minimal 3 karakter.'], 422);
        }

        $tlds = PricingPlan::where('type', 'domain')->where('is_active', true)->orderBy('sort')->get();

        $results = $tlds->map(function (PricingPlan $tld) use ($name) {
            return [
                'tld' => $tld->name,
                'domain' => $name.$tld->name,
                'price' => (float) $tld->price,
                'original_price' => $tld->original_price ? (float) $tld->original_price : null,
                'available' => DomainAvailability::isAvailable($name, $tld->name),
            ];
        });

        return response()->json(['name' => $name, 'results' => $results]);
    }

    public function storeDomain(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:60',
            'tld' => 'required|string',
        ]);

        $plan = PricingPlan::where('type', 'domain')->where('is_active', true)->where('name', $data['tld'])->first();

        if (! $plan || ! DomainAvailability::isAvailable($data['name'], $data['tld'])) {
            return back()->withErrors(['tld' => 'Domain tersebut tidak tersedia, silakan pilih yang lain.']);
        }

        OrderWizard::put([
            'domain_name' => $data['name'],
            'domain_tld' => $data['tld'],
            'domain_price' => (float) $plan->price,
        ]);

        return redirect()->route('order-wizard.template');
    }

    public function template(Request $request)
    {
        if (! OrderWizard::hasDomain()) {
            return redirect()->route('order-wizard.domain');
        }

        $category = $request->query('category');
        $search = $request->query('q');

        $templates = WebTemplate::where('is_active', true)
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('sort')
            ->get();

        $categories = WebTemplate::where('is_active', true)->pluck('category')->unique()->values();

        return view('order-wizard.template', [
            'templates' => $templates,
            'categories' => $categories,
            'category' => $category,
            'search' => $search,
            'totals' => OrderWizard::totals(),
            'currentStep' => 'template',
        ]);
    }

    public function storeTemplate(Request $request)
    {
        $data = $request->validate(['slug' => 'required|exists:web_templates,slug']);

        $template = WebTemplate::where('slug', $data['slug'])->where('is_active', true)->firstOrFail();

        OrderWizard::put(['template_slug' => $template->slug]);

        return redirect()->route('order-wizard.profile');
    }

    public function profile()
    {
        if (! OrderWizard::hasDomain() || ! OrderWizard::hasTemplate()) {
            return redirect()->route('order-wizard.domain');
        }

        return view('order-wizard.profile', ['totals' => OrderWizard::totals(), 'currentStep' => 'profile']);
    }

    public function storeProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'phone' => 'required|string|max:20',
        ]);

        OrderWizard::put([
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'customer_phone' => $data['phone'],
        ]);

        return redirect()->route('order-wizard.checkout');
    }

    public function checkout()
    {
        if (! OrderWizard::hasDomain() || ! OrderWizard::hasTemplate() || ! OrderWizard::hasProfile()) {
            return redirect()->route('order-wizard.domain');
        }

        // Kelompokkan channel pembayaran DOKU per grup untuk ditampilkan di UI.
        $channelGroups = [];
        foreach ((array) config('doku.channels', []) as $code => $meta) {
            $channelGroups[$meta['group'] ?? 'Lainnya'][$code] = $meta['label'] ?? $code;
        }

        return view('order-wizard.checkout', [
            'durations' => OrderWizard::durationOptions(),
            'addons' => OrderWizard::ADDONS,
            'selectedDuration' => (int) OrderWizard::get('duration_years', 1),
            'selectedAddons' => OrderWizard::get('addons', []),
            'totals' => OrderWizard::totals((int) OrderWizard::get('duration_years', 1)),
            'channelGroups' => $channelGroups,
            'customerEmail' => OrderWizard::get('customer_email'),
            'currentStep' => 'checkout',
        ]);
    }

    public function recalculate(Request $request)
    {
        $duration = (int) $request->input('duration', 1);
        $addons = (array) $request->input('addons', []);

        OrderWizard::put(['duration_years' => $duration, 'addons' => $addons]);

        return response()->json(OrderWizard::totals($duration));
    }

    public function applyPromo(Request $request)
    {
        $code = trim((string) $request->input('code'));
        $promo = PromoCode::where('code', $code)->first();

        if (! $promo || ! $promo->isValid()) {
            OrderWizard::put(['promo_code' => null]);

            return response()->json(['error' => 'Kode promo tidak valid atau sudah tidak berlaku.'], 422);
        }

        OrderWizard::put(['promo_code' => $promo->code]);

        return response()->json(OrderWizard::totals((int) OrderWizard::get('duration_years', 1)));
    }

    public function storeCheckout(Request $request, FonnteService $fonnte, DokuService $doku)
    {
        if (! OrderWizard::hasDomain() || ! OrderWizard::hasTemplate() || ! OrderWizard::hasProfile()) {
            return redirect()->route('order-wizard.domain');
        }

        $validated = $request->validate([
            'payment_channel' => ['required', 'string', 'in:'.implode(',', array_keys((array) config('doku.channels', [])))],
            'customer_email' => ['required', 'email:rfc'],
        ], [
            'payment_channel.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'payment_channel.in' => 'Metode pembayaran tidak valid.',
            'customer_email.required' => 'Email wajib diisi untuk invoice & notifikasi pembayaran.',
            'customer_email.email' => 'Format email tidak valid.',
        ]);

        $duration = (int) $request->input('duration', OrderWizard::get('duration_years', 1));
        $addons = (array) $request->input('addons', OrderWizard::get('addons', []));
        OrderWizard::put([
            'duration_years' => $duration,
            'addons' => $addons,
            'customer_email' => $validated['customer_email'],
        ]);

        $totals = OrderWizard::totals($duration);
        $template = OrderWizard::template();

        $order = Order::create([
            'order_code' => 'WE'.now()->format('ymdHis').random_int(10, 99),
            'user_id' => $request->user()?->id,
            'work_status' => 'received',
            'status_updated_at' => now(),
            'web_template_id' => $template?->id,
            'domain_name' => OrderWizard::get('domain_name'),
            'domain_tld' => OrderWizard::get('domain_tld'),
            'domain_price' => OrderWizard::get('domain_price'),
            'customer_name' => OrderWizard::get('customer_name'),
            'customer_email' => $validated['customer_email'],
            'customer_phone' => OrderWizard::get('customer_phone'),
            'duration_years' => $duration,
            'addons' => $addons,
            'promo_code' => $totals['promo_code'],
            'discount_amount' => $totals['discount_amount'],
            'total_amount' => $totals['total'],
            'payment_status' => 'pending',
            'payment_channel' => $validated['payment_channel'],
        ]);

        if ($totals['promo_code']) {
            PromoCode::where('code', $totals['promo_code'])->increment('used_count');
        }

        // Beri tahu admin ada order baru (menunggu pembayaran).
        $fonnte->sendMessage(OrderWizard::adminWhatsapp(), OrderWizard::buildOrderMessage($order));

        // Buat transaksi DOKU untuk channel terpilih, lalu arahkan ke pembayaran.
        // (Dev-mode tanpa credential: createPayment mengembalikan URL halaman thanks.)
        try {
            $payment = $doku->createPayment($order, [$validated['payment_channel']]);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi atau hubungi kami via WhatsApp.');
        }

        OrderWizard::clear();

        return redirect()->away($payment['url']);
    }

    public function thanks(Request $request)
    {
        $order = $request->query('order') ? Order::where('order_code', $request->query('order'))->first() : null;

        return view('order-wizard.thanks', [
            'order' => $order,
            'waUrl' => $order ? OrderWizard::orderWhatsappUrl($order) : null,
        ]);
    }
}
