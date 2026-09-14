# Dokumentasi Sistem Informasi Company Profile PT Nusantara LNG Energi

## Judul Proyek
Sistem Informasi Company Profile dan Manajemen Lini Bisnis PT Nusantara LNG Energi Terpadu

## Deskripsi Singkat
Sistem Informasi Company Profile dan Manajemen Lini Bisnis PT Nusantara LNG Energi merupakan platform digital korporat B2B yang dirancang untuk industri energi gas alam cair (LNG), logistik rantai pasok kriogenik (*virtual pipeline*), dan infrastruktur regasifikasi gas bumi. Platform ini memfasilitasi komunikasi resmi dengan calon mitra bisnis (*industrial & utility offtakers*), investor institusional, dan pemangku kepentingan industri. Sistem ini menyediakan akun operasional produksi dan akun demo interaktif dengan fitur pembersihan otomatis konten uji coba setiap 3 menit.

## Overview Lengkap Proyek
Platform ini menghadirkan pengalaman visual monokromatis elegan dengan 6 navigasi halaman utama yang disederhanakan: Home, About, Products, Blog, Detail Blog, dan Contact. Calon mitra dapat meninjau spesifikasi teknis LNG, jangkauan armada ISO tank kriogenik, fasilitas terminal regasifikasi, sertifikasi kepatuhan industri (SKK Migas, SIGTTO, ISO 9001/14001/45001), membaca publikasi riset pasar energi, dan mengajukan *commercial inquiry* secara langsung. Pada area internal, panel administrasi (CMS) memungkinkan tim manajemen untuk memperbarui data katalog produk LNG, publikasi wawasan pasar energi, slide presentasi korporat, pesan masuk, subscriber buletin, dan identitas perusahaan.

## Daftar Akun Demo & Admin

### Akun Produksi (Default)
- **Super Admin**: `admin@nusantara-lng.com` *(Password: `qwertyu123`)*
- **Content Editor**: `editor@nusantara-lng.com` *(Password: `qwertyu123`)*

### Akun Demo (Auto-Delete 3 Menit)
- **Demo Super Admin**: `demo_admin@nusantara-lng.com` *(Password: `password`)*
- **Demo Editor**: `demo_editor@nusantara-lng.com` *(Password: `password`)*

## Key Features
- **6 Struktur Halaman Utama Publik**: Home, About Us, Products / Lini Bisnis, Blog & Market Insights, Detail Blog, dan Contact Us.
- **Katalog Produk & Lini Bisnis LNG 2-Level**: Bulk LNG Supply, Cryogenic Logistics & ISO Fleet, Marine Bunkering, Regasification Terminals, Small-Scale LNG Hubs, and Cryogenic EPC.
- **Tampilan Spesifikasi Teknis**: Nilai kalor (BTU/SCF), kemurnian metana (CH₄), titik didih kriogenik, dan sertifikasi keselamatan.
- **Asisten AI Chatbot Spesialis Energi (Google Gemini)**: Chatbot responsif yang dikustomisasi khusus untuk FAQ produk LNG, kontrak FOB/DES, dan infrastruktur kriogenik.
- **Manajemen Pesan Commercial Desk**: Formulir pesan kontak B2B terintegrasi dengan panel inbox admin.
- **Portal Artikel & Riset Energi**: Kategori artikel terstruktur (Regulasi Migas, Analisis Pasar LNG, Dekarbonisasi Industri, Berita Korporat).
- **Showcase Sertifikasi & Mitra Strategis**: Logo strip untuk PLN, PGN, SKK Migas, SIGTTO, GIIGNL, dan standar ISO.
- **Panel Pengaturan Identitas & Statistik Operasional**: Kapasitas produksi MTPA, jam kerja aman zero LTI, jumlah terminal aktif, dan jumlah offtaker.
- **Kontrol Hak Akses Pengguna (RBAC)**: Pemisahan peran Super Administrator dan Content Editor.
- **Pembersihan Otomatis Data Konten Demo**: Fitur proteksi data demo yang terhapus otomatis setelah 3 menit.

## Teknologi yang Digunakan
- **Bahasa Pemrograman**: PHP 8.3
- **Framework Backend**: Laravel 11
- **Basis Data**: MySQL 8
- **Autentikasi**: Laravel Session-Based Authentication & Role Middleware
- **Antarmuka (Frontend)**: Tailwind CSS Standalone CLI, Alpine.js, Vanilla JavaScript
- **Editor Teks**: Quill.js
- **Kecerdasan Buatan**: Google Gemini API
- **Otomatisasi**: Laravel Task Scheduler & Eloquent Events
