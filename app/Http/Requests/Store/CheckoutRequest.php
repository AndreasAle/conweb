<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_address' => ['nullable', 'string', 'max:1000'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_name' => 'nama',
            'customer_phone' => 'nomor WhatsApp',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_phone.regex' => 'Nomor WhatsApp hanya boleh berisi angka dan simbol telepon.',
        ];
    }
}
