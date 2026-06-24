<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class XenditService
{
    /**
     * Create a Xendit invoice for the order. Falls back to a local dev-mode
     * "invoice" (no external call) when no API key is configured yet, so the
     * checkout flow stays fully testable before real Xendit credentials exist.
     *
     * @return array{id: string, url: string}
     */
    public function createInvoice(Order $order): array
    {
        $secretKey = config('services.xendit.secret_key');

        if (! $secretKey) {
            Log::info("Xendit dev-mode: would create invoice for order {$order->order_code} (Rp".number_format($order->total_amount, 0, ',', '.').')');

            $devInvoiceId = 'dev-'.$order->order_code;
            $order->update(['xendit_invoice_id' => $devInvoiceId]);

            return [
                'id' => $devInvoiceId,
                'url' => URL::route('order.thanks', ['dev' => 1, 'order' => $order->order_code]),
            ];
        }

        $response = Http::withBasicAuth($secretKey, '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $order->order_code,
                'amount' => $order->total_amount,
                'payer_email' => $order->customer_email,
                'description' => "Pembayaran domain {$order->domain_name}{$order->domain_tld} — ".($order->template?->name ?? 'ConWeb'),
                'success_redirect_url' => URL::route('order.thanks', ['order' => $order->order_code]),
                'failure_redirect_url' => URL::route('order-wizard.checkout'),
            ])
            ->throw()
            ->json();

        $order->update(['xendit_invoice_id' => $response['id'] ?? null]);

        return [
            'id' => $response['id'] ?? '',
            'url' => $response['invoice_url'] ?? '',
        ];
    }
}
