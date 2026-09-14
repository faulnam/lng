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
        $this->defaultModel = $settingModel ?: (config('services.gemini.model') ?: env('GEMINI_MODEL', 'gemini-3.6-flash'));
    }

    /**
     * Generate an intelligent, institutional, and contextual response for B2B LNG energy inquiries.
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
                'temperature' => 0.6,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ];

        // Candidate models to try in order of speed and stability
        $modelsToTry = array_unique([
            $this->defaultModel,
            'gemini-3.6-flash',
            'gemini-3.5-flash',
            'gemini-3.5-flash-lite',
            'gemini-flash-lite-latest',
            'gemini-3.7-flash',
        ]);

        if (!empty($this->apiKey)) {
            foreach ($modelsToTry as $model) {
                try {
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";

                    $response = Http::withoutVerifying()
                        ->timeout(10)
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
        }

        // Seamless, high-quality institutional fallback knowledge engine
        return [
            'success' => true,
            'reply' => $this->generateFallbackKnowledgeReply($userMessage),
            'model' => 'nusantara-knowledge-engine',
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
     * Rich rule-based & semantic fallback knowledge engine for Nusantara LNG
     */
    public function generateFallbackKnowledgeReply(string $query): string
    {
        $q = strtolower(trim($query));

        // 1. Salam / Greeting
        if (preg_match('/^(halo|hai|hi|hello|pagi|siang|sore|malam|selamat|assalam)/i', $q)) {
            return "Halo dan selamat datang di **PT Nusantara LNG Energi**.\n\nSaya adalah Asisten AI Korporat kami. Saya dapat membantu memberikan informasi mengenai:\n- **Spesifikasi Teknis & Nilai Kalor LNG**\n- **Skema Kontrak Pasokan (FOB & DES)**\n- **Logistik Virtual Pipeline & ISO Tank**\n- **Solusi LNG Bunkering Maritim & Terminal Regasifikasi**\n- **Prosedur Offtake & Kontak Komersial**\n\nAda yang dapat kami bantu untuk kebutuhan energi industri atau kemitraan bisnis Anda?";
        }

        // 2. Spesifikasi Teknis & Nilai Kalor
        if (preg_match('/(spesifikasi|kalor|kandungan|metana|methane|btu|suhu|kriogenik|cryogenic|komposisi|spec)/i', $q)) {
            return "**Spesifikasi Teknis Liquefied Natural Gas (LNG) PT Nusantara LNG Energi:**\n\n" .
                   "- **Kemurnian Metana ($CH_4$):** $\\ge 98.5\\%$ s.d. $99.2\\%$\n" .
                   "- **Gross Heating Value (GHV):** $1,020 - 1,140 \\text{ BTU/SCF}$ (setara $9,500 - 10,500 \\text{ kcal/kg}$)\n" .
                   "- **Suhu Kriogenik:** $-160^\\circ\\text{C}$ hingga $-162^\\circ\\text{C}$ pada tekanan atmosferik\n" .
                   "- **Rasio Ekspansi Volume:** $1 : 600$ (1 volume cair menghasilkan $\\sim 600$ volume gas standar)\n" .
                   "- **Kandungan Pengotor:** Kadar sulfur $< 5 \\text{ mg/Nm}^3$, bebas kandungan air, dan bebas partikulat merkuri.\n\n" .
                   "Gas alam cair kami memenuhi standar mutu internasional dan spesifikasi transmisi migas nasional untuk turbin pembangkit listrik dan burner industri bersuhu tinggi.";
        }

        // 3. Skema Kontrak FOB & DES / Pricing
        if (preg_match('/(kontrak|fob|des|harga|pricing|skema|pasokan|offtake|cargo|brent|jkm|perjanjian)/i', $q)) {
            return "**Mekanisme & Skema Kontrak Pasokan Bulk LNG:**\n\n" .
                   "PT Nusantara LNG Energi menyediakan fleksibilitas struktur komersial bagi mitra offtaker:\n\n" .
                   "1. **Skema Free-On-Board (FOB):**\n" .
                   "   - Titik serah terima di manifold kapal terminal muat (*loading port*).\n" .
                   "   - Offtaker menyediakan armada kapal pengangkut (*LNG Carrier*) sendiri.\n\n" .
                   "2. **Skema Delivered Ex-Ship (DES):**\n" .
                   "   - Nusantara LNG bertanggung jawab atas pengapalan dan asuransi hingga terminal penerima (*discharge terminal/FSRU*) milik offtaker.\n\n" .
                   "3. **Struktur Penentuan Harga (*Pricing Index*):**\n" .
                   "   - Formula harga transparan berbasis indeks global (*Brent-linked* atau *Japan Korea Marker - JKM*) serta opsi *fixed slope* untuk kontrak jangka panjang (5–15 tahun) maupun *spot cargo*.\n\n" .
                   "Untuk simulasi volume dan formulasi kontrak, silakan hubungi tim komersial kami di `commercial@nusantara-lng.com`.";
        }

        // 4. Virtual Pipeline & ISO Tank / Smelter / Industri Off-grid
        if (preg_match('/(virtual pipeline|iso tank|smelter|off-grid|truk|tangki|distribusi|remote|tambang)/i', $q)) {
            return "**Solusi Logistik Small-Scale & Virtual Pipeline ISO Tank:**\n\n" .
                   "Untuk kawasan industri, smelter mineral, dan captive power plant yang **belum terjangkau jaringan pipa pipa transmisi gas**, kami menghadirkan solusi *Virtual Pipeline*:\n\n" .
                   "- **Armada Kontainer Kriogenik:** Menggunakan ISO Tank Container 20ft & 40ft (standar IMO 7 / T75) dengan *vacuum multilayer insulation*.\n" .
                   "- **Holding Time:** Hingga 90 hari tanpa kehilangan tekanan (*zero venting*).\n" .
                   "- **Multimodal Transport:** Distribusi terpadu melalui jalur laut (LCT / tongkang kontainer) dan truk darat (*prime mover*).\n" .
                   "- **On-Site Vaporizer Skid:** Kami menyediakan instalasi stasiun regasifikasi (*Ambient Air Vaporizer*) siap pakai (*plug-and-play*) di lokasi pabrik Anda.\n\n" .
                   "Solusi ini memangkas biaya modal pipa transmisi dan menjamin ketersediaan energi bersih secara kontinu.";
        }

        // 5. Keselamatan, QHSE & Standar SIGTTO
        if (preg_match('/(keselamatan|safety|sigtto|qhse|lingkungan|emisi|zero lti|sertifikasi|standar)/i', $q)) {
            return "**Standar Keselamatan Kriogenik & Kepatuhan QHSE:**\n\n" .
                   "Keselamatan operasional dan integritas aset adalah prioritas tertinggi PT Nusantara LNG Energi:\n\n" .
                   "- **Kepatuhan Internasional:** Mengadopsi protokol **SIGTTO** (*Society of International Gas Tanker and Terminal Operators*) dan OCIMF dalam setiap operasi transfer kriogenik.\n" .
                   "- **Sistem Proteksi Otomatis:** Dilengkapi *Emergency Release Systems* (ERS), *Emergency Shutdown Level 2* (ESD-2), serta deteksi kebocoran gas metana inframerah dan sensor kriogenik.\n" .
                   "- **Rekam Jejak Operasional:** Telah mencatatkan lebih dari **15 Juta Jam Kerja Aman (Zero LTI)** secara berturut-turut.\n" .
                   "- **Sertifikasi Manajemen Terpadu:** ISO 9001 (Mutu), ISO 14001 (Lingkungan), dan ISO 45001 (K3).\n" .
                   "- **Dukungan Dekarbonisasi:** Emisi gas buang LNG menghasilkan $0\\%$ emisi partikulat jelaga (PM), mereduksi $SO_x$ hingga $99\\%$, dan menurunkan $CO_2$ hingga $25\\%$ dibandingkan bahan bakar minyak berat (HFO/MFO).";
        }

        // 6. Marine Bunkering
        if (preg_match('/(bunkering|kapal|maritim|marine|imo|vessel|pelabuhan)/i', $q)) {
            return "**Layanan LNG Marine Bunkering:**\n\n" .
                   "Nusantara LNG menyediakan pengisian bahan bakar gas alam cair untuk armada maritim ramah lingkungan:\n\n" .
                   "- **Metode Bunkering:** *Ship-to-Ship (STS)* menggunakan kapal bunker khusus dan *Truck-to-Ship (TTS)* untuk kapal penyeberangan serta tugboat di pelabuhan strategis.\n" .
                   "- **Kepatuhan IMO:** Memenuhi regulasi *IMO 2030/2050 GHG Reduction Targets* dan pembatasan emisi belerang di area ECA (*Emission Control Area*).\n" .
                   "- **Kecepatan Transfer:** Laju alir pengisian termonitor hingga $1,000 \\text{ m}^3/\\text{jam}$ dengan sistem *Boil-off Gas (BOG) return line*.";
        }

        // 7. Terminal Regasifikasi & FSRU
        if (preg_match('/(terminal|regasifikasi|fsru|orv|onshore|receiving)/i', $q)) {
            return "**Infrastruktur Terminal & Regasifikasi:**\n\n" .
                   "Kami merancang, membangun, dan mengoperasikan infrastruktur terminal penerima LNG:\n\n" .
                   "- **Terminal Darat (*Onshore Receiving Terminal*):** Tangki penyimpanan kriogenik *Full Containment* dengan sistem regasifikasi *Open Rack Vaporizer* (ORV) dan *Submerged Combustion Vaporizer* (SCV).\n" .
                   "- **FSRU (*Floating Storage Regasification Unit*):** Solusi regasifikasi terapung fleksibel yang terhubung ke jaringan pipa pipa transmisi bawah laut (*subsea pipeline*).\n" .
                   "- **Kapasitas Pasokan:** Kapasitas gabungan jaringan mencapai **5.2 MTPA** untuk menyuplai sektor ketenagalistrikan dan manufaktur nasional.";
        }

        // 8. Kontak Komersial / Alamat / Pertemuan
        if (preg_match('/(kontak|hubungi|email|telepon|wa|whatsapp|alamat|kantor|meeting|lokasi|sales)/i', $q)) {
            return "**Hubungi Divisi Komersial PT Nusantara LNG Energi:**\n\n" .
                   "- **Kantor Pusat:** Menara Astra, Lt. 38, Jl. Jend. Sudirman Kav. 5-6, Jakarta Pusat 10220, Indonesia\n" .
                   "- **Telepon:** +62 21 5289 1234\n" .
                   "- **Email Komersial & Offtake:** `commercial@nusantara-lng.com`\n" .
                   "- **Email Dukungan Teknis:** `support@nusantara-lng.com`\n" .
                   "- **Jam Operasional Desk Komersial:** Senin – Jumat, 08:00 – 17:00 WIB\n\n" .
                   "Anda juga dapat mengirimkan formulir permohonan pasokan melalui menu **Contact Us** di situs web kami.";
        }

        // 9. Profil Perusahaan & Visi
        if (preg_match('/(tentang|profil|siapa|sejarah|visi|misi|nusantara lng|perusahaan)/i', $q)) {
            return "**Profil PT Nusantara LNG Energi:**\n\n" .
                   "PT Nusantara LNG Energi adalah penyedia infrastruktur dan pasokan gas alam cair (LNG) terkemuka di Indonesia yang berdiri sejak tahun 2008.\n\n" .
                   "- **Kapasitas Rantai Pasok:** 5.2 MTPA pasokan LNG terkelola.\n" .
                   "- **Jangkauan Offtaker:** Melayani lebih dari 40 mitra korporat industri, pembangkit listrik nasional, dan smelter off-grid.\n" .
                   "- **Visi:** Menjadi pelopor ketahanan energi bersih dan efisiensi rantai pasok kriogenik di Asia Tenggara menuju target Net Zero Emission.";
        }

        // Default General B2B Energy Response
        return "Terima kasih atas pertanyaan Anda kepada **PT Nusantara LNG Energi**.\n\n" .
               "Sebagai mitra energi terintegrasi, kami siap mendukung kebutuhan pasokan Liquefied Natural Gas (LNG), armada ISO Tank *Virtual Pipeline*, regasifikasi terminal, hingga kontrak jangka panjang FOB/DES.\n\n" .
               "Untuk mendiskusikan kebutuhan spesifik volume gas atau penjadwalan presentasi teknis, silakan hubungi tim komersial kami di `commercial@nusantara-lng.com` atau melalui formulir kontak di menu **Contact Us**.";
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
