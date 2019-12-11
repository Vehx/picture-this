<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we login users.

// this prevents logged in users to login again
if (isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($email = '') {
        $_SESSION['errors'][] = 'Error: Please enter a valid email.';
    }

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // todo send error msg
        $_SESSION['errors'][] = "Error: incorrect email and/or password.";
        $_SESSION['errors'][] = 'Error2: Please enter a valid email.';
        $_SESSION['errors'][] = 'Error3: Please enter a valid email.';
        // die(var_dump($_SESSION));

        redirect('/login.php');
    }

    $hashedPassword = $user['password'];

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
