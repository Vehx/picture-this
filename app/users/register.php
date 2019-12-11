<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we store/insert new accounts in the database.

if (isset($_SESSION['username'], $_SESSION['email'], $_SESSION['password'])) {
    $username = filter_var(trim($_SESSION['username']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_SESSION['email']), FILTER_SANITIZE_EMAIL);
    $password = $_SESSION['password'];

    if ($username === '') {
        $_SESSION['error'] = "bad username";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email === '') {
        $_SESSION['error'] = "bad email";
    }

    if (count($password) > 4) {
        $_SESSION['error'] = "bad password";
    }

    if ($_SESSION['error']) {
        redirect('/register');
    }
}

redirect('/', 201);
