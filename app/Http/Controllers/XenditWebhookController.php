<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request, FonnteService $fonnte)
    {
        $expectedToken = config('services.xendit.callback_token');

        if ($expectedToken && $request->header('X-Callback-Token') !== $expectedToken) {
            return response()->json(['message' => 'Invalid callback token'], 403);
        }

        $invoiceId = $request->input('id');
        $status = $request->input('status');

        $order = Order::where('xendit_invoice_id', $invoiceId)->first();

        if (! $order) {
            Log::warning("Xendit webhook: no order found for invoice {$invoiceId}");

            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status === 'PAID' || $status === 'SETTLED') {
            $order->update(['payment_status' => 'paid', 'paid_at' => now()]);

            $message = "Halo {$order->customer_name}, terima kasih! Pembayaran untuk domain {$order->domain_name}{$order->domain_tld} sudah kami terima.\n\nWebsite Anda sedang kami siapkan dan akan segera live. Kode pesanan: {$order->order_code}.";

            $sent = $fonnte->sendMessage($order->customer_phone, $message);
            $order->update(['wa_notified_at' => now()]);

            if (! $sent) {
                Log::info("Order {$order->order_code} marked paid; WA notify is in dev-mode (no FONNTE_TOKEN set).");
            }
        } elseif ($status === 'EXPIRED') {
            $order->update(['payment_status' => 'expired']);
        } elseif ($status === 'FAILED') {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'ok']);
    }
}
