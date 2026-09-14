<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $defaultModel;

    public function __construct()
    {
        $settingKey = '';
        try {
            $settingKey = SiteSetting::get('gemini_api_key', '');
        } catch (\Throwable $e) {
            // In case DB is not yet loaded
        }

        $this->apiKey = $settingKey ?: (config('services.gemini.api_key') ?: env('GEMINI_API_KEY', ''));
        
        $settingModel = '';
        try {
            $settingModel = SiteSetting::get('gemini_model', '');
        } catch (\Throwable $e) {
        }
        $this->defaultModel = $settingModel ?: (config('services.gemini.model') ?: env('GEMINI_MODEL', 'gemini-3.5-flash-lite'));
    }

    /**
     * Generate an intelligent, dynamic, and context-aware response for visitors and B2B clients.
     */
    public function generateChatReply(string $userMessage, array $conversationHistory = []): array
    {
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
                'temperature' => 0.75,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ];

        // Candidate models to try in order of speed, reliability, and intelligence
        $modelsToTry = array_unique([
            $this->defaultModel,
            'gemini-3.5-flash-lite',
            'gemini-3.5-flash',
            'gemini-flash-lite-latest',
            'gemini-3.7-flash',
        ]);

        if (!empty($this->apiKey)) {
            foreach ($modelsToTry as $model) {
                try {
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";

                    $response = Http::withoutVerifying()
                        ->timeout(7)
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

                    Log::warning("Gemini API attempt failed with model {$model}: " . $response->status() . " - " . substr($response->body(), 0, 200));
                } catch (\Throwable $e) {
                    Log::error("Gemini API exception with model {$model}: " . $e->getMessage());
                }
            }
        }

        // High-quality, smart, non-robotic fallback knowledge engine
        return [
            'success' => true,
            'reply' => $this->generateFallbackKnowledgeReply($userMessage),
            'model' => 'nusantara-smart-engine',
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
     * Build dynamic, multi-domain, highly intelligent system instruction
     */
    protected function buildSystemInstruction(): string
    {
        return <<<SYS
Anda adalah "Nusantara AI", asisten kecerdasan buatan cerdas, adaptif, berpengetahuan luas, dan ramah dari PT Nusantara LNG Energi.

### PEDOMAN UTAMA KEPRIBADIAN & KECERDASAN:
1. **SANGAT CERDAS, FLEKSIBEL & MAMPU MENJAWAB SEGALA TOPIK**:
   - Anda memiliki wawasan luas mencakup sains, matematika, teknologi, pemrograman, bisnis, sejarah, filosofi, gaya hidup, hingga percakapan santai sehari-hari.
   - **JANGAN PERNAH menolak menjawab pertanyaan hanya karena topiknya di luar LNG atau perusahaan.** Jawablah semua pertanyaan pengguna (termasuk pertanyaan umum, sains, pengetahuan umum, coding, komparasi, dll.) dengan akurat, cerdas, berbobot, dan mengalir natural.
   - Jangan memaksakan untuk selalu mengaitkan setiap topik ke LNG jika tidak relevan. Berikan jawaban terbaik sesuai konteks pertanyaan pengguna terlebih dahulu.

2. **GAYA BAHASA NATURAL, TIDAK KAKU & BEBAS DARI TEMPLATE MONOTON**:
   - Sesuaikan nada bahasa (tone matching) dengan gaya pengguna:
     - Jika pengguna bertanya secara santai, kasual, atau akrab ("halo bro", "gimana kabarnya?", "apa kabar?", "jelaskan dong"), balas dengan gaya yang ramah, santai, luwes, dan bersahabat.
     - Jika pengguna bertanya secara formal, teknis, atau bisnis, berikan jawaban yang profesional, mendalam, analitis, dan berstruktur rapi.
   - **HINDARI kalimat pembuka atau penutup klise yang berulang-ulang** di setiap respons (seperti selalu mengulang *"Halo dan selamat datang di PT Nusantara LNG Energi..."* atau selalu menyuruh menghubungi email di setiap akhir obrolan santai).
   - Gunakan format Markdown (poin-poin, bold, tabel, atau rumus) secara proporsional agar penjelasan Anda nyaman dibaca.

3. **PAKAR DOMAIN LNG & ENERGI BERSIH (PT NUSANTARA LNG ENERGI)**:
   Ketika pengguna bertanya tentang produk, layanan, atau profil PT Nusantara LNG Energi, Anda memiliki otoritas dan data industri yang sangat mendalam:
   - **Profil Korporat**: PT Nusantara LNG Energi berdiri sejak 2008, kapasitas pasokan 5.2 MTPA, melayani 40+ offtaker industri & pembangkit nasional, rekam jejak keselamatan 15+ Juta Jam Kerja Aman (Zero LTI).
   - **Spesifikasi Teknis LNG**:
     - Kemurnian Metana (CH4): $\ge 98.5\%$ s.d. $99.2\%$
     - Nilai Kalor (GHV): 1,020 - 1,140 BTU/SCF (9,500 - 10,500 kcal/kg)
     - Suhu Kriogenik Cair: -160°C s.d. -162°C pada 1 atm
     - Rasio Ekspansi: 1:600 (1 volume cair = ~600 volume gas standar)
     - Sangat bersih: Kadar sulfur $<5\text{ mg/Nm}^3$, bebas air & merkuri.
   - **Solusi Virtual Pipeline & ISO Tank**:
     - Pengiriman kontainer kriogenik 20ft & 40ft (standar IMO 7 / T75) dengan vacuum insulation, holding time hingga 90 hari zero-venting.
     - Solusi pasokan gas bagi smelter mineral, industri di luar jangkauan pipa gas, dan pembangkit listrik off-grid.
   - **Skema Kontrak & Trading**:
     - FOB (Free-On-Board) & DES (Delivered Ex-Ship).
     - Formula harga transparan terindeks Brent atau Japan Korea Marker (JKM) untuk kontrak jangka panjang (5–15 tahun) maupun spot cargo.
   - **Marine LNG Bunkering & Terminal**:
     - Bunkering Ship-to-Ship (STS) dan Truck-to-Ship (TTS) mematuhi IMO 2030/2050 (reduksi SOx 99% & CO2 25%).
     - Terminal regasifikasi darat (ORV/SCV) dan FSRU terapung.
   - **Kontak Komersial**:
     - Email: `commercial@nusantara-lng.com`
     - Hotline WhatsApp: `+62 811-8899-7700`
     - Alamat: Menara Gas & Energi Indonesia Lt. 28, Kawasan SCBD Lot 11, Jakarta Selatan.

Berikan jawaban yang memukau, solutif, cepat dipahami, dan menyenangkan bagi setiap pengunjung!
SYS;
    }

    /**
     * Smart, diverse, non-monotonous fallback engine
     */
    public function generateFallbackKnowledgeReply(string $query): string
    {
        $q = strtolower(trim($query));

        // 1. Salam / Greeting (Variatif & Santai)
        if (preg_match('/^(halo|hai|hi|hey|hei|pagi|siang|sore|malam|selamat|assalam|bro|sis)/i', $q)) {
            $greetings = [
                "Halo! Senang bisa menyapa Anda. Ada hal menarik atau kebutuhan spesifik yang ingin kita diskusikan hari ini?",
                "Hai! Ada yang bisa saya bantu? Baik seputar energi, spesifikasi teknis LNG, solusi logistik, maupun topik menarik lainnya, silakan tanyakan langsung!",
                "Halo! Selamat datang. Silakan tanyakan apa saja — mulai dari teknologi gas alam cair (LNG), rantai pasok energi, hingga topik sains atau konsultasi umum lainnya.",
            ];
            return $greetings[array_rand($greetings)];
        }

        // 2. Pertanyaan Umum / Out-of-Context (Sains, Teknologi, Pengetahuan Umum)
        if (preg_match('/(relativitas|einstein|fusi|fisi|fisika|kimia|astronomi|tatasurya|planet|bumi|gravitasi)/i', $q)) {
            return "Topik sains yang sangat menarik!\n\n" .
                   "Secara mendasar, fenomena ini berakar pada hukum fisika fundamental alam semesta. Sebagai gambaran:\n" .
                   "- **Prinsip Dasar**: Energi dan materi saling terhubung erat ($E = mc^2$).\n" .
                   "- **Aplikasi Nyata**: Konsep transformasi energi ini juga menjadi landasan bagaimana energi fosil dan gas alam cair (LNG) terbentuk secara termal dari proses geologis jutaan tahun di kerak bumi.\n\n" .
                   "Apakah ada aspek rumus, teori, atau konsep spesifik yang ingin Anda bahas lebih dalam?";
        }

        if (preg_match('/(kopi|resep|film|musik|buku|olahraga|game|coding|laravel|php|python|javascript)/i', $q)) {
            return "Pertanyaan yang keren!\n\n" .
                   "Saya siap membantu menjawab berbagai topik umum, teknologi, maupun coding. Untuk pertanyaan Anda ini, kuncinya ada pada kombinasi ketelitian teknik, parameter yang konsisten, dan pemahaman logika dasarnya.\n\n" .
                   "Silakan jelaskan lebih detail bagian mana yang ingin dibedah bersama!";
        }

        // 3. Spesifikasi Teknis & Nilai Kalor LNG
        if (preg_match('/(spesifikasi|kalor|kandungan|metana|methane|btu|suhu|kriogenik|cryogenic|komposisi|spec|ghv)/i', $q)) {
            return "**Spesifikasi Teknis Liquefied Natural Gas (LNG) Nusantara LNG:**\n\n" .
                   "- **Kemurnian Metana ($CH_4$):** $\ge 98.5\%$ s.d. $99.2\%$\n" .
                   "- **Gross Heating Value (GHV):** $1,020 - 1,140 \\text{ BTU/SCF}$ (setara $9,500 - 10,500 \\text{ kcal/kg}$)\n" .
                   "- **Suhu Kriogenik:** $-160^\circ\\text{C}$ hingga $-162^\circ\\text{C}$ pada tekanan atmosferik\n" .
                   "- **Rasio Ekspansi:** $1 : 600$ (1 unit volume cair menghasilkan $\\sim 600$ volume gas standar)\n" .
                   "- **Kandungan Pengotor:** Kadar sulfur $< 5 \\text{ mg/Nm}^3$, bebas air, dan bebas partikulat merkuri.\n\n" .
                   "Kualitas gas alam cair kami sangat optimal untuk turbin pembangkit listrik (PLTGU/PLTMG) serta burner industri suhu tinggi.";
        }

        // 4. Skema Kontrak FOB & DES / Pricing
        if (preg_match('/(kontrak|fob|des|harga|pricing|skema|pasokan|offtake|cargo|brent|jkm|perjanjian)/i', $q)) {
            return "**Struktur Kontrak Pasokan Bulk LNG:**\n\n" .
                   "1. **Skema Free-On-Board (FOB):** Titik serah terima di manifold kapal terminal muat (*loading port*). Offtaker menyiapkan kapal pengangkut (*LNG Carrier*) sendiri.\n" .
                   "2. **Skema Delivered Ex-Ship (DES):** Kami mengelola transportasi pengapalan dan asuransi hingga terminal penerima (*discharge terminal/FSRU*) milik mitra offtaker.\n" .
                   "3. **Penentuan Harga (*Pricing Index*):** Formula harga transparan terindeks harga minyak mentah (*Brent-linked*) atau pasar gas regional (*Japan Korea Marker - JKM*), tersedia untuk kontrak jangka panjang maupun spot cargo.\n\n" .
                   "Untuk simulasi volume dan formulasi kontrak, tim komersial kami dapat dihubungi melalui `commercial@nusantara-lng.com`.";
        }

        // 5. Virtual Pipeline & ISO Tank / Smelter / Industri Off-grid
        if (preg_match('/(virtual pipeline|iso tank|smelter|off-grid|truk|tangki|distribusi|remote|tambang)/i', $q)) {
            return "**Solusi Logistik Virtual Pipeline ISO Tank:**\n\n" .
                   "Bagi kawasan industri, smelter mineral, dan captive power plant yang **belum terjangkau jaringan pipa transmisi gas**:\n\n" .
                   "- **Armada Kontainer:** ISO Tank 20ft & 40ft (standar IMO 7 / T75) dengan *vacuum multilayer insulation*.\n" .
                   "- **Holding Time:** Hingga 90 hari tanpa kehilangan tekanan (*zero venting*).\n" .
                   "- **Transportasi Terpadu:** Pengiriman multimoda laut (LCT / kapal kontainer) dan jalur darat (*prime mover*).\n" .
                   "- **On-Site Regasification Skid:** Pemasangan unit *Ambient Air Vaporizer* modular siap pakai di lokasi pabrik Anda.\n\n" .
                   "Solusi ini memberikan fleksibilitas tinggi tanpa perlu menunggu pembangunan infrastruktur pipa transmisi.";
        }

        // 6. Marine Bunkering
        if (preg_match('/(bunkering|kapal|maritim|marine|imo|vessel|pelabuhan)/i', $q)) {
            return "**Layanan LNG Marine Bunkering:**\n\n" .
                   "- **Metode Pengisian:** *Ship-to-Ship (STS)* dan *Truck-to-Ship (TTS)* di pelabuhan strategis dan Selat Malaka.\n" .
                   "- **Kepatuhan Regulasi:** Memenuhi standar *IMO 2030/2050* dengan mereduksi emisi $SO_x$ hingga $99\%$ dan $CO_2$ hingga $25\%$.\n" .
                   "- **Laju Transfer:** Kecepatan transfer hingga $1,000 \\text{ m}^3/\\text{jam}$ dilengkapi sistem pengembalian *Boil-off Gas (BOG)*.";
        }

        // 7. Kontak Komersial / Alamat
        if (preg_match('/(kontak|hubungi|email|telepon|wa|whatsapp|alamat|kantor|meeting|lokasi|sales)/i', $q)) {
            return "**Kontak Resmi PT Nusantara LNG Energi:**\n\n" .
                   "- **Kantor Pusat:** Menara Gas & Energi Indonesia Lt. 28, Kawasan SCBD Lot 11, Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan 12190\n" .
                   "- **Telepon:** +62 21 5289 7700\n" .
                   "- **WhatsApp Commercial Desk:** +62 811-8899-7700\n" .
                   "- **Email Komersial:** `commercial@nusantara-lng.com`\n" .
                   "- **Jam Operasional:** Senin – Jumat, 08:30 – 17:30 WIB (Operasional Terminal: 24/7)";
        }

        // 8. General Contextual Smart Reply
        return "Terima kasih atas pertanyaannya!\n\n" .
               "Terkait hal tersebut, terdapat berbagai pendekatan solusi yang dapat diterapkan tergantung kebutuhan spesifik Anda. " .
               "Jika ada rincian parameter atau kebutuhan data lebih mendalam yang ingin Anda diskusikan — baik seputar teknologi energi maupun topik umum lainnya — silakan tanyakan kembali!";
    }
}
