<?php
require_once __DIR__ . '/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    $movie = get_movie_detail($id);
    $cast = array_slice(get_movie_cast($id), 0, 12);
    $videos = get_movie_videos($id);
    $trailer = null;

    foreach ($videos as $video) {
        if (($video['type'] ?? '') === 'Trailer' && ($video['site'] ?? '') === 'YouTube') {
            $trailer = $video;
            break;
        }
    }
} catch (Throwable $e) {
    $errorMessage = $e->getMessage();
    $movie = null;
    $cast = [];
    $trailer = null;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($movie['title'] ?? 'Detail Film') ?> | MovieVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="detail-page">
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">MovieVerse</a>
        </div>
    </nav>

    <?php if ($movie): ?>
        <section class="detail-shell">
            <div class="detail-backdrop"></div>
            <div class="container py-5">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-4">
                        <div class="detail-poster-card glass-card p-3">
                            <img src="<?= e(image_url($movie['poster_path'] ?? '')) ?>" alt="<?= e($movie['title'] ?? '') ?>" class="img-fluid rounded-4 w-100">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="glass-card p-4 p-lg-5">
                            <p class="eyebrow mb-2">Detail Film</p>
                            <h1 class="display-5 fw-bold mb-3"><?= e($movie['title'] ?? '-') ?></h1>
                            <?php if (!empty($movie['tagline'])): ?>
                                <p class="fst-italic text-muted mb-4">"<?= e($movie['tagline']) ?>"</p>
                            <?php endif; ?>

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <?php foreach ($movie['genres'] ?? [] as $genre): ?>
                                    <span class="genre-pill"><?= e($genre['name'] ?? '') ?></span>
                                <?php endforeach; ?>
                            </div>

                            <div class="row text-light mb-4">
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <p class="info-label">Durasi</p>
                                    <p class="info-value"><?= e(format_runtime((int) ($movie['runtime'] ?? 0))) ?></p>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <p class="info-label">Budget</p>
                                    <p class="info-value"><?= e(format_currency((int) ($movie['budget'] ?? 0))) ?></p>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <p class="info-label">Rating</p>
                                    <p class="info-value">★ <?= e(number_format((float) ($movie['vote_average'] ?? 0), 1)) ?></p>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <p class="info-label">Rilis</p>
                                    <p class="info-value"><?= e($movie['release_date'] ?? '-') ?></p>
                                </div>
                            </div>

                            <h3 class="mb-3">Sinopsis</h3>
                            <p class="lead text-muted mb-4">
                                <?= e($movie['overview'] ?? 'Sinopsis belum tersedia.') ?>
                            </p>

                            <?php if ($trailer): ?>
                                <button class="btn btn-accent btn-lg" data-bs-toggle="modal" data-bs-target="#trailerModal" data-trailer-key="<?= e($trailer['key']) ?>">
                                    Putar Trailer
                                </button>
                            <?php else: ?>
                                <button class="btn btn-accent btn-lg disabled">Trailer tidak tersedia</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <section class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="section-title">Pemeran Utama</h3>
                    </div>
                    <div class="cast-row glass-card p-3">
                        <?php if (!empty($cast)): ?>
                            <?php foreach ($cast as $person): ?>
                                <div class="cast-item text-center">
                                    <?php if (!empty($person['profile_path'])): ?>
                                        <img src="<?= e(image_url($person['profile_path'] ?? '')) ?>" alt="<?= e($person['name'] ?? 'Cast') ?>" class="cast-avatar">
                                    <?php else: ?>
                                        <div class="cast-avatar cast-avatar--fallback"><?= e(substr($person['name'] ?? 'A', 0, 1)) ?></div>
                                    <?php endif; ?>
                                    <p class="cast-name mt-2 mb-0"><?= e($person['name'] ?? '-') ?></p>
                                    <small class="text-muted"><?= e($person['character'] ?? 'Peran') ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted mb-0">Daftar pemeran belum tersedia.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </section>
    <?php else: ?>
        <div class="container py-5">
            <div class="glass-card p-4 text-center">
                <h2 class="mb-3">Film tidak ditemukan</h2>
                <p><?= e($errorMessage ?? 'Terjadi kesalahan saat memuat detail film.') ?></p>
                <a class="btn btn-accent" href="index.php">Kembali ke beranda</a>
            </div>
        </div>
    <?php endif; ?>

    <div class="modal fade" id="trailerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content glass-modal">
                <div class="modal-body p-0">
                    <iframe id="trailerFrame" class="trailer-frame" src="" title="Trailer film" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>