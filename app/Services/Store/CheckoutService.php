<?php

namespace App\Services\Store;

use App\Models\Store;
use App\Models\StoreOrder;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(private CartService $cart) {}

    /**
     * Buat StoreOrder + item dari isi keranjang, lalu kosongkan keranjang.
     * Mengembalikan order yang sudah tersimpan (lengkap dengan whatsapp_message).
     *
     * @param  array{customer_name:string, customer_phone:string, customer_email?:?string, customer_address?:?string, customer_note?:?string}  $customer
     */
    public function place(Store $store, array $customer): StoreOrder
    {
        $items = $this->cart->items($store);

        abort_if($items->isEmpty(), 422, 'Keranjang kosong.');

        $subtotal = (int) $items->sum('subtotal');
        $voucher = $this->cart->getVoucher($store);
        $discount = $voucher ? $voucher->discountFor($subtotal) : 0;
        $total = max(0, $subtotal - $discount);

        $order = DB::transaction(function () use ($store, $customer, $items, $subtotal, $discount, $total, $voucher) {
            $order = $store->orders()->create([
                'voucher_id' => $voucher?->id,
                'order_code' => $this->uniqueOrderCode(),
                'customer_name' => $customer['customer_name'],
                'customer_phone' => $customer['customer_phone'],
                'customer_email' => $customer['customer_email'] ?? null,
                'customer_address' => $customer['customer_address'] ?? null,
                'customer_note' => $customer['customer_note'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'checkout_channel' => 'whatsapp',
            ]);

            foreach ($items as $line) {
                $order->items()->create([
                    'product_id' => $line['product']->id,
                    'product_name' => $line['product']->name,
                    'product_price' => (int) $line['product']->price,
                    'quantity' => $line['quantity'],
                    'subtotal' => $line['subtotal'],
                ]);
            }

            if ($voucher) {
                $voucher->increment('used_count');
            }

            $order->update(['whatsapp_message' => $this->buildMessage($store, $order->fresh('items'))]);

            return $order;
        });

        $this->cart->clear($store);

        return $order->fresh('items');
    }

    private function uniqueOrderCode(): string
    {
        do {
            $code = generateOrderCode('CW-STORE');
        } while (StoreOrder::where('order_code', $code)->exists());

        return $code;
    }

    /** Susun pesan WhatsApp sesuai format yang diminta. */
    public function buildMessage(Store $store, StoreOrder $order): string
    {
        $lines = [];
        $lines[] = "Halo, saya ingin order dari website {$store->name}.";
        $lines[] = '';
        $lines[] = "Kode Order: {$order->order_code}";
        $lines[] = '';
        $lines[] = 'Detail Pesanan:';

        $i = 1;
        foreach ($order->items as $item) {
            $lines[] = "{$i}. {$item->product_name} x {$item->quantity} - ".formatRupiah($item->subtotal);
            $i++;
        }

        $lines[] = '';
        $lines[] = 'Subtotal: '.formatRupiah($order->subtotal);
        if ($order->discount_amount > 0) {
            $lines[] = 'Diskon: '.formatRupiah($order->discount_amount);
        }
        $lines[] = 'Total: '.formatRupiah($order->total);
        $lines[] = '';
        $lines[] = 'Data Customer:';
        $lines[] = "Nama: {$order->customer_name}";
        $lines[] = "No WA: {$order->customer_phone}";
        if ($order->customer_address) {
            $lines[] = "Alamat: {$order->customer_address}";
        }
        if ($order->customer_note) {
            $lines[] = "Catatan: {$order->customer_note}";
        }
        $lines[] = '';
        $lines[] = 'Mohon konfirmasi pesanan saya.';

        return implode("\n", $lines);
    }
}
