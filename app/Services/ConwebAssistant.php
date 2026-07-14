<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\PortfolioItem;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Setting;
use App\Models\WebTemplate;
use Illuminate\Support\Str;
use App\Support\Locale;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Asisten AI "Chat Us" untuk conweb.id.
 *
 * Membangun konteks (knowledge base) dari struktur & isi database lalu
 * mengirimkannya ke OpenAI sebagai grounding agar jawaban relevan dengan
 * layanan, paket, template, dan FAQ Conweb yang sebenarnya.
 */
class ConwebAssistant
{
    /**
     * Jawab pesan pengguna.
     *
     * @param  string  $message            Pesan terbaru dari pengguna.
     * @param  array   $history            Riwayat [{role:'user'|'assistant', content:string}, ...].
     * @return array{reply:string, source:string}
     */
    public function reply(string $message, array $history = []): array
    {
        $message = trim($message);
        if ($message === '') {
            return ['reply' => 'Silakan ketik pertanyaan kamu dulu ya 🙂', 'source' => 'guard'];
        }

        $key = config('services.openai.key');

        // Tanpa API key → mode fallback berbasis knowledge base (tetap berguna).
        if (empty($key)) {
            return ['reply' => $this->fallbackReply($message), 'source' => 'fallback'];
        }

        try {
            return ['reply' => $this->askOpenAI($message, $history), 'source' => 'openai'];
        } catch (\Throwable $e) {
            Log::warning('ConwebAssistant OpenAI gagal: '.$e->getMessage());

            return ['reply' => $this->fallbackReply($message), 'source' => 'fallback'];
        }
    }

    /**
     * Jawab pesan dalam konteks SATU usaha (template tertentu).
     * Chatbot jadi "asisten toko" usaha itu, bukan asisten Conweb.
     *
     * @return array{reply:string, source:string}
     */
    public function replyForTemplate(WebTemplate $template, string $message, array $history = []): array
    {
        $message = trim($message);
        if ($message === '') {
            return ['reply' => 'Silakan ketik pertanyaan kamu dulu ya 🙂', 'source' => 'guard'];
        }

        $key = config('services.openai.key');

        if (empty($key)) {
            return ['reply' => $this->templateFallbackReply($template, $message), 'source' => 'fallback'];
        }

        try {
            return [
                'reply' => $this->askOpenAI($message, $history, $this->templateSystemPrompt($template)),
                'source' => 'openai',
            ];
        } catch (\Throwable $e) {
            Log::warning('ConwebAssistant (template) OpenAI gagal: '.$e->getMessage());

            return ['reply' => $this->templateFallbackReply($template, $message), 'source' => 'fallback'];
        }
    }

    /** Panggil OpenAI Chat Completions dengan system prompt tertentu. */
    protected function askOpenAI(string $message, array $history, ?string $systemPrompt = null): string
    {
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt ?? $this->systemPrompt()],
        ];

        // Sertakan maksimal 8 pesan terakhir untuk konteks percakapan.
        foreach (array_slice($history, -8) as $turn) {
            $role = ($turn['role'] ?? '') === 'assistant' ? 'assistant' : 'user';
            $content = trim((string) ($turn['content'] ?? ''));
            if ($content !== '') {
                $messages[] = ['role' => $role, 'content' => mb_substr($content, 0, 2000)];
            }
        }

        $messages[] = ['role' => 'user', 'content' => mb_substr($message, 0, 2000)];

        $response = Http::withToken(config('services.openai.key'))
            ->timeout(30)
            ->post(rtrim(config('services.openai.base_url'), '/').'/chat/completions', [
                'model' => config('services.openai.model'),
                'temperature' => 0.4,
                'max_tokens' => 600,
                'messages' => $messages,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('OpenAI HTTP '.$response->status().': '.$response->body());
        }

        $reply = data_get($response->json(), 'choices.0.message.content');

        return trim((string) $reply) ?: $this->fallbackReply($message);
    }

    /** System prompt + knowledge base dari database. */
    protected function systemPrompt(): string
    {
        $brand = Setting::get('site.title.id', 'ConWeb ID') ?: 'ConWeb ID';
        $wa = Setting::get('contact.whatsapp.id', Setting::get('contact.whatsapp', '')) ?: '';
        $kb = $this->knowledgeBase();

        return <<<PROMPT
Kamu adalah "Chat Us", asisten AI resmi untuk {$brand} (conweb.id) — jasa pembuatan website profesional di Indonesia.

ATURAN:
- Jawab HANYA seputar Conweb: layanan, paket harga, template, domain, proses pengerjaan, pemesanan, akun, dan FAQ.
- Gunakan Bahasa Indonesia yang ramah, ringkas, dan jelas. Boleh pakai emoji secukupnya.
- Dasarkan jawaban pada DATA di bawah. Jika info tidak ada di data, katakan jujur dan arahkan ke tim Conweb{$this->waSuffix($wa)}.
- Jangan mengarang harga, fitur, atau janji yang tidak ada di data.
- Jika pengguna ingin memesan, arahkan ke halaman /pesan atau wizard /order/start.
- Jika di luar topik Conweb, tolak dengan sopan dan kembalikan ke topik website.

=== DATA CONWEB (sumber kebenaran) ===
{$kb}
=== AKHIR DATA ===
PROMPT;
    }

    protected function waSuffix(string $wa): string
    {
        return $wa !== '' ? " (WhatsApp: {$wa})" : '';
    }

    /**
     * Rangkum isi database menjadi teks ringkas untuk grounding AI.
     * Di-cache 10 menit agar tidak query tiap pesan.
     */
    public function knowledgeBase(): string
    {
        return Cache::remember('conweb_assistant_kb_'.Locale::current(), now()->addMinutes(10), function () {
            $parts = [];

            // Layanan
            $services = Service::where('is_active', true)->orderBy('sort')->get();
            if ($services->isNotEmpty()) {
                $lines = $services->map(function ($s) {
                    $feat = collect($s->features ?? [])
                        ->map(fn ($f) => is_array($f) ? ($f[Locale::current()] ?? $f['id'] ?? '') : $f)
                        ->filter()->take(5)->implode(', ');
                    $desc = \Str::limit(strip_tags((string) t($s, 'desc')), 160);

                    return '- '.t($s, 'title').': '.$desc.($feat ? " | Fitur: {$feat}" : '');
                })->implode("\n");
                $parts[] = "LAYANAN:\n".$lines;
            }

            // Paket harga
            $plans = PricingPlan::where('is_active', true)->orderBy('sort')->get();
            if ($plans->isNotEmpty()) {
                $lines = $plans->map(function ($p) {
                    $price = 'Rp'.number_format((float) $p->price, 0, ',', '.');
                    $feat = collect($p->features ?? [])->filter()->take(6)->implode(', ');
                    $badge = $p->badge ? " [{$p->badge}]" : '';

                    return "- {$p->name}{$badge}: {$price}{$p->period}".($feat ? " | {$feat}" : '');
                })->implode("\n");
                $parts[] = "PAKET & HARGA:\n".$lines;
            }

            // Template website
            $templates = WebTemplate::orderByDesc('is_featured')->orderByDesc('popularity')->take(20)->get();
            if ($templates->isNotEmpty()) {
                $lines = $templates->map(function ($tpl) {
                    $tag = \Str::limit(strip_tags((string) (t($tpl, 'tagline') ?? '')), 80);
                    $price = $tpl->price_label ? " ({$tpl->price_label})" : '';

                    return "- {$tpl->name} [{$tpl->category}/{$tpl->layout}]{$price}".($tag ? " — {$tag}" : '');
                })->implode("\n");
                $parts[] = "TEMPLATE WEBSITE:\n".$lines;
            }

            // Portofolio
            $portfolio = PortfolioItem::where('is_active', true)->orderBy('sort')->take(10)->get();
            if ($portfolio->isNotEmpty()) {
                $lines = $portfolio->map(fn ($p) => "- {$p->title} (".t($p, 'category').')')->implode("\n");
                $parts[] = "PORTOFOLIO:\n".$lines;
            }

            // FAQ
            $faqs = Faq::where('is_active', true)->orderBy('sort')->take(20)->get();
            if ($faqs->isNotEmpty()) {
                $lines = $faqs->map(function ($f) {
                    $a = \Str::limit(strip_tags((string) t($f, 'answer')), 220);

                    return 'Q: '.t($f, 'question')."\nA: ".$a;
                })->implode("\n");
                $parts[] = "FAQ:\n".$lines;
            }

            return implode("\n\n", $parts) ?: 'Belum ada data konten yang tersedia.';
        });
    }

    /**
     * Bangun profil usaha satu template — SEMI-AUTO:
     * dasar diambil otomatis dari kolom yang sudah ada (nama, kategori, tagline),
     * lalu dilengkapi field chatbot_* bila admin mengisinya.
     */
    public function templateProfile(WebTemplate $t): string
    {
        $bizName = $t->chatbot_business_name ?: $t->name;
        $parts = [];

        // Dasar (otomatis dari kolom yang ada)
        $parts[] = "Nama usaha: {$bizName}";
        $parts[] = "Bidang/kategori: {$t->category}";
        if ($tag = t($t, 'tagline')) {
            $parts[] = "Tagline: {$tag}";
        }

        // Lengkapi dari field chatbot (opsional)
        if ($t->chatbot_about) {
            $parts[] = "Tentang: ".strip_tags($t->chatbot_about);
        }
        if ($t->chatbot_offerings) {
            $parts[] = "Produk/Menu & harga:\n".strip_tags($t->chatbot_offerings);
        }
        if ($t->chatbot_hours) {
            $parts[] = "Jam operasional: {$t->chatbot_hours}";
        }
        if ($t->chatbot_location) {
            $parts[] = "Lokasi/cabang: {$t->chatbot_location}";
        }
        if ($t->chatbot_contact) {
            $parts[] = "Kontak: {$t->chatbot_contact}";
        }
        $faq = collect($t->chatbot_faq ?? [])
            ->map(fn ($f) => is_array($f) ? trim(($f['q'] ?? '').' → '.($f['a'] ?? ''), ' →') : null)
            ->filter();
        if ($faq->isNotEmpty()) {
            $parts[] = "FAQ usaha:\n- ".$faq->implode("\n- ");
        }

        return implode("\n", $parts);
    }

    /** System prompt: chatbot berperan sebagai asisten toko usaha tersebut. */
    protected function templateSystemPrompt(WebTemplate $t): string
    {
        $bizName = $t->chatbot_business_name ?: $t->name;
        $tone = $t->chatbot_tone ?: 'ramah & santai';
        $profile = $this->templateProfile($t);

        return <<<PROMPT
Kamu adalah asisten AI (customer service) untuk "{$bizName}" — sebuah usaha di bidang {$t->category}.
Ini adalah DEMO chatbot yang disertakan pada template website buatan ConWeb (conweb.id).

ATURAN:
- Berperanlah sepenuhnya sebagai asisten "{$bizName}", BUKAN asisten ConWeb. Jangan menyebut ConWeb kecuali pengguna bertanya soal template/pembuatan website.
- Gaya bahasa: {$tone}. Gunakan Bahasa Indonesia, ringkas, membantu. Emoji secukupnya.
- Jawab pertanyaan pelanggan seputar usaha ini: produk/menu, harga, jam buka, lokasi, cara pesan, dan info di DATA di bawah.
- Jika informasi tidak ada di DATA, jawab jujur dan sarankan pelanggan menghubungi kontak usaha. JANGAN mengarang harga/menu/janji.
- Jika pelanggan ingin memesan, bantu arahkan dengan ramah sesuai info kontak yang tersedia.

=== DATA USAHA "{$bizName}" (sumber kebenaran) ===
{$profile}
=== AKHIR DATA ===
PROMPT;
    }

    /** Fallback tanpa OpenAI untuk mode usaha. */
    protected function templateFallbackReply(WebTemplate $t, string $message): string
    {
        $bizName = $t->chatbot_business_name ?: $t->name;
        $profile = $this->templateProfile($t);

        return "Halo! 👋 Saya asisten *{$bizName}*.\n\nBerikut info yang saya punya:\n\n".$profile
            ."\n\nAda yang bisa saya bantu lagi? 😊";
    }

    /** Jawaban sederhana berbasis pencarian knowledge base saat OpenAI tidak tersedia. */
    protected function fallbackReply(string $message): string
    {
        $msg = mb_strtolower($message);
        $kb = $this->knowledgeBase();

        // Cari blok yang paling relevan dengan kata kunci pesan.
        $map = [
            'PAKET & HARGA' => ['harga', 'paket', 'biaya', 'tarif', 'berapa', 'price'],
            'LAYANAN' => ['layanan', 'jasa', 'service', 'bisa apa', 'fitur'],
            'TEMPLATE WEBSITE' => ['template', 'desain', 'tema', 'tampilan'],
            'PORTOFOLIO' => ['portofolio', 'portfolio', 'contoh', 'hasil'],
            'FAQ' => ['faq', 'tanya', 'cara', 'bagaimana', 'apakah', 'domain', 'bayar'],
        ];

        foreach ($map as $heading => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($msg, $kw) && str_contains($kb, $heading.':')) {
                    $block = $this->extractBlock($kb, $heading.':');
                    if ($block) {
                        return "Berikut info {$heading} di Conweb:\n\n".$block."\n\nMau saya bantu lanjut ke pemesanan? Buka halaman /pesan ya 🙂";
                    }
                }
            }
        }

        return "Halo! 👋 Saya asisten Conweb. Saya bisa bantu soal layanan, paket harga, template website, domain, dan proses pemesanan.\n\nCoba tanya misalnya: \"Berapa harga paketnya?\" atau \"Ada template apa saja?\". Untuk memesan, buka halaman /pesan.";
    }

    /** Ambil satu blok berjudul dari teks knowledge base. */
    protected function extractBlock(string $kb, string $heading): ?string
    {
        $blocks = explode("\n\n", $kb);
        foreach ($blocks as $block) {
            if (str_starts_with($block, $heading)) {
                return trim(substr($block, strlen($heading)));
            }
        }

        return null;
    }
}
