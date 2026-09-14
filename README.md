# PT Nusantara LNG Energi — Corporate Company Profile & Energy Infrastructure Platform

Company profile korporat modern untuk **PT Nusantara LNG Energi**, penyedia solusi terintegrasi infrastruktur gas alam cair (LNG), rantai pasok kriogenik (*virtual pipeline*), terminal regasifikasi, dan *marine bunkering* di Indonesia dan Asia Pasifik. Platform ini dirancang khusus untuk memenuhi kebutuhan komunikasi strategis dengan mitra bisnis B2B (*offtakers* industri & utilitas listrik) dan calon investor institusional.

---

## Struktur 6 Halaman Utama (Public Navigation)

1. **Home (`/`)**: Hero positioning perusahaan LNG, counter statistik operasional (Kapasitas 5.2 MTPA, 18+ Tahun Operasi, 12 Terminal, 40+ Offtaker Strategis), showcase lini produk unggulan dengan spesifikasi teknis, logo mitra korporat & sertifikasi industri (PLN, PGN, SKK Migas, SIGTTO, ISO), serta testimoni institusional.
2. **About (`/about-us` / `/about`)**: Profil korporat, visi-misi, pilar kompetensi rantai pasok kriogenik, standar kepatuhan QHSE berstandar internasional, serta ikhtisar rekam jejak operasional.
3. **Products (`/products` / `/services`)**: Katalog lini produk dan solusi bisnis energi gas bumi terintegrasi (Bulk LNG, ISO Tank Fleet & Virtual Pipeline, Marine Bunkering, Regasification Terminals, Small-Scale LNG Hubs, Cryogenic EPC).
4. **Blog / Market Insights (`/blog` / `/our-blog`)**: Publikasi artikel analisis pasar energi, regulasi migas nasional & internasional, wawasan dekarbonisasi industri, serta pengumuman resmi perusahaan.
5. **Detail Blog (`/our-blog/{slug}`)**: Halaman artikel mendalam dengan meta kategori, estimasi waktu baca, sitasi, dan navigasi artikel terkait.
6. **Contact (`/contact-us` / `/contact`)**: Informasi kantor pusat Energy Tower SCBD Jakarta, formulir *Commercial Inquiry* B2B, kontak *Investor Relations*, serta integrasi peta lokasi.

---

## Kredensial Pengguna Sistem (CMS Admin)

Akses panel manajemen konten melalui URL `/admin/login`.

### 1. Akun Role Asli (Production / Default)

| Peran | Email | Password |
|---|---|---|
| Super Admin | `admin@nusantara-lng.com` *(atau `admin@the-metrix.com`)* | `qwertyu123` |
| Content Editor | `editor@nusantara-lng.com` *(atau `editor@the-metrix.com`)* | `qwertyu123` |

### 2. Akun Role Demo (Auto-Delete 3 Menit)

| Peran Demo | Email Demo | Password Demo | Masa Berlaku Konten |
|---|---|---|---|
| Demo Super Admin | `demo_admin@nusantara-lng.com` *(atau `demo_admin@the-metrix.com`)* | `password` | 3 Menit Otomatis Terhapus |
| Demo Editor | `demo_editor@nusantara-lng.com` *(atau `demo_editor@the-metrix.com`)* | `password` | 3 Menit Otomatis Terhapus |

---

## Fitur Utama Platform

- **Corporate Positioning & Technical Product Specs**: Menampilkan spesifikasi teknis LNG (Gross Heating Value 1,020–1,150 BTU/SCF, CH₄ Purity ≥ 99.2%, Cryogenic Boiling Point -162°C, ISO Container pressure ratings).
- **2-Level Products & Business Lines**: Struktur hierarki produk mencakup *Bulk & Wholesale LNG Supply*, *Virtual Pipeline & Cryogenic Logistics*, *Marine Bunkering & Small-Scale Distribution*, *Terminal Regasification*, dan *Cryogenic EPC*.
- **Asisten AI B2B (Google Gemini)**: Chatbot interaktif yang diprogram khusus sebagai *Corporate Technical Specialist* untuk menjawab pertanyaan seputar spesifikasi teknis, mekanisme kontrak offtake (FOB/DES), perizinan SKK Migas, dan standar keselamatan kriogenik.
- **Commercial Desk Inbox**: Formulir inquiry terhubung langsung ke dashboard admin dengan status pesan masuk dan notifikasi cepat.
- **Manajemen Berita & Analisis Pasar Energi**: CMS lengkap untuk publikasi riset pasar gas bumi, siaran pers korporat, dan artikel dekarbonisasi.
- **Dashboard CMS Terpadu**: Pengelolaan produk, slide hero, artikel, pesan masuk, subscriber newsletter, statistik perusahaan, dan pengaturan profil situs.
- **Desain Monokromatis Presisi**: Mempertahankan 100% tata letak visual elegan, responsif, dan performa tinggi dari template dasar.

---

## Teknologi yang Digunakan (Tech Stack)

- **Backend Framework**: PHP 8.3 & Laravel 11
- **Database**: MySQL 8
- **Autentikasi & Otorisasi**: Laravel Session Auth & Role Middleware (Super Admin / Editor)
- **Frontend**: Blade Templating, Standalone Tailwind CSS, Alpine.js, Vanilla JS
- **Artificial Intelligence**: Google Gemini API (`gemini-2.5-flash` / `gemini-1.5-flash`)
- **Rich Text Editor**: Quill.js
- **Automation**: Laravel Task Scheduling & Auto-cleanup Event Listeners

---

## Panduan Instalasi Lokal

1. **Clone repository**:
   ```bash
   git clone https://github.com/faulnam/lng.git
   cd lng
   ```

2. **Install dependensi PHP**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Jalankan Migrasi & Database Seeder**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Akses website di `http://localhost:8000` dan panel admin di `http://localhost:8000/admin`.
