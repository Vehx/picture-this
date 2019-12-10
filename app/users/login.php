<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we login users.

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($email = '') {
        $error[] = 'Email is invalid.'; // todo make this session errors or something like that
    }

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $hashedPassword = $user['password'];

    if (!$user) {
        // todo send error msg
        redirect('/login.php');
    }

    if (password_verify($password, $hashedPassword)) {
        // die(var_dump($user));
        unset($user['password']);
        $_SESSION['user'] = $user;
    } else {
        // todo implement something here that happens when unsuccessful login attempt happens, maybe do it in : !$user if, above
        die(var_dump('Error incorrect email and/or password.'));
    }
}

redirect('/');
