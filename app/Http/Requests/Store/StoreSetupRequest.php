<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreSetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // kepemilikan purchase divalidasi di controller (paidPurchase).
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', 'alpha_dash', Rule::unique('stores', 'slug')],
            'tagline' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:2000'],
            'whatsapp_number' => ['required', 'string', 'max:25'],
            'email' => ['nullable', 'email', 'max:120'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80'],
            'province' => ['nullable', 'string', 'max:80'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'shopee_url' => ['nullable', 'url', 'max:255'],
            'tokopedia_url' => ['nullable', 'url', 'max:255'],
            'primary_color' => ['nullable', 'string', 'max:9'],
            'store_template_id' => ['nullable', 'exists:store_templates,id'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama toko wajib diisi.',
            'slug.required' => 'Slug toko wajib diisi.',
            'slug.unique' => 'Slug toko sudah dipakai toko lain. Pilih nama atau slug yang berbeda.',
            'slug.alpha_dash' => 'Slug hanya boleh huruf, angka, dan tanda hubung.',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'logo.max' => 'Ukuran logo maksimal 3 MB.',
            'banner.max' => 'Ukuran banner maksimal 4 MB.',
        ];
    }
}
