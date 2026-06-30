# MovieVerse - Rekomendasi & List Movie

Aplikasi web rekomendasi dan daftar film berbasis PHP Native dengan arsitektur clean code dan pemisahan file eksternal. Proyek ini memanfaatkan TMDB API untuk menampilkan film populer, pencarian film, detail film, cast, serta trailer video.

## Fitur Utama

- Halaman utama dengan hero banner film populer
- Pencarian film secara real-time melalui form pencarian
- Grid daftar film dengan desain premium dan efek hover
- Halaman detail film imersif dengan backdrop blur dan metadata lengkap
- Daftar cast dalam layout horizontal scrollable
- Modal trailer YouTube dengan kontrol JS untuk menghentikan video saat ditutup
- Menggunakan Bootstrap 5 + custom CSS vanilla dan JavaScript ES6+

## Struktur Project

```text
movie-v3/
├── config.php
├── index.php
├── detail.php
├── style.css
├── script.js
└── README.md
```

## Persiapan Project

1. Buat folder project:

```bash
mkdir movie-v3
cd movie-v3
```

2. Buka folder di VS Code:

```bash
code .
```

3. Pastikan PHP sudah terinstall di sistem.

4. Jalankan server lokal PHP:

```bash
php -S 127.0.0.1:8000 -t .
```

5. Buka browser:

```text
http://127.0.0.1:8000/index.php
```

## Catatan Penting

- Token akses TMDB sudah disertakan di file config.php.
- Semua file UI dipisahkan sesuai Separation of Concerns.
- Input pencarian dilindungi dari XSS menggunakan htmlspecialchars.
- Kode telah diberi komentar edukatif untuk memudahkan pembelajaran.

## Prompt / Instruksi Proyek

Buatkan sistem aplikasi web Rekomendasi & List Movie menggunakan PHP Native (Clean Code), dengan struktur file yang terpisah secara eksternal (Separation of Concerns). Untuk layouting utama gunakan Bootstrap 5 via CDN, namun wajib dikombinasikan dengan Modern Custom Vanilla CSS (Grid, Flexbox, Glassmorphism) dan Modern JavaScript (ES6+) agar UI/UX terlihat premium, sinematik, dan tidak kaku seperti template standar.

Wajib pisahkan kode ke dalam 5 file eksternal berikut:

1. config.php (Pusat konfigurasi, handling error, dan fungsi fetch API TMDB menggunakan cURL)
2. index.php (Halaman utama: Navbar, Hero section film populer, pencarian, dan grid list film)
3. detail.php (Halaman detail film imersif: Backdrop blur, sinopsis, info cast/pemeran, dan tombol trailer)
4. style.css (Custom CSS modern eksternal: Variabel warna, efek glassmorphic, hover transition, dan custom scrollbar)
5. script.js (JavaScript eksternal: Manipulasi DOM, efek scroll navbar, dan handling modal video trailer)

Gunakan TMDB Read Access Token (JWT Bearer) berikut untuk autentikasi API (masukkan ke header 'Authorization: Bearer ...'):
"eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxOTNkOTZiNWM2ZjczMWU5NWQwNmQyZDIyYjYxZTkzYiIsIm5iZiI6MTc4MjgyMzY1MS42OCwic3ViIjoiNmE0M2JhZTNmNDJjNDA4YTJmNTc1YmJiIiwic2NvcGVzIjpbImFwaV9yZWFkIl0sInZlcnNpb24iOjF9.qMz76L7BkrUSRxGr0l4GFCUwcR2iOoTI3Thyd9PwOXk"

--- SPESIFIKASI UI/UX MODERN DAN SINEMATIK ---

1. Skema Warna & Desain (style.css):
   - Gunakan tema Dark Mode murni (Background: #08080d, Card & Modal: rgba(255,255,255,0.03) dengan efek backdrop-filter: blur).
   - Warna aksen: #ff2a5f (Pink-merah neon ala streaming platform premium) untuk rating, tombol utama, dan highlight.
   - Font modern seperti 'Plus Jakarta Sans' atau 'Inter' melalui Google Fonts.

2. Komponen Navbar & Hero Banner (index.php):
   - Navbar sticky/fixed di atas layar. Berikan efek transparan di awal, dan otomatis berubah menjadi gelap solid menggunakan JavaScript saat user melakukan scroll ke bawah.
   - Sediakan form pencarian dengan style pill-shaped (melengkung sempurna) yang responsif.
   - Bagian Hero menampilkan 1 film paling populer saat ini sebagai background full-width (backdrop_path dari TMDB). Berikan lapisan overlay gradasi linier (linear-gradient) vertikal dan horizontal agar teks sinopsis dan judul film di atasnya tetap kontras dan mudah dibaca.

3. Grid & Movie Cards Premium:
   - Gunakan Bootstrap untuk row layout, namun modifikasi card-nya. Card wajib menggunakan border transparan tipis (`border: 1px solid rgba(255,255,255,0.08)`) dan border-radius yang lembut (16px).
   - Efek Hover: Saat kursor diarahkan ke kartu film, poster harus melakukan zoom-in halus (`transform: scale(1.05)`) dan kartu terangkat sedikit ke atas (`translateY(-10px)`) dilengkapi dengan bayangan pendaran (soft glow shadow) warna aksen.
   - Letakkan badge rating bintang (misal: 8.4) yang melayang (absolute positioning) di pojok kanan atas poster film.

4. Layout Detail Imersif (detail.php):
   - Gunakan gambar backdrop film berukuran besar yang dikaburkan (`filter: blur(50px) brightness(35%)`) sebagai latar belakang utama halaman untuk menciptakan atmosfer bioskop.
   - Pisahkan layout menjadi 2 kolom. Kolom kiri untuk poster vertikal yang tajam, kolom kanan untuk metadata (Judul, tagline fst-italic, genre dalam bentuk pill-badges, durasi, budget, dan sinopsis).
   - Tampilkan daftar cast (aktor utama) dalam bentuk deretan avatar bulat yang bisa di-scroll secara horizontal jika layarnya penuh (`overflow-x: auto`).

5. Interaksi Video Trailer (script.js):
   - Sediakan tombol "Putar Trailer" di halaman detail yang terintegrasi dengan Bootstrap 5 Modal.
   - Tampilkan video menggunakan `<iframe>` YouTube dari endpoint `/movie/{id}/videos`.
   - Tulis logika JavaScript penting: Ketika modal ditutup, attribute `src` dari iframe harus dikosongkan/dihapus agar video otomatis berhenti dan tidak menyisakan suara di latar belakang.

--- SPESIFIKASI TEKNIS & KEAMANAN KODE ---

- Logika backend PHP harus menggunakan fungsi cURL yang bersih, aman, dan memiliki parameter timeout.
- Lindungi input pencarian dari celah keamanan XSS menggunakan `htmlspecialchars()`.
- Tulis kode dengan komentar yang edukatif di setiap bagian penting agar mudah dipahami oleh calon mahasiswa IT.

## Teknologi yang Digunakan

- PHP Native
- Bootstrap 5
- Vanilla CSS
- JavaScript ES6+
- TMDB API

## Keterangan

Proyek ini dibuat untuk kebutuhan pembelajaran dan demonstrasi pengembangan web modern dengan pendekatan clean code dan struktur file yang rapi.
