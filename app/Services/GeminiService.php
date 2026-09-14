<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $defaultModel;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key') ?? env('GEMINI_API_KEY', '');
        $this->defaultModel = config('services.gemini.model') ?? env('GEMINI_MODEL', 'gemini-3.6-flash');
    }

    /**
     * Generate an intelligent, institutional, and contextual response for B2B LNG energy inquiries.
     */
    public function generateChatReply(string $userMessage, array $conversationHistory = []): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'API Key Gemini belum dikonfigurasi pada server.',
            ];
        }

        $systemInstructionText = $this->buildSystemInstruction();

        // Prepare contents array with conversation history
        $contents = [];

        // Add sanitized history (limit to last 10 turns to maintain context without overloading)
        $recentHistory = array_slice($conversationHistory, -10);
        foreach ($recentHistory as $turn) {
            $role = ($turn['role'] ?? 'user') === 'user' ? 'user' : 'model';
            $text = trim($turn['text'] ?? ($turn['content'] ?? ''));
            if (!empty($text)) {
                $contents[] = [
                    'role' => $role,
                    'parts' => [
                        ['text' => $text]
                    ]
                ];
            }
        }

        // Add current user message
        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userMessage]
            ]
        ];

        $payload = [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemInstructionText]
                ]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.6,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ];

        // Candidate models to try in order of speed and intelligence
        $modelsToTry = array_unique([
            $this->defaultModel,
            'gemini-3.5-flash-lite',
            'gemini-flash-latest',
            'gemini-3.5-flash',
            'gemini-3.1-flash-lite',
            'gemini-3.6-flash'
        ]);

        foreach ($modelsToTry as $model) {
            try {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";

                $response = Http::withoutVerifying()
                    ->timeout(18)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($url, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $replyText = $this->extractCandidateText($data);

                    if (!empty($replyText)) {
                        return [
                            'success' => true,
                            'reply' => $replyText,
                            'model' => $model,
                        ];
                    }
                }

                Log::warning("Gemini API attempt failed with model {$model}: " . $response->status() . " - " . $response->body());
            } catch (\Throwable $e) {
                Log::error("Gemini API exception with model {$model}: " . $e->getMessage());
            }
        }

        return [
            'success' => false,
            'message' => 'Mohon maaf, saat ini asisten LNG sedang mengalami kendala jaringan. Silakan coba sesaat lagi atau hubungi divisi komersial kami langsung melalui halaman kontak.',
        ];
    }

    /**
     * Extract text parts from Gemini response payload
     */
    protected function extractCandidateText(array $data): string
    {
        $parts = $data['candidates'][0]['content']['parts'] ?? [];
        $textOutput = '';

        foreach ($parts as $part) {
            if (isset($part['text'])) {
                $textOutput .= $part['text'];
            }
        }

        return trim($textOutput);
    }

    /**
     * Build rich, contextual B2B LNG corporate system instruction for Nusantara LNG
     */
    protected function buildSystemInstruction(): string
    {
        return <<<SYS
Anda adalah "Nusantara LNG Corporate AI Assistant", representasi resmi divisi komersial dan teknologi dari **PT Nusantara LNG Energi** — perusahaan penyedia solusi infrastruktur dan pasokan Liquefied Natural Gas (LNG) terintegrasi terkemuka di Indonesia.

### KARAKTER & GAYA KOMUNIKASI (B2B & INVESTOR FOCUS):
1. **Otoritatif & Profesional**: Gunakan bahasa Indonesia bisnis yang formal, jelas, dan akurat secara terminologi industri migas, energi, serta kriogenik.
2. **Berorientasi Solusi B2B**: Berikan informasi bernilai tinggi bagi calon offtaker (pembangkit listrik, smelter, kawasan industri, armada maritim) dan investor energi.
3. **Format Rapi & Terstruktur**: Gunakan bullet points, numbering, dan formatting markdown tebal (bold) untuk memudahkan pembaca menelaah data spesifikasi dan alur logistik.
4. **DILARANG MENGGUNAKAN EMOTIKON BERLEBIHAN**: Jaga nada institusional profesional, tanpa emotikon kasual.

### PENGETAHUAN KORPORASI & PRODUK NUSANTARA LNG:
- **Profil Perusahaan**: PT Nusantara LNG Energi mengoperasikan rantai pasok gas alam cair dengan kapasitas pasokan tahunan 5.2 MTPA, melayani lebih dari 40 offtaker korporat dan memiliki rekam jejak lebih dari 15 juta jam kerja aman (Zero LTI).
- **Lini Bisnis & Produk Utama**:
  1. *Bulk LNG Supply & Trading*: Pasokan kargo skala besar dengan skema kontrak Free-On-Board (FOB) dari kilang likuefaksi nasional (Bontang/Tangguh) dan Delivered-Ex-Ship (DES) ke terminal penerima/FSRU. Kontrak jangka panjang terindeks (Brent/JKM) atau spot cargo.
  2. *Small-Scale LNG & Virtual Pipeline*: Distribusi multimodal menggunakan armada ISO Tank kriogenik 20ft & 40ft (standar IMO 7 / T75) dengan vacuum insulation (holding time hingga 90 hari). Menyediakan pasokan gas untuk smelter nikel/tembaga, captive power, dan industri off-grid.
  3. *LNG Marine Bunkering*: Pengisian bahan bakar maritim rendah emisi (Ship-to-Ship dan Truck-to-Ship) di Selat Malaka & pelabuhan strategis, mematuhi standar IMO 2030/2050 (mengurangi SOx 99% dan CO2 25%).
  4. *Terminal & Regasifikasi*: Pengoperasian terminal darat dan FSRU (Floating Storage Regasification Unit), sistem vaporisasi air laut (ORV) dan ambient air, serta injeksi pipa bertekanan tinggi.
  5. *Cryogenic EPC & Konsultasi*: Rekayasa tangki kriogenik, skid regasifikasi terintegrasi, pemulihan Boil-Off Gas (BOG), dan sertifikasi keselamatan SIGTTO.
- **Spesifikasi Teknis LNG Tipikal**:
  - Kemurnian Metana (CH4): >98.5%
  - Nilai Kalor (Gross Heating Value): 1,020 - 1,140 BTU/SCF (approx. 9,500 - 10,500 kcal/kg)
  - Suhu Kriogenik Cair: -160°C hingga -162°C pada tekanan atmosferik
  - Rasio Ekspansi: 1 volume LNG = ~600 volume gas pada kondisi standar.
- **Kontak & Tindak Lanjut Komersial**:
  Jika pengunjung ingin meminta penawaran harga, studi kelayakan pasokan, atau MoU pasokan gas, arahkan mereka untuk menghubungi divisi komersial melalui halaman **Contact Us** di website atau email `commercial@nusantara-lng.com` / WhatsApp Commercial Desk `+62 811-8899-7700`.

Jawablah setiap pertanyaan mitra dan pengunjung dengan kredibel, terstruktur, dan solutif.
SYS;
    }
}
