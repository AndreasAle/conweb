<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreSetupRequest;
use App\Models\Store;
use App\Models\StorePackage;
use App\Models\StorePurchase;
use App\Models\StoreTemplate;
use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Onboarding self-service Conweb Store:
 * pilih paket -> bayar (DOKU) -> isi form toko -> toko aktif & bisa dikelola.
 */
class OnboardingController extends Controller
{
    /** Halaman pilih paket (Conweb Profile / Store / Commerce). */
    public function packages()
    {
        $packages = StorePackage::active()->orderBy('sort_order')->get();

        return view('store.onboarding.packages', compact('packages'));
    }

    /** Form checkout paket: data pembeli + pilih metode pembayaran. */
    public function checkout(StorePackage $package)
    {
        abort_unless($package->is_active, 404);

        return view('store.onboarding.checkout', [
            'package' => $package,
            'channelGroups' => $this->channelGroups(),
            'user' => Auth::user(),
        ]);
    }

    /** Buat pembelian (pending) + transaksi DOKU, lalu arahkan ke pembayaran. */
    public function purchase(Request $request, StorePackage $package, DokuService $doku)
    {
        abort_unless($package->is_active, 404);

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:25'],
            'customer_email' => ['required', 'email:rfc', 'max:120'],
            'payment_channel' => ['required', 'string', 'in:'.implode(',', array_keys((array) config('doku.channels', [])))],
        ], [
            'customer_name.required' => 'Nama wajib diisi.',
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'customer_email.required' => 'Email wajib diisi untuk invoice & notifikasi.',
            'payment_channel.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'payment_channel.in' => 'Metode pembayaran tidak valid.',
        ]);

        $purchase = StorePurchase::create([
            'order_code' => 'CWP'.now()->format('ymdHis').random_int(10, 99),
            'user_id' => Auth::id(),
            'store_package_id' => $package->id,
            'package_name' => $package->name,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'amount' => $package->price,
            'payment_status' => 'pending',
            'payment_channel' => $validated['payment_channel'],
        ]);

        try {
            $payment = $doku->createPurchasePayment($purchase, [$validated['payment_channel']]);
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi.');
        }

        return redirect()->away($payment['url']);
    }

    /** Halaman status pembayaran paket (tujuan callback DOKU). */
    public function status(string $code)
    {
        $purchase = StorePurchase::with('store')
            ->where('order_code', $code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('store.onboarding.status', compact('purchase'));
    }

    /** Form setup toko — hanya bila pembelian sudah lunas & toko belum dibuat. */
    public function setup(string $code)
    {
        $purchase = $this->paidPurchase($code);

        if ($purchase->store_id) {
            return redirect()->route('store-dashboard.index');
        }

        $templates = StoreTemplate::where('is_active', true)->orderBy('sort_order')->get();

        return view('store.onboarding.setup', compact('purchase', 'templates'));
    }

    /** Simpan toko dari form setup, aktifkan, dan arahkan ke dashboard. */
    public function setupStore(StoreSetupRequest $request, string $code)
    {
        $purchase = $this->paidPurchase($code);

        if ($purchase->store_id) {
            return redirect()->route('store-dashboard.index');
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        $store = Store::create([
            'user_id' => Auth::id(),
            'store_package_id' => $purchase->store_package_id,
            'store_template_id' => $data['store_template_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'tagline' => $data['tagline'] ?? null,
            'description' => $data['description'] ?? null,
            'logo' => $data['logo'] ?? null,
            'banner' => $data['banner'] ?? null,
            'whatsapp_number' => $data['whatsapp_number'],
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'province' => $data['province'] ?? null,
            'instagram_url' => $data['instagram_url'] ?? null,
            'tiktok_url' => $data['tiktok_url'] ?? null,
            'shopee_url' => $data['shopee_url'] ?? null,
            'tokopedia_url' => $data['tokopedia_url'] ?? null,
            'primary_color' => $data['primary_color'] ?? null,
            'is_active' => true,
        ]);

        $purchase->update(['store_id' => $store->id]);

        return redirect()
            ->route('store-dashboard.index')
            ->with('success', 'Toko Anda berhasil dibuat dan aktif! Selamat datang di dashboard 🎉');
    }

    /** Ambil pembelian milik user yang sudah lunas, atau tolak akses. */
    protected function paidPurchase(string $code): StorePurchase
    {
        $purchase = StorePurchase::where('order_code', $code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        abort_unless($purchase->isPaid(), 403, 'Pembayaran paket belum lunas.');

        return $purchase;
    }

    /** Channel pembayaran DOKU dikelompokkan per grup untuk UI. */
    protected function channelGroups(): array
    {
        $groups = [];
        foreach ((array) config('doku.channels', []) as $code => $meta) {
            $groups[$meta['group'] ?? 'Lainnya'][$code] = $meta['label'] ?? $code;
        }

        return $groups;
    }
}
