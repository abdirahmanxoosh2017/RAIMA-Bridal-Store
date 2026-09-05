<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/init.php';

$error = flash('error');
$success = flash('success');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        flash('error', 'Invalid security token. Please try again.');
        header('Location: login.php');
        exit;
    }

    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        flash('error', 'Enter a valid email and password.');
        header('Location: login.php');
        exit;
    }

    try {
        $stmt = db()->prepare(
            'SELECT u.id, u.first_name, u.last_name, u.email, u.password_hash, u.status, r.name AS role_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             WHERE u.email = :email
             LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || $user['status'] !== 'active' || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Incorrect email or password.');
            header('Location: login.php');
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role_name'],
        ];

        db()->prepare('UPDATE users SET last_login_at = NOW() WHERE id = :id')->execute(['id' => $user['id']]);

        if ($user['role_name'] === 'admin') {
            header('Location: ../admin/index.php');
        } else {
            header('Location: ../index.php');
        }
        exit;
    } catch (Throwable $exception) {
        flash('error', 'Unable to sign in right now. Check your database configuration.');
        header('Location: login.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-light-subtle">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="collection-card">
                <div class="text-center mb-4">
                    <p class="eyebrow mb-2">Welcome to RAIMA</p>
                    <h1 class="h2">Sign in</h1>
                    <p class="text-secondary mb-0">Continue your bridal journey.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= e($success) ?></div>
                <?php endif; ?>

                <form method="post" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" required autocomplete="email">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" required autocomplete="current-password">
                    </div>
                    <button class="btn btn-brand w-100" type="submit">Sign In</button>
                </form>

                <div class="text-center mt-4">
                    <a href="../index.php">← Back to store</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
