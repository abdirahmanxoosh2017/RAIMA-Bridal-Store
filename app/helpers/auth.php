<?php

declare(strict_types=1);

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']['id']);
}

function has_role(string $role): bool
{
    return is_logged_in() && ($_SESSION['user']['role'] ?? null) === $role;
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('error', 'Please sign in to continue.');
        header('Location: ../auth/login.php');
        exit;
    }
}

function require_admin(): void
{
    require_login();
    if (!has_role('admin')) {
        http_response_code(403);
        exit('Forbidden');
    }
}
