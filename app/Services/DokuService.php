<?php

namespace App\Services;

use App\Models\Order;
use App\Models\StorePurchase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * Integrasi pembayaran DOKU (model in-house: customer memilih channel di halaman
 * Conweb, lalu kita buat transaksi DOKU untuk channel tersebut).
 *
 * Mengikuti pola XenditService: ada dev-mode fallback ketika credential belum
 * diisi, sehingga flow checkout tetap bisa dites lokal sebelum DOKU live.
 */
class DokuService
{
    public function isConfigured(): bool
    {
        return filled(config('doku.client_id')) && filled(config('doku.secret_key'));
    }

    public function baseUrl(): string
    {
        $env = config('doku.env', 'sandbox');

        return config("doku.base_urls.$env", config('doku.base_urls.sandbox'));
    }

    /**
     * Buat transaksi pembayaran DOKU Checkout untuk order paket website.
     *
     * @param  array<int,string>  $channels  payment_method_types DOKU yang dipilih customer.
     * @return array{invoice_number:string, url:string}
     */
    /**
     * Pembayaran order paket website.
     *
     * @param  array<int,string>  $channels
     * @return array{invoice_number:string, url:string}
     */
    public function createPayment(Order $order, array $channels = []): array
    {
        $result = $this->createTransaction(
            $order->order_code,
            (int) $order->total_amount,
            ['id' => 'order-'.$order->id, 'name' => $order->customer_name, 'email' => $order->customer_email, 'phone' => $order->customer_phone],
            URL::route('order.thanks', ['order' => $order->order_code]),
            $channels,
            "order {$order->order_code}",
        );

        $order->update([
            'doku_invoice_number' => $result['invoice_number'],
            'doku_payment_url' => $result['url'],
            'payment_channel' => $channels[0] ?? null,
        ]);

        return $result;
    }

    /**
     * Pembayaran pembelian paket Conweb Store (self-service).
     *
     * @param  array<int,string>  $channels
     * @return array{invoice_number:string, url:string}
     */
    public function createPurchasePayment(StorePurchase $purchase, array $channels = []): array
    {
        $result = $this->createTransaction(
            $purchase->order_code,
            (int) $purchase->amount,
            ['id' => 'purchase-'.$purchase->id, 'name' => $purchase->customer_name, 'email' => $purchase->customer_email, 'phone' => $purchase->customer_phone],
            URL::route('store-onboarding.status', ['code' => $purchase->order_code]),
            $channels,
            "store purchase {$purchase->order_code}",
        );

        $purchase->update([
            'doku_invoice_number' => $result['invoice_number'],
            'doku_payment_url' => $result['url'],
            'payment_channel' => $channels[0] ?? null,
        ]);

        return $result;
    }

    /**
     * Inti pembuatan transaksi DOKU Checkout. Dipakai bersama oleh pembayaran
     * order website maupun pembelian paket toko.
     *
     * @param  array{id:string,name:string,email:string,phone:string}  $customer
     * @param  array<int,string>  $channels
     * @return array{invoice_number:string, url:string}
     */
    protected function createTransaction(string $invoiceNumber, int $amount, array $customer, string $callbackUrl, array $channels, string $logLabel): array
    {
        // Dev-mode: belum ada credential → simulasikan agar flow tetap bisa dites.
        if (! $this->isConfigured()) {
            Log::info("DOKU dev-mode: simulasi pembayaran {$logLabel} (Rp".number_format($amount, 0, ',', '.').')');

            return ['invoice_number' => $invoiceNumber, 'url' => $callbackUrl];
        }

        $target = '/checkout/v1/payment';

        $body = [
            'order' => [
                'amount' => $amount,
                'invoice_number' => $invoiceNumber,
                'currency' => 'IDR',
                'callback_url' => $callbackUrl,
            ],
            'payment' => [
                'payment_due_date' => (int) config('doku.payment_due_minutes', 1440),
            ],
            'customer' => $customer,
        ];

        if (! empty($channels)) {
            $body['payment']['payment_method_types'] = array_values($channels);
        }

        $json = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestId = (string) Str::uuid();
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');
        $signature = $this->signature($target, $json, $requestId, $timestamp);

        $response = Http::withHeaders([
            'Client-Id' => config('doku.client_id'),
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
        ])
            ->withBody($json, 'application/json')
            ->post($this->baseUrl().$target)
            ->throw()
            ->json();

        return [
            'invoice_number' => $invoiceNumber,
            'url' => data_get($response, 'response.payment.url', ''),
        ];
    }

    /**
     * Bentuk signature DOKU:
     *   HMACSHA256=base64( hmac_sha256(components, secret_key) )
     * dengan components = gabungan header + Digest (base64 sha256 body).
     */
    public function signature(string $requestTarget, string $rawBody, string $requestId, string $timestamp): string
    {
        $digest = base64_encode(hash('sha256', $rawBody, true));

        $components = 'Client-Id:'.config('doku.client_id')."\n"
            ."Request-Id:{$requestId}\n"
            ."Request-Timestamp:{$timestamp}\n"
            ."Request-Target:{$requestTarget}\n"
            ."Digest:{$digest}";

        $hmac = base64_encode(hash_hmac('sha256', $components, (string) config('doku.secret_key'), true));

        return 'HMACSHA256='.$hmac;
    }

    /**
     * Verifikasi signature notifikasi DOKU yang masuk ke webhook kita.
     */
    public function verifyNotification(string $requestTarget, string $rawBody, string $requestId, string $timestamp, string $receivedSignature): bool
    {
        $expected = $this->signature($requestTarget, $rawBody, $requestId, $timestamp);

        return hash_equals($expected, $receivedSignature);
    }
}
