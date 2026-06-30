<?php

namespace App\Console\Commands;

use App\Services\DokuService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;

/**
 * Uji koneksi & signature DOKU tanpa harus checkout beneran.
 * Pakai: php artisan doku:test  (atau: php artisan doku:test 5000)
 */
class DokuTestCommand extends Command
{
    protected $signature = 'doku:test {amount=1000 : Nominal transaksi uji (Rupiah)}';

    protected $description = 'Membuat transaksi dummy ke DOKU untuk memverifikasi credential & signature.';

    public function handle(DokuService $doku): int
    {
        if (! $doku->isConfigured()) {
            $this->warn('DOKU dev-mode: DOKU_CLIENT_ID / DOKU_SECRET_KEY belum diisi di .env.');
            $this->line('Isi credential lalu jalankan: php artisan config:clear && php artisan doku:test');

            return self::FAILURE;
        }

        $this->info('Lingkungan : '.config('doku.env'));
        $this->info('Base URL   : '.$doku->baseUrl());
        $this->info('Endpoint   : '.config('doku.payment_endpoint'));
        $this->info('Client ID  : '.config('doku.client_id'));
        $this->newLine();

        try {
            $result = $doku->createTestTransaction((int) $this->argument('amount'));
        } catch (RequestException $e) {
            $this->error('DOKU menolak request (HTTP '.optional($e->response)->status().').');
            $this->line('Response: '.optional($e->response)->body());
            $this->newLine();
            $this->warn('Cek: (1) Client ID & Secret Key benar, (2) endpoint sesuai produk yang aktif, (3) IP/akun sandbox aktif.');

            return self::FAILURE;
        } catch (\Throwable $e) {
            $this->error('Gagal: '.$e->getMessage());

            return self::FAILURE;
        }

        if ($result['url'] === '') {
            $this->warn('Transaksi terkirim tapi URL pembayaran kosong — cek storage/logs (response mentah dicatat).');

            return self::FAILURE;
        }

        $this->info('✓ Berhasil! Signature & credential valid.');
        $this->line('Payment URL: '.$result['url']);

        return self::SUCCESS;
    }
}
