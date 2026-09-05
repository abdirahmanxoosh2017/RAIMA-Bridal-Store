<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../app/helpers/auth.php';

require_admin();
$user = current_user();
$pdo = db();

$stats = [
    'products' => (int) $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'orders' => (int) $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'bookings' => (int) $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
    'customers' => (int) $pdo->query("SELECT COUNT(*) FROM users u INNER JOIN roles r ON r.id=u.role_id WHERE r.name='customer'")->fetchColumn(),
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard — <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-shell">
<aside class="admin-sidebar">
    <div class="admin-brand"><span class="brand-mark">R</span><div><strong>RAIMA</strong><small>ADMIN PANEL</small></div></div>
    <nav class="mt-4">
        <a class="active" href="index.php">Dashboard</a>
        <a href="#">Orders</a><a href="#">Bookings</a><a href="#">Products</a><a href="#">Categories</a><a href="#">Dresses</a><a href="#">Accessories</a><a href="#">Services</a><a href="#">Customers</a><a href="#">Payments</a><a href="#">Reviews</a><a href="#">Coupons</a><a href="#">Users</a><a href="#">Roles &amp; Permissions</a><a href="#">CMS</a><a href="#">Reports</a><a href="#">Settings</a><a href="#">Activity Logs</a>
    </nav>
</aside>
<main class="admin-main">
    <header class="admin-topbar d-flex justify-content-between align-items-center">
        <div><p class="eyebrow mb-1">Store Management</p><h1 class="h3 mb-0">Dashboard</h1></div>
        <div class="text-end"><strong><?= e(($user['first_name'] ?? 'Admin') . ' ' . ($user['last_name'] ?? '')) ?></strong><br><a href="../auth/logout.php">Sign out</a></div>
    </header>
    <section class="container-fluid py-4">
        <div class="row g-4">
            <?php foreach ($stats as $label => $value): ?>
                <div class="col-sm-6 col-xl-3"><div class="stat-card"><span><?= e(ucfirst($label)) ?></span><strong><?= $value ?></strong><small>Database-backed</small></div></div>
            <?php endforeach; ?>
        </div>
        <div class="row g-4 mt-1">
            <div class="col-lg-8"><div class="panel-card"><h2 class="h5">Phase 1 foundation</h2><p class="text-secondary mb-0">Authentication, role protection, PDO database access, CSRF helper, core schema and shared RAIMA styling are now in place. Feature modules will be connected in the next phases.</p></div></div>
            <div class="col-lg-4"><div class="panel-card"><h2 class="h5">Quick access</h2><a class="btn btn-dark w-100 mb-2" href="../index.php">View Store</a><a class="btn btn-outline-dark w-100" href="../auth/logout.php">Sign Out</a></div></div>
        </div>
    </section>
</main>
</body>
</html>
