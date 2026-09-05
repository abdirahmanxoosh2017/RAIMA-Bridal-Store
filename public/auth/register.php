<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/init.php';

$error = flash('error');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        flash('error', 'Invalid security token.');
        header('Location: register.php');
        exit;
    }

    $firstName = trim((string) ($_POST['first_name'] ?? ''));
    $lastName = trim((string) ($_POST['last_name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirm = (string) ($_POST['password_confirmation'] ?? '');

    if ($firstName === '' || $lastName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('error', 'Please provide valid personal details.');
        header('Location: register.php');
        exit;
    }

    if (strlen($password) < 8 || !hash_equals($password, $confirm)) {
        flash('error', 'Password must be at least 8 characters and both passwords must match.');
        header('Location: register.php');
        exit;
    }

    try {
        $pdo = db();
        $roleStmt = $pdo->prepare("SELECT id FROM roles WHERE name = 'customer' LIMIT 1");
        $roleStmt->execute();
        $roleId = $roleStmt->fetchColumn();

        if (!$roleId) {
            throw new RuntimeException('Customer role is missing. Run database/seed.sql first.');
        }

        $stmt = $pdo->prepare(
            'INSERT INTO users (role_id, first_name, last_name, email, phone, password_hash)
             VALUES (:role_id, :first_name, :last_name, :email, :phone, :password_hash)'
        );
        $stmt->execute([
            'role_id' => $roleId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone !== '' ? $phone : null,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        flash('success', 'Account created successfully. You can now sign in.');
        header('Location: login.php');
        exit;
    } catch (PDOException $exception) {
        flash('error', $exception->getCode() === '23000' ? 'An account with that email already exists.' : 'Unable to create your account.');
        header('Location: register.php');
        exit;
    } catch (Throwable $exception) {
        flash('error', $exception->getMessage());
        header('Location: register.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-light-subtle">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="collection-card">
                <div class="text-center mb-4">
                    <p class="eyebrow mb-2">RAIMA Bridal Store</p>
                    <h1 class="h2">Create your account</h1>
                </div>
                <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">First name</label><input class="form-control" name="first_name" required></div>
                        <div class="col-md-6"><label class="form-label">Last name</label><input class="form-control" name="last_name" required></div>
                        <div class="col-md-8"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
                        <div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
                        <div class="col-md-6"><label class="form-label">Password</label><input class="form-control" type="password" name="password" minlength="8" required></div>
                        <div class="col-md-6"><label class="form-label">Confirm password</label><input class="form-control" type="password" name="password_confirmation" minlength="8" required></div>
                        <div class="col-12"><button class="btn btn-brand w-100" type="submit">Create Account</button></div>
                    </div>
                </form>
                <p class="text-center mt-4 mb-0">Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
