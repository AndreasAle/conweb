<?php

namespace App\Http\Requests\Store;

use App\Models\Voucher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Code unik per toko (abaikan record yang sedang diedit).
        $storeId = optional($this->user()?->primaryStore())->id;
        $voucherId = $this->route('voucher')?->id;

        return [
            'code' => [
                'required', 'string', 'max:40', 'alpha_dash',
                Rule::unique('vouchers', 'code')
                    ->where(fn ($q) => $q->where('store_id', $storeId))
                    ->ignore($voucherId),
            ],
            'type' => ['required', Rule::in([Voucher::TYPE_PERCENTAGE, Voucher::TYPE_FIXED])],
            'value' => ['required', 'integer', 'min:1', $this->input('type') === Voucher::TYPE_PERCENTAGE ? 'max:100' : 'max:100000000'],
            'max_discount' => ['nullable', 'integer', 'min:0'],
            'min_order_amount' => ['nullable', 'integer', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'kode voucher',
            'value' => 'nilai diskon',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'Kode voucher ini sudah ada di toko Anda.',
            'value.max' => 'Untuk tipe persentase, nilai maksimal 100.',
            'end_date.after_or_equal' => 'Tanggal berakhir tidak boleh sebelum tanggal mulai.',
        ];
    }
}
