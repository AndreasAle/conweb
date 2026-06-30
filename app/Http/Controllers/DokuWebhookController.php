<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StorePurchase;
use App\Services\DokuService;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Menerima notifikasi (HTTP Notification) dari DOKU. Status "paid" HANYA
 * ditetapkan dari sini (bukan dari redirect browser), dengan verifikasi
 * signature + idempotency agar webhook ganda tidak memproses order dua kali.
 */
class DokuWebhookController extends Controller
{
    public function handle(Request $request, DokuService $doku, FonnteService $fonnte)
    {
        $raw = $request->getContent();

        // Verifikasi signature — wajib saat credential ada (production/sandbox).
        if ($doku->isConfigured()) {
            $valid = $doku->verifyNotification(
                '/webhooks/doku',
                $raw,
                (string) $request->header('Request-Id'),
                (string) $request->header('Request-Timestamp'),
                (string) $request->header('Signature'),
            );

            if (! $valid) {
                Log::warning('DOKU webhook: signature tidak valid', [
                    'invoice' => $request->input('order.invoice_number'),
                ]);

                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        $invoiceNumber = $request->input('order.invoice_number');
        $status = strtoupper((string) $request->input('transaction.status'));
        $payload = $request->all();

        // 1) Order paket website.
        $order = Order::where('doku_invoice_number', $invoiceNumber)
            ->orWhere('order_code', $invoiceNumber)
            ->first();

        if ($order) {
            return $this->handleOrder($order, $status, $payload, $fonnte);
        }

        // 2) Pembelian paket Conweb Store (self-service).
        $purchase = StorePurchase::where('doku_invoice_number', $invoiceNumber)
            ->orWhere('order_code', $invoiceNumber)
            ->first();

        if ($purchase) {
            return $this->handlePurchase($purchase, $status, $payload, $fonnte);
        }

        Log::warning("DOKU webhook: transaksi tidak ditemukan untuk invoice {$invoiceNumber}");

        return response()->json(['message' => 'Transaction not found'], 404);
    }

    /** @param  array<string,mixed>  $payload */
    protected function handleOrder(Order $order, string $status, array $payload, FonnteService $fonnte)
    {
        $order->update(['raw_callback' => $payload]);

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'already processed']);
        }

        if (in_array($status, ['SUCCESS', 'PAID', 'SETTLEMENT'], true)) {
            $order->update(['payment_status' => 'paid', 'paid_at' => now()]);

            $message = "Halo {$order->customer_name}, terima kasih! Pembayaran untuk domain {$order->domain_name}{$order->domain_tld} sudah kami terima.\n\nWebsite Anda sedang kami siapkan dan akan segera live. Kode pesanan: {$order->order_code}.";

            $fonnte->sendMessage($order->customer_phone, $message);
            $order->update(['wa_notified_at' => now()]);
        } elseif (in_array($status, ['EXPIRED', 'EXPIRE'], true)) {
            $order->update(['payment_status' => 'expired']);
        } elseif (in_array($status, ['FAILED', 'FAILURE', 'CANCEL', 'CANCELLED', 'VOID'], true)) {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'ok']);
    }

    /** @param  array<string,mixed>  $payload */
    protected function handlePurchase(StorePurchase $purchase, string $status, array $payload, FonnteService $fonnte)
    {
        $purchase->update(['raw_callback' => $payload]);

        if ($purchase->payment_status === 'paid') {
            return response()->json(['message' => 'already processed']);
        }

        if (in_array($status, ['SUCCESS', 'PAID', 'SETTLEMENT'], true)) {
            $purchase->update(['payment_status' => 'paid', 'paid_at' => now()]);

            $message = "Halo {$purchase->customer_name}, pembayaran paket {$purchase->package_name} sudah kami terima ✅\n\nSilakan buka akun Anda dan klik \"Lengkapi Data Toko\" untuk mengaktifkan toko online Anda. Kode: {$purchase->order_code}.";

            $fonnte->sendMessage($purchase->customer_phone, $message);
        } elseif (in_array($status, ['EXPIRED', 'EXPIRE'], true)) {
            $purchase->update(['payment_status' => 'expired']);
        } elseif (in_array($status, ['FAILED', 'FAILURE', 'CANCEL', 'CANCELLED', 'VOID'], true)) {
            $purchase->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'ok']);
    }
}
