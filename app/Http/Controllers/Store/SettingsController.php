<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\Concerns\InteractsWithCurrentStore;
use App\Http\Requests\Store\StoreSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    use InteractsWithCurrentStore;

    public function edit(Request $request)
    {
        $store = $this->currentStore($request);

        return view('store.dashboard.settings', compact('store'));
    }

    public function update(StoreSettingsRequest $request)
    {
        $store = $this->currentStore($request);

        $data = $request->safe()->except(['logo', 'banner', 'remove_logo', 'remove_banner']);

        // Logo
        if ($request->boolean('remove_logo') && $store->logo) {
            Storage::disk('public')->delete($store->logo);
            $data['logo'] = null;
        }
        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        // Banner
        if ($request->boolean('remove_banner') && $store->banner) {
            Storage::disk('public')->delete($store->banner);
            $data['banner'] = null;
        }
        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::disk('public')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        $store->update($data);

        return redirect()
            ->route('store-dashboard.settings')
            ->with('success', 'Pengaturan toko berhasil disimpan.');
    }
}
