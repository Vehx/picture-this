<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we store/insert new accounts in the database.

// isLoggedIn();

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password-confirm'])) {
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];

    // saving entered info for sending back incase of errors
    $_SESSION['registering']['name'] = $name;
    $_SESSION['registering']['email'] = $email;
    $_SESSION['registering']['password'] = $password;
    $_SESSION['registering']['password-confirm'] = $passwordConfirm;

    // todo send information back so form doesnt need to be refilled
    // check if name field is empty
    if ($name === '') {
        $_SESSION['errors'][] = "Error: Please enter your name.";
        unset($_SESSION['registering']['name']);
        redirect('/register.php');
    }

    // check if email is valid and not empty
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email === '') {
        $_SESSION['errors'][] = "Error: Please enter a valid email.";
        unset($_SESSION['registering']['email']);
        redirect('/register.php');
    }

    // check that password is 4 characters or longer
    if (strlen($password) < 4 || strlen($passwordConfirm) < 4) {
        $_SESSION['errors'][] = "Error: Password needs to be 4 characters or longer.";
        unset($_SESSION['registering']['password'], $_SESSION['registering']['password-confirm']);
        redirect('/register.php');
    }

    // check that both passwords are the same to confirm that the user knows what their password will be
    if (!$password === $passwordConfirm) {
        $_SESSION['errors'][] = "Error: Passwords don't match, please try again.";
        unset($_SESSION['registering']['password'], $_SESSION['registering']['password-confirm']);
        redirect('/register.php');
    }

    // checks if email already is registerd in database
    // todo make this into a function
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user['email'] === $email) {
        $_SESSION['errors'][] = "Error: Email is already registered.";
        unset($_SESSION['registering']['email']);
        redirect('/register.php');
    }

    // password gets hashed before being put in database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // new user gets entered into database
    $statement = $pdo->prepare('INSERT INTO users ( name, email, password, biography, avatar) values ( :name, :email, :password, null, null)');
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $statement->execute();

    // todo make this just grab last created id
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
    unset($_SESSION['registering']);
}

redirect('/');
