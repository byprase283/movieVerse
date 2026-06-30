<?php
// Pusat konfigurasi aplikasi.
// File ini mengatur token TMDB, helper keamanan, dan fungsi request API menggunakan cURL.
declare(strict_types=1);

session_start();

const TMDB_BASE_URL = 'https://api.themoviedb.org/3';
const TMDB_IMAGE_BASE_URL = 'https://image.tmdb.org/t/p/';

// Token akses baca TMDB yang diberikan dalam spesifikasi.
$tmdbToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxOTNkOTZiNWM2ZjczMWU5NWQwNmQyZDIyYjYxZTkzYiIsIm5iZiI6MTc4MjgyMzY1MS42OCwic3ViIjoiNmE0M2JhZTNmNDJjNDA4YTJmNTc1YmJiIiwic2NvcGVzIjpbImFwaV9yZWFkIl0sInZlcnNpb24iOjF9.qMz76L7BkrUSRxGr0l4GFCUwcR2iOoTI3Thyd9PwOXk';

/**
 * Mengirim request ke API TMDB dengan cURL.
 * Fungsi ini aman, dapat digunakan ulang, dan memiliki timeout.
 */
function tmdb_request(string $endpoint, array $params = [], int $timeout = 10): array
{
    global $tmdbToken;

    $url = TMDB_BASE_URL . $endpoint;
    if ($params !== []) {
        $url .= '?' . http_build_query($params);
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $tmdbToken,
            'Accept: application/json',
        ],
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    curl_close($ch);

    if ($response === false) {
        throw new RuntimeException('Gagal menghubungi TMDB: ' . $curlError);
    }

    if ($httpCode >= 400) {
        throw new RuntimeException('TMDB mengembalikan error HTTP ' . $httpCode);
    }

    $decoded = json_decode($response, true);
    if (!is_array($decoded)) {
        throw new RuntimeException('Respons TMDB tidak valid.');
    }

    return $decoded;
}

/**
 * Membuat URL gambar TMDB yang aman untuk ditampilkan.
 */
function image_url(?string $path, string $size = 'w500'): string
{
    if (empty($path)) {
        return 'https://placehold.co/500x750/08080d/ffffff?text=No+Poster';
    }

    return TMDB_IMAGE_BASE_URL . $size . $path;
}

/**
 * Helper output aman untuk mencegah XSS.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Format durasi film dari menit ke format jam dan menit.
 */
function format_runtime(int $minutes): string
{
    $hours = intdiv($minutes, 60);
    $mins = $minutes % 60;

    return $hours > 0 ? $hours . ' jam ' . $mins . ' menit' : $mins . ' menit';
}

/**
 * Format nominal angka ke format rupiah sederhana.
 */
function format_currency(int $amount): string
{
    return '$' . number_format($amount, 0, ',', '.');
}

/**
 * Mengambil daftar film populer atau hasil pencarian.
 */
function get_movies(string $query = ''): array
{
    if ($query !== '') {
        $data = tmdb_request('/search/movie', [
            'query' => $query,
            'language' => 'en-US',
            'page' => 1,
        ]);

        return $data['results'] ?? [];
    }

    $data = tmdb_request('/movie/popular', [
        'language' => 'en-US',
        'page' => 1,
    ]);

    return $data['results'] ?? [];
}

/**
 * Mendapatkan detail film lengkap berdasarkan ID.
 */
function get_movie_detail(int $id): array
{
    return tmdb_request('/movie/' . $id, ['language' => 'en-US']);
}

/**
 * Mendapatkan daftar cast/aktor dari film.
 */
function get_movie_cast(int $id): array
{
    $data = tmdb_request('/movie/' . $id . '/credits', ['language' => 'en-US']);

    return $data['cast'] ?? [];
}

/**
 * Mendapatkan video trailer dari film.
 */
function get_movie_videos(int $id): array
{
    $data = tmdb_request('/movie/' . $id . '/videos', ['language' => 'en-US']);

    return $data['results'] ?? [];
}
