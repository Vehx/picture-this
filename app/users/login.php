<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we login users.

// this prevents logged in users to login again
if (isset($_SESSION['user'])) {
    redirect('/');
}

// this makes sure email and password is sent and is correct
// if either is incorrect it redirects the user back to login with an appropriate error
if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // make sure email isn't an empty string
    if ($email = '') {
        $_SESSION['errors'][] = 'Error: Please enter a valid email.';
        redirect('/login.php');
    }

    // calls database to see if theres a user with given email
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // checks if a user was not found in the database
    // redirects with error if user was not found
    if (!$user) {
        $_SESSION['errors'][] = "Error: incorrect email and/or password.";
        redirect('/login.php');
    }

    // verifies that given password is correct
    // otherwise redirects with same error as if email is incorrect for security purposes
    if (password_verify($password, $user['password'])) {
        // password is deleted from user array and then user is saved in session for use across the site
        unset($user['password']);
        $_SESSION['user'] = $user;
    } else {
        $_SESSION['errors'][] = "Error: incorrect email and/or password.";
        redirect('/login.php');
    }
}

redirect('/');
