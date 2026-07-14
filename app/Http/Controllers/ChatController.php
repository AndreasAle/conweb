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
}
