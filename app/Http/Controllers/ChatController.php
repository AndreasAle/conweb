<?php

namespace App\Http\Controllers;

use App\Models\WebTemplate;
use App\Services\ConwebAssistant;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request, ConwebAssistant $assistant)
    {
        $data = $request->validate([
            'message' => 'required|string|max:2000',
            'template' => 'sometimes|nullable|string|max:120',
            'history' => 'sometimes|array|max:20',
            'history.*.role' => 'required_with:history|string|in:user,assistant',
            'history.*.content' => 'required_with:history|string|max:2000',
        ]);

        $history = $data['history'] ?? [];

        // Mode usaha: chatbot spesifik untuk satu template/usaha.
        if (! empty($data['template'])) {
            $template = WebTemplate::where('slug', $data['template'])
                ->where('is_active', true)
                ->where('chatbot_enabled', true)
                ->first();

            if ($template) {
                $result = $assistant->replyForTemplate($template, $data['message'], $history);

                return response()->json(['reply' => $result['reply'], 'source' => $result['source']]);
            }
        }

        // Mode default: asisten Conweb.
        $result = $assistant->reply($data['message'], $history);

        return response()->json(['reply' => $result['reply'], 'source' => $result['source']]);
    }

    /**
     * Serve skrip widget embed untuk dipasang di situs template.
     * Konfigurasi (nama usaha, sapaan, dll) di-bake per template.
     * URL: GET /embed/chatbot.js?t={slug}
     */
    public function embedScript(Request $request)
    {
        $slug = (string) $request->query('t', '');
        $template = WebTemplate::where('slug', $slug)
            ->where('is_active', true)
            ->where('chatbot_enabled', true)
            ->first();

        $js = view('embed.chatbot-js', [
            'template' => $template,
            'endpoint' => url('/embed/chat'),
        ])->render();

        return response($js, 200)
            ->header('Content-Type', 'application/javascript; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=300');
    }

    /**
     * API chat untuk widget embed (lintas-domain, tanpa CSRF).
     * URL: POST /embed/chat  body: {template, message, history}
     */
    public function embedSend(Request $request, ConwebAssistant $assistant)
    {
        if ($request->isMethod('options')) {
            return $this->cors(response('', 204));
        }

        $data = $request->validate([
            'message' => 'required|string|max:2000',
            'template' => 'required|string|max:120',
            'history' => 'sometimes|array|max:20',
            'history.*.role' => 'required_with:history|string|in:user,assistant',
            'history.*.content' => 'required_with:history|string|max:2000',
        ]);

        $template = WebTemplate::where('slug', $data['template'])
            ->where('is_active', true)
            ->where('chatbot_enabled', true)
            ->first();

        if (! $template) {
            return $this->cors(response()->json(['reply' => 'Maaf, asisten belum tersedia.', 'source' => 'none']));
        }

        $result = $assistant->replyForTemplate($template, $data['message'], $data['history'] ?? []);

        return $this->cors(response()->json(['reply' => $result['reply'], 'source' => $result['source']]));
    }

    /** Tambah header CORS agar bisa dipanggil dari domain situs template. */
    protected function cors($response)
    {
        return $response
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
    }
}
