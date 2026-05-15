<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    public function __construct(private readonly ChatbotService $chatbot) {}

    /**
     * Display the dedicated chatbot page.
     */
    public function index()
    {
        return view('user.chatbot');
    }

    /**
     * Handle an incoming chat message.
     * POST /chatbot/message
     */
    public function message(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'lang'    => 'nullable|in:es,en',
            'history' => 'nullable|array|max:20',
        ]);

        $userMessage = trim($request->input('message'));
        $history     = $request->input('history', []);

        // Determine language: use client-provided lang, or auto-detect
        $lang = $request->input('lang');
        if (!$lang) {
            $lang = $this->chatbot->detectLanguage($userMessage);
        }

        $result = $this->chatbot->chat($userMessage, $lang, $history);

        return response()->json([
            'reply'   => $result['reply'],
            'lang'    => $result['lang'],
            'success' => $result['success'] ?? true,
        ]);
    }

    /**
     * Detect the language of a given text.
     * POST /chatbot/detect-lang
     */
    public function detectLang(Request $request): JsonResponse
    {
        $request->validate(['text' => 'required|string|max:500']);
        $lang = $this->chatbot->detectLanguage($request->input('text'));

        return response()->json(['lang' => $lang]);
    }
}
