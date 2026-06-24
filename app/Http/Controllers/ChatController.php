<?php

namespace App\Http\Controllers;

use App\Services\ConwebAssistant;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request, ConwebAssistant $assistant)
    {
        $data = $request->validate([
            'message' => 'required|string|max:2000',
            'history' => 'sometimes|array|max:20',
            'history.*.role' => 'required_with:history|string|in:user,assistant',
            'history.*.content' => 'required_with:history|string|max:2000',
        ]);

        $result = $assistant->reply($data['message'], $data['history'] ?? []);

        return response()->json([
            'reply' => $result['reply'],
            'source' => $result['source'],
        ]);
    }
}
