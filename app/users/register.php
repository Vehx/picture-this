<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we store/insert new accounts in the database.

// alreadyLoggedIn();

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password-confirm'])) {
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];

    // check if name field is empty
    unset($_SESSION['error']);
    if ($name === '') {
        $_SESSION['errors'][] = "bad name";
    }

    // check if email is valid and not empty
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email === '') {
        $_SESSION['errors'][] = "bad email";
    }

    // check that password is 4 characters or longer
    if (strlen($password) < 4 || strlen($passwordConfirm) < 4) {
        $_SESSION['errors'][] = "bad password";
    }

    // here the errors if any stops the registering process and sends the user back to register.php with error messages
    if ($_SESSION['errors']) {
        // todo send information back so form doesnt need to be refilled
        // die(var_dump($_SESSION));
        redirect('/register.php');
    }

    // todo hash password

    die(var_dump($name, $email, $password));
    // new user gets entered into database
    $statement = $pdo->prepare('INSERT INTO users ( name, email, password, biography, avatar) values ( :name, :email, :password, null, null)');
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->execute();

    // new user is grabbed from database to log user in and to verify everything worked
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // uncomment this later
        // $_SESSION['errors'][] = "Error: Internal server error.";

        $_SESSION['errors'][] = "Error: Something went wrong when fetching the new user.";
        redirect('/register.php');
    }

    if (password_verify($password, $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;
    } else {
        // uncomment this later
        // $_SESSION['errors'][] = "Error: Internal server error.";

        $_SESSION['errors'][] = "Error: Password missmatch in database.";
        redirect('/register.php');
    }
}

die(var_dump($_POST, $_SESSION));
redirect('/');
