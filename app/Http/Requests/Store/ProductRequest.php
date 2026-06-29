<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kepemilikan toko & produk divalidasi controller (authorizeStoreOwnership).
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash'],
            'category_id' => ['nullable', 'integer'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'price' => ['required', 'integer', 'min:0'],
            'compare_price' => ['nullable', 'integer', 'min:0', 'gte:price'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:80'],
            'weight' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_image' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama produk',
            'price' => 'harga',
            'compare_price' => 'harga coret',
        ];
    }

    public function messages(): array
    {
        return [
            'compare_price.gte' => 'Harga coret harus lebih besar atau sama dengan harga jual.',
        ];
    }
}
