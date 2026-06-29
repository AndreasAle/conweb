<?php

namespace App\Services\Store;

use App\Models\Product;
use App\Models\Store;
use App\Models\Voucher;
use Illuminate\Support\Collection;

/**
 * Keranjang berbasis session, di-scope per toko sehingga customer bisa
 * berbelanja di beberapa toko tanpa tercampur. Tidak butuh login.
 *
 * Struktur session:
 *   store_cart.{storeId}         => [productId => quantity]
 *   store_cart_voucher.{storeId} => "KODEVOUCHER"
 */
class CartService
{
    private function key(Store $store): string
    {
        return "store_cart.{$store->id}";
    }

    private function voucherKey(Store $store): string
    {
        return "store_cart_voucher.{$store->id}";
    }

    /** Map mentah [productId => qty] dari session. */
    public function raw(Store $store): array
    {
        return (array) session($this->key($store), []);
    }

    /**
     * Item keranjang yang sudah di-resolve ke produk aktif milik toko.
     * Produk yang sudah dihapus/nonaktif otomatis tersaring.
     *
     * @return Collection<int, array{product: Product, quantity: int, subtotal: int}>
     */
    public function items(Store $store): Collection
    {
        $raw = $this->raw($store);

        if (empty($raw)) {
            return collect();
        }

        $products = $store->products()->active()->whereIn('id', array_keys($raw))->get()->keyBy('id');

        return collect($raw)
            ->filter(fn ($qty, $id) => $products->has($id))
            ->map(function ($qty, $id) use ($products) {
                $product = $products->get($id);
                $qty = max(1, (int) $qty);

                return [
                    'product' => $product,
                    'quantity' => $qty,
                    'subtotal' => (int) $product->price * $qty,
                ];
            })
            ->values();
    }

    public function add(Store $store, int $productId, int $qty = 1): void
    {
        // Validasi: produk harus milik toko & aktif.
        $product = $store->products()->active()->whereKey($productId)->first();
        if (! $product) {
            return;
        }

        $cart = $this->raw($store);
        $current = (int) ($cart[$productId] ?? 0);
        $cart[$productId] = max(1, $current + max(1, $qty));

        // Hormati stok bila dilacak.
        if ($product->stock !== null) {
            $cart[$productId] = min($cart[$productId], max(1, $product->stock));
        }

        session([$this->key($store) => $cart]);
    }

    public function update(Store $store, int $productId, int $qty): void
    {
        $cart = $this->raw($store);

        if ($qty <= 0) {
            unset($cart[$productId]);
        } elseif (array_key_exists($productId, $cart)) {
            $product = $store->products()->active()->whereKey($productId)->first();
            if ($product && $product->stock !== null) {
                $qty = min($qty, max(1, $product->stock));
            }
            $cart[$productId] = $qty;
        }

        session([$this->key($store) => $cart]);
    }

    public function remove(Store $store, int $productId): void
    {
        $cart = $this->raw($store);
        unset($cart[$productId]);
        session([$this->key($store) => $cart]);
    }

    public function count(Store $store): int
    {
        return (int) array_sum($this->raw($store));
    }

    public function isEmpty(Store $store): bool
    {
        return $this->items($store)->isEmpty();
    }

    public function subtotal(Store $store): int
    {
        return (int) $this->items($store)->sum('subtotal');
    }

    // ---- Voucher ----

    public function setVoucher(Store $store, string $code): bool
    {
        $voucher = $store->vouchers()->active()
            ->whereRaw('UPPER(code) = ?', [strtoupper($code)])
            ->first();

        if (! $voucher || ! $voucher->isUsableFor($this->subtotal($store))) {
            return false;
        }

        session([$this->voucherKey($store) => $voucher->code]);

        return true;
    }

    public function getVoucher(Store $store): ?Voucher
    {
        $code = session($this->voucherKey($store));
        if (! $code) {
            return null;
        }

        $voucher = $store->vouchers()->active()
            ->whereRaw('UPPER(code) = ?', [strtoupper($code)])
            ->first();

        // Voucher jadi tidak valid (mis. subtotal turun di bawah minimum) -> abaikan.
        if (! $voucher || ! $voucher->isUsableFor($this->subtotal($store))) {
            return null;
        }

        return $voucher;
    }

    public function forgetVoucher(Store $store): void
    {
        session()->forget($this->voucherKey($store));
    }

    public function discount(Store $store): int
    {
        $voucher = $this->getVoucher($store);

        return $voucher ? $voucher->discountFor($this->subtotal($store)) : 0;
    }

    public function total(Store $store): int
    {
        return max(0, $this->subtotal($store) - $this->discount($store));
    }

    public function clear(Store $store): void
    {
        session()->forget($this->key($store));
        session()->forget($this->voucherKey($store));
    }
}
