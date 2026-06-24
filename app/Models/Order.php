<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'addons' => 'array',
        'paid_at' => 'datetime',
        'wa_notified_at' => 'datetime',
        'status_updated_at' => 'datetime',
    ];

    /** Tahapan pengerjaan (mini-tracker) — urut. */
    public const WORK_STAGES = [
        'received'    => ['label' => 'Pesanan Diterima', 'desc' => 'Pesananmu sudah masuk dan sedang kami tinjau.'],
        'payment'     => ['label' => 'Konfirmasi & Pembayaran', 'desc' => 'Menunggu konfirmasi pembayaran untuk mulai pengerjaan.'],
        'design'      => ['label' => 'Desain & Setup', 'desc' => 'Tim menyiapkan desain, domain, hosting & SSL.'],
        'development' => ['label' => 'Pengembangan', 'desc' => 'Website sedang dibangun dan diisi konten.'],
        'review'      => ['label' => 'Review & Revisi', 'desc' => 'Pengecekan akhir dan revisi sesuai masukanmu.'],
        'live'        => ['label' => 'Live / Selesai', 'desc' => 'Website sudah tayang dan siap digunakan.'],
    ];

    public function template()
    {
        return $this->belongsTo(WebTemplate::class, 'web_template_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Index tahap saat ini (0-based). */
    public function stageIndex(): int
    {
        $idx = array_search($this->work_status, array_keys(self::WORK_STAGES), true);

        return $idx === false ? 0 : $idx;
    }

    public function stageLabel(): string
    {
        return self::WORK_STAGES[$this->work_status]['label'] ?? 'Pesanan Diterima';
    }

    public function progressPercent(): int
    {
        $total = count(self::WORK_STAGES) - 1;

        return $total > 0 ? (int) round(($this->stageIndex() / $total) * 100) : 0;
    }

    public function isDone(): bool
    {
        return $this->work_status === 'live';
    }
}
