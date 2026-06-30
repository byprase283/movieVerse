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

## Teknologi yang Digunakan

- PHP Native
- Bootstrap 5
- Vanilla CSS
- JavaScript ES6+
- TMDB API

## Keterangan

Proyek ini dibuat untuk kebutuhan pembelajaran dan demonstrasi pengembangan web modern dengan pendekatan clean code dan struktur file yang rapi.
