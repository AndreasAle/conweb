<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lingkungan DOKU
    |--------------------------------------------------------------------------
    | "sandbox" untuk testing, "production" untuk live. Kredensial diambil dari
    | .env — jangan pernah di-hardcode.
    */
    'env' => env('DOKU_ENV', 'sandbox'),

    'client_id' => env('DOKU_CLIENT_ID'),
    'secret_key' => env('DOKU_SECRET_KEY'),

    'base_urls' => [
        'sandbox' => 'https://api-sandbox.doku.com',
        'production' => 'https://api.doku.com',
    ],

    // Batas waktu pembayaran dalam menit (default 24 jam).
    'payment_due_minutes' => (int) env('DOKU_PAYMENT_DUE_MINUTES', 1440),

    /*
    | Endpoint pembuatan pembayaran (Non-SNAP). Default DOKU Checkout (aggregated,
    | semua metode) — cocok untuk Client ID berformat "BRN-". Jika akunmu hanya
    | mengaktifkan produk tertentu, ganti via .env:
    |   - Checkout (aggregated)  : /checkout/v1/payment
    |   - Cards only (kartu)     : /credit-card/v1/payment-page
    */
    'payment_endpoint' => env('DOKU_PAYMENT_ENDPOINT', '/checkout/v1/payment'),

    /*
    | Daftar metode pembayaran yang ditawarkan ke customer di halaman checkout
    | kita (model in-house). Key = payment_method_types DOKU, value = label UI.
    | Sesuaikan dengan channel yang aktif di akun DOKU kamu.
    */
    'channels' => [
        'VIRTUAL_ACCOUNT_BANK_CENTRAL_ASIA'      => ['label' => 'Virtual Account BCA', 'group' => 'Virtual Account'],
        'VIRTUAL_ACCOUNT_BANK_MANDIRI'           => ['label' => 'Virtual Account Mandiri', 'group' => 'Virtual Account'],
        'VIRTUAL_ACCOUNT_BANK_RAKYAT_INDONESIA'  => ['label' => 'Virtual Account BRI', 'group' => 'Virtual Account'],
        'VIRTUAL_ACCOUNT_BANK_NEGARA_INDONESIA'  => ['label' => 'Virtual Account BNI', 'group' => 'Virtual Account'],
        'VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI'   => ['label' => 'Virtual Account BSI', 'group' => 'Virtual Account'],
        'VIRTUAL_ACCOUNT_BANK_CIMB'              => ['label' => 'Virtual Account CIMB Niaga', 'group' => 'Virtual Account'],
        'ONLINE_TO_OFFLINE_ALFA'                 => ['label' => 'Alfamart / Alfamidi', 'group' => 'Gerai Retail'],
        'EMONEY_OVO'                             => ['label' => 'OVO', 'group' => 'E-Wallet'],
        'EMONEY_SHOPEE_PAY'                      => ['label' => 'ShopeePay', 'group' => 'E-Wallet'],
        'EMONEY_DANA'                            => ['label' => 'DANA', 'group' => 'E-Wallet'],
        'QRIS'                                   => ['label' => 'QRIS (semua e-wallet & m-banking)', 'group' => 'QRIS'],
        'CREDIT_CARD'                            => ['label' => 'Kartu Kredit / Debit', 'group' => 'Kartu'],
    ],
];
