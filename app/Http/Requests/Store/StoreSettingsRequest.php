<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Otorisasi kepemilikan ditangani middleware store.owner + controller.
        return true;
    }

    public function rules(): array
    {
        $storeId = $this->route('store') ?? optional($this->user()?->primaryStore())->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255', 'alpha_dash',
                Rule::unique('stores', 'slug')->ignore($storeId),
            ],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'whatsapp_number' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:120'],
            'province' => ['nullable', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:12'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'shopee_url' => ['nullable', 'url', 'max:255'],
            'tokopedia_url' => ['nullable', 'url', 'max:255'],
            'primary_color' => ['nullable', 'string', 'max:9'],
            'secondary_color' => ['nullable', 'string', 'max:9'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_logo' => ['nullable', 'boolean'],
            'remove_banner' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama toko',
            'slug' => 'slug toko',
            'whatsapp_number' => 'nomor WhatsApp',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.alpha_dash' => 'Slug hanya boleh huruf, angka, strip, dan garis bawah.',
            'slug.unique' => 'Slug ini sudah dipakai toko lain. Pilih yang lain.',
        ];
    }
}
