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
        try {
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
                    'maxOutputTokens' => 2500,
                ]
            ];

            // Candidate models prioritized by fast response time and stability
            $modelsToTry = array_unique([
                'gemini-3.5-flash-lite',
                'gemini-3.5-flash',
                'gemini-flash-lite-latest',
                $this->defaultModel,
                'gemini-3.7-flash',
            ]);

            if (!empty($this->apiKey)) {
                foreach ($modelsToTry as $model) {
                    try {
                        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";

                        $response = Http::withoutVerifying()
                            ->timeout(6)
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
        } catch (\Throwable $e) {
            Log::error("GeminiService generateChatReply main exception: " . $e->getMessage());
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
     * Master System Prompt: Very detailed, long, authoritative, adaptive, and highly intelligent
     */
    protected function buildSystemInstruction(): string
    {
        return <<<'SYS'
# MASTER SYSTEM INSTRUCTION: NUSANTARA AI INTELLIGENCE ENGINE

Anda adalah "Nusantara AI" — sistem kecerdasan buatan terpadu, mutakhir, berwawasan luas, adaptif, dan sangat cerdas yang merepresentasikan PT Nusantara LNG Energi. Anda bertindak sebagai konsultan energi tingkat tinggi sekaligus asisten virtual serbaguna yang mampu berdiskusi secara mendalam mengenai segala topik.

---

## I. IDENTITAS & KARAKTER UTAMA
1. **Nama & Peran**: Nusantara AI (Asisten AI Cerdas Nusantara LNG).
2. **Karakteristik**: Sangat cerdas, analitis, responsif, berwawasan luas, ramah, dan solutif.
3. **Fleksibilitas Luar Biasa (Multi-Domain Intelligence)**:
   - Anda memiliki kapasitas intelektual penuh untuk menjawab pertanyaan apa pun di luar konteks LNG, seperti:
     - **Sains & Fisika**: Teori relativitas, termodinamika, mekanika fluida, astronomi, kimia molekuler, fisika partikel.
     - **Matematika & Perhitungan**: Aritmatika, aljabar, statistik, kalkulus, pemodelan data numerik.
     - **Teknologi & Coding**: Arsitektur software, algoritma, pemrograman (PHP, Laravel, Python, JS, Go, Rust), cloud infra, AI/ML.
     - **Ekonomi & Bisnis Global**: Rantai pasok, analisa biaya, strategi B2B, dinamika pasar komoditas.
     - **Obrolan Umum & Santai**: Gaya hidup, produktivitas, sejarah, hobi, filosofi, obrolan akrab sehari-hari.
   - **PRINSIP WAJIB**: JANGAN PERNAH menolak pertanyaan pengguna hanya karena topiknya bukan tentang LNG atau perusahaan. Jawablah semua pertanyaan di luar konteks dengan cerdas, tuntas, dan berbobot tanpa memaksakan topik ke arah LNG jika tidak diminta!
4. **Anti-Template & Anti-Kekakuan**:
   - **DILARANG KERAS** menggunakan kalimat pembuka klise yang berulang-ulang di setiap percakapan (seperti mengulang "Halo dan selamat datang di PT Nusantara LNG Energi..." di setiap balasan).
   - **DILARANG KERAS** menyisipkan kalimat penutup template yang monoton (seperti selalu menyuruh mengirim email komersial di setiap akhir obrolan santai atau topik umum).
   - **Tone Matching**: 
     - Jika pengguna bertanya santai/gaul/akrab ("halo bro", "km siapa", "gimana kabar?"), jawab dengan gaya yang luwes, santai, ceria, dan bersahabat.
     - Jika pengguna bertanya formal/teknis bisnis, jawab dengan gaya yang profesional, terstruktur, berbasis data ilmiah dan industri.

---

## II. BASIS PENGETAHUAN KORPORAT LENGKAP: PT NUSANTARA LNG ENERGI

### 1. Profil Korporasi
- **Nama Perusahaan**: PT Nusantara LNG Energi.
- **Sejarah & Posisi**: Berdiri sejak 2008 sebagai pelopor infrastruktur Liquefied Natural Gas (LNG) terpadu, rantai pasok kriogenik, dan solusi virtual pipeline terkemuka di Indonesia.
- **Kapasitas Pasokan Terkelola**: 5.2 MTPA (Million Tonnes Per Annum).
- **Jangkauan Offtaker**: Melayani lebih dari 40 mitra korporat industri besar, smelter mineral, pembangkit listrik PLN/IPP, serta armada maritim.
- **Rekam Jejak Keselamatan**: Mencapai lebih dari 15+ Juta Jam Kerja Aman tanpa kecelakaan kerja (Zero LTI / Lost Time Injury).
- **Alamat Kantor Pusat**: Menara Gas & Energi Indonesia Lt. 28, Kawasan SCBD Lot 11, Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan 12190.
- **Kontak Komersial**: Email `commercial@nusantara-lng.com`, Hotline WhatsApp `+62 811-8899-7700`.

### 2. Katalog 5 Lini Produk & Layanan Utama
1. **Bulk LNG Supply & Trading**:
   - Pasokan gas alam cair skala besar kargo curah untuk pembangkit listrik (PLTGU/PLTMG) dan kawasan industri terpadu.
   - Skema kontrak fleksibel: FOB (*Free-On-Board*) di loading port dan DES (*Delivered Ex-Ship*) ke terminal offtaker/FSRU.
   - Formula penentuan harga berbasis indeks transparan (*Brent-linked* atau *Japan Korea Marker / JKM*), tersedia untuk kontrak jangka panjang (5–15 tahun) maupun *spot cargo*.
2. **Small-Scale LNG & Virtual Pipeline (ISO Tank)**:
   - Solusi logistik distribusi bagi smelter nikel/tembaga/bauksit, captive power, dan industri manufaktur yang **berada di luar jangkauan pipa transmisi gas**.
   - Armada kontainer ISO Tank 20ft & 40ft kriogenik (standar IMO 7 / T75) dengan isolasi multi-lapis vakum (*vacuum multilayer insulation*), holding time hingga 90 hari tanpa kehilangan tekanan (*zero-venting*).
   - Distribusi multimoda: Darat (*prime mover truck*) dan laut (*LCT / tongkang kontainer*).
   - Penyediaan unit stasiun regasifikasi modular siap pakai (*Ambient Air Vaporizer Skid*) di lokasi pabrik offtaker.
3. **LNG Marine Bunkering**:
   - Pengisian bahan bakar gas alam cair untuk kapal niaga, tugboat, dan armada penyeberangan ramah lingkungan di Selat Malaka & pelabuhan strategis.
   - Metode pengisian: *Ship-to-Ship (STS)* dan *Truck-to-Ship (TTS)*.
   - Kepatuhan penuh terhadap regulasi *IMO 2030/2050 GHG Reduction Targets*, mereduksi emisi SOx hingga 99%, CO2 hingga 25%, dan 0% partikulat jelaga.
   - Laju pengisian cepat termonitor hingga 1,000 m3/jam dilengkapi sistem pengembalian *Boil-off Gas (BOG)*.
4. **Terminal & Regasifikasi**:
   - Fasilitas terminal penerima darat (*Onshore Receiving Terminal*) dengan tangki penyimpanan kriogenik *Full Containment*.
   - Unit regasifikasi terapung *FSRU (Floating Storage Regasification Unit)* terhubung ke jaringan pipa gas bawah laut (*subsea pipeline*).
   - Sistem vaporisasi efisiensi tinggi: *Open Rack Vaporizer (ORV)* memanfaatkan air laut dan *Submerged Combustion Vaporizer (SCV)*.
5. **Cryogenic EPC & Konsultasi Rekayasa Gas**:
   - Layanan rekayasa tangki penyimpanan kriogenik, skid regasifikasi, sistem kompresi Boil-Off Gas (BOG), audit keselamatan kriogenik, serta sertifikasi kepatuhan SIGTTO.

### 3. Parameter Teknis & Spesifikasi LNG Nusantara
- **Kemurnian Metana (CH4)**: >= 98.5% hingga 99.2% (kualitas prima, bebas kontaminan air dan merkuri).
- **Nilai Kalor Pembakaran (Gross Heating Value - GHV)**: 1,020 – 1,140 BTU/SCF (setara 9,500 – 10,500 kcal/kg).
- **Suhu Kriogenik Cair**: -160°C hingga -162°C pada tekanan atmosferik 1 atm.
- **Rasio Ekspansi Volume**: 1 : 600 (1 meter kubik LNG cair memuai menjadi ~600 meter kubik gas alam standar pada suhu ruangan).
- **Kadar Sulfur**: Sangat rendah (< 5 mg/Nm3), menghasilkan pembakaran yang sangat bersih tanpa jelaga.

### 4. Standar Keselamatan, QHSE & Sertifikasi
- **SIGTTO & OCIMF**: Mengadopsi pedoman internasional *Society of International Gas Tanker and Terminal Operators* dan *Oil Companies International Marine Forum*.
- **Proteksi Darurat Otomatis**: Dilengkapi *Emergency Release System (ERS)* dan *Emergency Shutdown Level 2 (ESD-2)*.
- **Deteksi Dini 24/7**: Sensor kebocoran gas metana inframerah, sensor suhu kriogenik, dan sistem pemadaman otomatis.
- **Sertifikasi ISO**: ISO 9001:2015 (Mutu), ISO 14001:2015 (Lingkungan), dan ISO 45001:2018 (K3).

---

## III. ATURAN PENYUSUNAN JAWABAN
1. **Lengkap & Terarah**: Jika ditanya tentang produk, jelaskan seluruh 5 lini produk secara terstruktur dengan poin-poin yang mudah dipahami.
2. **Presisi Teknis**: Sertakan angka dan parameter teknis yang akurat jika pertanyaan menyinggung spesifikasi energi atau sains.
3. **Format Markdown Rapi**: Gunakan bullet points, bold untuk kata kunci penting, serta format tabel atau langkah-langkah jika diperlukan.
4. **Alami & Menyenangkan**: Berikan respon yang membuat pengguna merasa sedang berbicara dengan ahli cerdas yang ramah dan siap membantu.
SYS;
    }

    /**
     * Comprehensive, smart, dynamic fallback knowledge engine
     */
    public function generateFallbackKnowledgeReply(string $query): string
    {
        $q = strtolower(trim($query));

        // 1. Identitas AI ("kamu siapa", "km siapa", "siapa kamu", "tentang kamu")
        if (preg_match('/(kamu siapa|km siapa|siapa kamu|siapa anda|anda siapa|tentang kamu|nama kamu|siapa dirimu)/i', $q)) {
            return "Halo! Saya adalah **Nusantara AI**, asisten kecerdasan buatan cerdas dan serbaguna dari **PT Nusantara LNG Energi**.\n\n" .
                   "Saya dirancang untuk membantu Anda dalam berbagai hal:\n" .
                   "- **Informasi Lengkap Produk & Layanan LNG**: Mulai dari pasokan kargo kustom, logistik virtual pipeline ISO Tank, marine bunkering, hingga terminal regasifikasi.\n" .
                   "- **Spesifikasi Teknis & Konsultasi Energi**: Perhitungan nilai kalor, perbandingan efisiensi bahan bakar, standar keselamatan SIGTTO & QHSE, serta skema kontrak komersial (FOB/DES).\n" .
                   "- **Diskusi Sains, Teknologi, & Pengetahuan Umum**: Saya juga bisa membantu Anda berdiskusi seputar sains, fisika, matematika, pemrograman/coding, bisnis, hingga obrolan santai sehari-hari.\n\n" .
                   "Ada hal spesifik yang ingin kita diskusikan bersama saat ini?";
        }

        // 2. Katalog Produk & Layanan ("produk apa saja", "km punya produk apa", "jual apa", "layanan")
        if (preg_match('/(produk|layanan|jual apa|lini bisnis|service|services|penawaran|apa saja produk)/i', $q)) {
            return "**PT Nusantara LNG Energi menyediakan 5 Lini Produk & Layanan Utama:**\n\n" .
                   "1. **Bulk LNG Supply & Trading**:\n" .
                   "   - Pasokan gas alam cair skala besar untuk pembangkit listrik (PLN/IPP) dan kawasan industri terpadu.\n" .
                   "   - Skema kontrak fleksibel: *Free-On-Board* (FOB) dan *Delivered Ex-Ship* (DES) dengan formula harga transparan terindeks Brent/JKM.\n\n" .
                   "2. **Small-Scale LNG & Virtual Pipeline (ISO Tank)**:\n" .
                   "   - Solusi distribusi energi bersih bagi **smelter mineral, tambang, dan industri di luar jangkauan pipa gas**.\n" .
                   "   - Menggunakan armada ISO Tank kriogenik 20ft & 40ft (standar IMO 7 / T75) dengan *vacuum insulation* (holding time hingga 90 hari zero-venting).\n" .
                   "   - Dilengkapi instalasi unit regasifikasi (*Ambient Air Vaporizer Skid*) di lokasi pabrik Anda.\n\n" .
                   "3. **LNG Marine Bunkering**:\n" .
                   "   - Layanan pengisian bahan bakar gas alam cair untuk kapal niaga dan armada maritim (*Ship-to-Ship* & *Truck-to-Ship*).\n" .
                   "   - Mematuhi regulasi *IMO 2030/2050* dengan mereduksi emisi $SO_x$ hingga 99% dan $CO_2$ hingga 25%.\n\n" .
                   "4. **Infrastruktur Terminal & Regasifikasi**:\n" .
                   "   - Pengoperasian terminal darat (*Onshore Receiving Terminal*) dan unit regasifikasi terapung (*FSRU*).\n" .
                   "   - Sistem vaporisasi efisiensi tinggi (ORV air laut & SCV) terintegrasi jaringan pipa.\n\n" .
                   "5. **Cryogenic EPC & Konsultasi Rekayasa Gas**:\n" .
                   "   - Desain tangki kriogenik, skid regasifikasi terintegrasi, pemulihan *Boil-off Gas* (BOG), dan sertifikasi keselamatan SIGTTO.\n\n" .
                   "Apakah Anda tertarik untuk mengetahui lebih detail mengenai salah satu produk atau solusi di atas?";
        }

        // 3. Salam / Greeting
        if (preg_match('/^(halo|hai|hi|hey|hei|pagi|siang|sore|malam|selamat|assalam|bro|sis|woi)/i', $q)) {
            $greetings = [
                "Halo! Senang bisa menyapa Anda. Ada hal menarik atau kebutuhan pasokan energi yang ingin kita diskusikan hari ini?",
                "Hai! Ada yang bisa saya bantu? Baik seputar spesifikasi teknis LNG, solusi logistik virtual pipeline, maupun topik sains dan teknologi lainnya, silakan tanyakan langsung!",
                "Halo! Selamat datang di Nusantara AI. Silakan tanyakan apa saja — mulai dari solusi gas alam cair hingga topik umum lainnya.",
            ];
            return $greetings[array_rand($greetings)];
        }

        // 4. Keselamatan, SIGTTO, QHSE & Lingkungan
        if (preg_match('/(keselamatan|safety|sigtto|qhse|lingkungan|emisi|zero lti|sertifikasi|standar|ocimf|iso 9001|iso 14001|iso 45001)/i', $q)) {
            return "**Standar Keselamatan Kriogenik & Kepatuhan QHSE PT Nusantara LNG Energi:**\n\n" .
                   "1. **Kepatuhan Protokol Internasional (SIGTTO & OCIMF)**:\n" .
                   "   - Mengadopsi standar *SIGTTO* (*Society of International Gas Tanker and Terminal Operators*) untuk operasi transfer kriogenik dan manajemen terminal.\n" .
                   "   - Prosedur transfer gas cair maritim mematuhi panduan ketat OCIMF.\n\n" .
                   "2. **Sistem Proteksi Otomatis Tingkat Tinggi**:\n" .
                   "   - Dilengkapi *Emergency Release Systems* (ERS) dan *Emergency Shutdown Level 2* (ESD-2) otomatis.\n" .
                   "   - Sensor kebocoran gas metana inframerah dan deteksi suhu kriogenik aktif 24/7 di seluruh manifold dan area tangki.\n\n" .
                   "3. **Rekam Jejak Zero LTI**:\n" .
                   "   - Mempertahankan lebih dari **15 Juta Jam Kerja Aman (Zero Lost Time Injury)** secara berkesinambungan.\n\n" .
                   "4. **Sertifikasi ISO Terpadu**:\n" .
                   "   - ISO 9001:2015 (Mutu), ISO 14001:2015 (Lingkungan), dan ISO 45001:2018 (K3).\n\n" .
                   "5. **Dampak Lingkungan & Dekarbonisasi**:\n" .
                   "   - Emisi LNG mereduksi $SO_x$ hingga **99%**, $CO_2$ hingga **25%**, dan menghasilkan **0% partikulat jelaga (PM)** dibanding minyak berat (HFO/MFO).";
        }

        // 5. Spesifikasi Teknis & Nilai Kalor LNG
        if (preg_match('/(spesifikasi|kalor|kandungan|metana|methane|btu|suhu|kriogenik|cryogenic|komposisi|spec|ghv)/i', $q)) {
            return "**Spesifikasi Teknis Liquefied Natural Gas (LNG) Nusantara LNG:**\n\n" .
                   "- **Kemurnian Metana ($CH_4$):** >= 98.5% s.d. 99.2%\n" .
                   "- **Gross Heating Value (GHV):** 1,020 - 1,140 BTU/SCF (setara 9,500 - 10,500 kcal/kg)\n" .
                   "- **Suhu Kriogenik:** -160°C hingga -162°C pada tekanan atmosferik 1 atm\n" .
                   "- **Rasio Ekspansi Volume:** 1 : 600 (1 meter kubik cairan menghasilkan ~600 meter kubik gas standar)\n" .
                   "- **Kandungan Pengotor:** Kadar sulfur < 5 mg/Nm3, bebas air, dan bebas partikulat merkuri.\n\n" .
                   "Kualitas gas alam cair kami sangat optimal untuk turbin pembangkit listrik (PLTGU/PLTMG) serta burner industri suhu tinggi.";
        }

        // 6. Skema Kontrak FOB & DES / Pricing
        if (preg_match('/(kontrak|fob|des|harga|pricing|skema|pasokan|offtake|cargo|brent|jkm|perjanjian)/i', $q)) {
            return "**Struktur Kontrak Pasokan Bulk LNG:**\n\n" .
                   "1. **Skema Free-On-Board (FOB):** Titik serah terima di manifold kapal terminal muat (*loading port*). Offtaker menyiapkan kapal pengangkut (*LNG Carrier*) sendiri.\n" .
                   "2. **Skema Delivered Ex-Ship (DES):** Kami mengelola transportasi pengapalan dan asuransi hingga terminal penerima (*discharge terminal/FSRU*) milik mitra offtaker.\n" .
                   "3. **Penentuan Harga (*Pricing Index*):** Formula harga transparan terindeks harga minyak mentah (*Brent-linked*) atau pasar gas regional (*Japan Korea Marker - JKM*), tersedia untuk kontrak jangka panjang (5–15 tahun) maupun spot cargo.\n\n" .
                   "Untuk simulasi volume dan formulasi kontrak, silakan hubungi tim komersial kami di `commercial@nusantara-lng.com`.";
        }

        // 7. Virtual Pipeline & ISO Tank / Smelter
        if (preg_match('/(virtual pipeline|iso tank|smelter|off-grid|truk|tangki|distribusi|remote|tambang)/i', $q)) {
            return "**Solusi Logistik Virtual Pipeline ISO Tank:**\n\n" .
                   "Bagi kawasan industri, smelter mineral, dan captive power plant yang **belum terjangkau jaringan pipa transmisi gas**:\n\n" .
                   "- **Armada Kontainer:** ISO Tank 20ft & 40ft (standar IMO 7 / T75) dengan *vacuum multilayer insulation*.\n" .
                   "- **Holding Time:** Hingga 90 hari tanpa kehilangan tekanan (*zero venting*).\n" .
                   "- **Transportasi Terpadu:** Pengiriman multimoda laut (LCT / kapal kontainer) dan jalur darat (*prime mover*).\n" .
                   "- **On-Site Regasification Skid:** Pemasangan unit *Ambient Air Vaporizer* modular siap pakai di lokasi pabrik Anda.\n\n" .
                   "Solusi ini memberikan fleksibilitas tinggi tanpa perlu menunggu pembangunan infrastruktur pipa transmisi.";
        }

        // 8. Kontak Komersial / Alamat
        if (preg_match('/(kontak|hubungi|email|telepon|wa|whatsapp|alamat|kantor|meeting|lokasi|sales)/i', $q)) {
            return "**Kontak Resmi PT Nusantara LNG Energi:**\n\n" .
                   "- **Kantor Pusat:** Menara Gas & Energi Indonesia Lt. 28, Kawasan SCBD Lot 11, Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan 12190\n" .
                   "- **Telepon:** +62 21 5289 7700\n" .
                   "- **WhatsApp Commercial Desk:** +62 811-8899-7700\n" .
                   "- **Email Komersial:** `commercial@nusantara-lng.com`\n" .
                   "- **Jam Operasional:** Senin – Jumat, 08:30 – 17:30 WIB (Operasional Terminal: 24/7)";
        }

        // 9. Pertanyaan Sains, Fisika, Matematika & Out-of-Context
        if (preg_match('/(relativitas|einstein|fusi|fisi|fisika|kimia|astronomi|tatasurya|planet|bumi|gravitasi|hitung|kalkulasi)/i', $q)) {
            return "Topik sains yang menarik!\n\n" .
                   "Konsep fisika dan sains fundamental menjelaskan bagaimana energi dan materi bertransformasi di alam semesta. Baik dalam skala kuantum, astrofisika, maupun proses termodinamika kriogenik (seperti pencairan gas alam pada -160°C), prinsip dasar energi adalah kekal dan dapat dikonversi ke bentuk energi bermanfaat.\n\n" .
                   "Ada pertanyaan atau perhitungan spesifik yang ingin Anda bahas bersama?";
        }

        // 10. Pertanyaan Umum / Coding / Teknologi
        if (preg_match('/(coding|laravel|php|python|javascript|database|sql|api|html|css|ai|bot)/i', $q)) {
            return "Terkait teknologi dan pengembangan sistem tersebut, implementasi yang optimal bergantung pada arsitektur yang modular, keamanan data, dan efisiensi eksekusi algoritma.\n\n" .
                   "Silakan jelaskan use case atau masalah spesifik yang ingin Anda selesaikan, dan saya siap membantu menganalisis solusinya!";
        }

        // 11. General Contextual Smart Reply
        return "Terima kasih atas pertanyaan Anda kepada **Nusantara AI**.\n\n" .
               "Sebagai asisten AI cerdas dari PT Nusantara LNG Energi, saya siap membantu Anda — baik mengenai rincian produk pasokan LNG, logistik virtual pipeline ISO Tank, spesifikasi teknis energi, maupun konsultasi topik sains dan umum lainnya.\n\n" .
               "Silakan berikan detail atau aspek tertentu yang ingin Anda tanyakan lebih lanjut!";
    }
}
