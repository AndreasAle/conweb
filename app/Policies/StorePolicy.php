<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    /** Admin Conweb boleh atas semua toko. */
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_admin ? true : null;
    }

    public function view(User $user, Store $store): bool
    {
        return $this->owns($user, $store);
    }

    public function update(User $user, Store $store): bool
    {
        return $this->owns($user, $store);
    }

    public function delete(User $user, Store $store): bool
    {
        return $this->owns($user, $store);
    }

    /** Pengecekan kepemilikan dasar; dipakai juga untuk produk/order/voucher. */
    public function owns(User $user, Store $store): bool
    {
        return $store->user_id === $user->id;
    }
}
