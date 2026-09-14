<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ChatbotController extends Controller
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Handle incoming chat message from visitors
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1500',
            'history' => 'nullable|array|max:20',
            'history.*.role' => 'required_with:history|string|in:user,model,assistant',
            'history.*.text' => 'required_with:history|string|max:2000',
        ]);

        $ip = $request->ip() ?? 'unknown';
        $key = 'chatbot-rate-limit:' . $ip;

        // Rate limiting: max 30 requests per minute per IP
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak permintaan. Silakan tunggu {$seconds} detik sebelum mengirim pesan baru.",
            ], 429);
        }

        RateLimiter::hit($key, 60);

        $userMessage = trim($request->input('message'));
        $history = $request->input('history', []);

        $result = $this->geminiService->generateChatReply($userMessage, $history);

        if (!$result['success']) {
            return response()->json($result, 500);
        }

        return response()->json([
            'success' => true,
            'reply' => $result['reply'],
            'model' => $result['model'] ?? 'gemini-3.6-flash',
        ]);
    }

    /**
     * Get initial quick suggestions for LNG energy inquiries
     */
    public function getSuggestions(): JsonResponse
    {
        return response()->json([
            'suggestions' => [
                [
                    'label' => 'Spesifikasi & Nilai Kalor LNG',
                    'prompt' => 'Apa spesifikasi teknis gas alam cair (LNG) Nusantara LNG, termasuk kemurnian metana dan nilai kalornya?',
                ],
                [
                    'label' => 'Mekanisme Kontrak FOB & DES',
                    'prompt' => 'Jelaskan skema kontrak pasokan bulk LNG (FOB vs DES) dan mekanisme penentuan harga terindeks.',
                ],
                [
                    'label' => 'Virtual Pipeline & ISO Tank',
                    'prompt' => 'Bagaimana solusi logistik virtual pipeline ISO tank untuk menyuplai gas ke kawasan industri atau smelter off-grid?',
                ],
                [
                    'label' => 'Standar Keselamatan & QHSE',
                    'prompt' => 'Apa saja standar keselamatan kriogenik, sertifikasi SIGTTO, dan kepatuhan lingkungan yang diterapkan Nusantara LNG?',
                ],
            ]
        ]);
    }
}
