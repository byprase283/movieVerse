<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'MovieVerse | Rekomendasi & List Movie';
$searchQuery = trim($_GET['search'] ?? '');

try {
    $popularMovies = get_movies($searchQuery);

    if ($searchQuery === '') {
        $heroMovie = $popularMovies[0] ?? null;
    } else {
        $heroMovie = $popularMovies[0] ?? null;
    }
} catch (Throwable $e) {
    $errorMessage = $e->getMessage();
    $popularMovies = [];
    $heroMovie = null;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">MovieVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#movie-grid">Daftar Film</a></li>
                </ul>
                <form class="d-flex search-pill" method="get" action="index.php">
                    <input class="form-control" type="search" name="search" value="<?= e($searchQuery) ?>" placeholder="Cari film...">
                    <button class="btn" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <?php if ($heroMovie): ?>
            <div class="hero-backdrop" style="background-image: linear-gradient(90deg, rgba(8,8,13,0.95) 0%, rgba(8,8,13,0.4) 55%, rgba(8,8,13,0.9) 100%), url('<?= e(image_url($heroMovie['backdrop_path'] ?? '', 'original')) ?>');"></div>
        <?php else: ?>
            <div class="hero-backdrop hero-fallback"></div>
        <?php endif; ?>

        <div class="hero-overlay container">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-7">
                    <p class="eyebrow">Rekomendasi Premium Hari Ini</p>
                    <h1 class="display-4 fw-bold mb-3">
                        <?= e($heroMovie['title'] ?? 'Temukan film terbaik hari ini') ?>
                    </h1>
                    <p class="hero-description mb-4">
                        <?= e(($heroMovie['overview'] ?? 'Jelajahi daftar film populer dan temukan pengalaman menonton yang tak terlupakan.') ?: 'Jelajahi daftar film populer dan temukan pengalaman menonton yang tak terlupakan.') ?>
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <?php if ($heroMovie): ?>
                            <a class="btn btn-accent btn-lg" href="detail.php?id=<?= (int) ($heroMovie['id'] ?? 0) ?>">Lihat Detail</a>
                        <?php endif; ?>
                        <a class="btn btn-outline-light btn-lg" href="#movie-grid">Lihat Koleksi</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger glass-card" role="alert">
                <?= e($errorMessage) ?>
            </div>
        <?php endif; ?>

        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="eyebrow mb-2">Daftar Film</p>
                    <h2 class="section-title"><?= $searchQuery !== '' ? 'Hasil pencarian untuk: ' . e($searchQuery) : 'Film Populer Saat Ini' ?></h2>
                </div>
            </div>

            <div id="movie-grid" class="row g-4">
                <?php if (!empty($popularMovies)): ?>
                    <?php foreach ($popularMovies as $movie): ?>
                        <?php $movieId = (int) ($movie['id'] ?? 0); ?>
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a class="movie-card" href="detail.php?id=<?= $movieId ?>">
                                <div class="movie-card__poster">
                                    <img src="<?= e(image_url($movie['poster_path'] ?? '')) ?>" alt="<?= e($movie['title'] ?? 'Poster film') ?>" loading="lazy">
                                    <span class="rating-badge">★ <?= e(number_format((float) ($movie['vote_average'] ?? 0), 1)) ?></span>
                                </div>
                                <div class="movie-card__body">
                                    <h3><?= e($movie['title'] ?? 'Judul tidak tersedia') ?></h3>
                                    <p><?= e($movie['release_date'] ?? 'Tanggal rilis tidak tersedia') ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="glass-card p-4 text-center">
                            <h3 class="mb-3">Belum ada film yang ditampilkan</h3>
                            <p class="text-muted">Coba gunakan pencarian atau cek koneksi API TMDB Anda.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>