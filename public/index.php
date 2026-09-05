<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/init.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
</head>
<body>
<header class="site-header border-bottom">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <a class="brand text-decoration-none" href="index.php">
            <span class="brand-mark">R</span>
            <span>
                <strong>RAIMA</strong>
                <small>BRIDAL STORE</small>
            </span>
        </a>
        <nav class="d-none d-md-flex gap-4">
            <a href="#collections">Collections</a>
            <a href="#services">Services</a>
            <a href="#booking">Booking &amp; Planning</a>
        </nav>
        <a class="btn btn-brand" href="auth/login.php">Sign In</a>
    </div>
</header>

<main>
    <section class="hero py-5">
        <div class="container py-lg-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <p class="eyebrow">Elegance for Your Special Day</p>
                    <h1 class="display-4 fw-semibold">Your dream dress awaits you.</h1>
                    <p class="lead text-secondary">Discover bridal dresses, accessories and wedding planning services in one refined destination.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a class="btn btn-brand btn-lg" href="#collections">Explore Collection</a>
                        <a class="btn btn-outline-dark btn-lg" href="#booking">Book Appointment</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-card d-flex align-items-end justify-content-center" aria-label="RAIMA Bridal Store hero placeholder">
                        <div class="text-center p-4">
                            <div class="display-1">♕</div>
                            <h2 class="h4">RAIMA Bridal Store</h2>
                            <p class="mb-0 text-secondary">Luxury bridal experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="collections" class="py-5 bg-light-subtle">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <p class="eyebrow">Shop by Collection</p>
                <h2>Made for your special moment</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4"><div class="collection-card"><span>01</span><h3>Wedding Dresses</h3><p>Elegant silhouettes curated for every bridal style.</p></div></div>
                <div class="col-md-4"><div class="collection-card"><span>02</span><h3>Evening Dresses</h3><p>Refined pieces for receptions, parties and celebrations.</p></div></div>
                <div class="col-md-4"><div class="collection-card"><span>03</span><h3>Accessories</h3><p>Finishing touches that complete the bridal look.</p></div></div>
            </div>
        </div>
    </section>

    <section id="services" class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6"><div class="service-panel"><p class="eyebrow">Wedding Planning</p><h2>Let us plan your perfect day.</h2><p class="text-secondary">Appointment booking, decoration, catering, photography, venue coordination and custom wedding services will connect to the real database in later phases.</p><a class="btn btn-brand" href="#booking">Start Planning</a></div></div>
                <div class="col-lg-6" id="booking"><div class="booking-card"><h3 class="h4">Book an Appointment</h3><p class="text-secondary">Authentication and booking workflow are part of Phase 1+ foundation.</p><a class="btn btn-outline-dark" href="auth/login.php">Continue to Booking</a></div></div>
            </div>
        </div>
    </section>
</main>

<footer class="border-top py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
        <span>© <?= date('Y') ?> RAIMA Bridal Store</span>
        <span>Elegance for Your Special Day</span>
    </div>
</footer>
</body>
</html>
