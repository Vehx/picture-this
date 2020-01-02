<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we update a users information in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST)) {
    $hasChanged = false;
    $id = $_SESSION['user']['id'];
    $oldName = $_SESSION['user']['name'];
    $oldAvatar = $_SESSION['user']['avatar'];
    $oldBiography = $_SESSION['user']['biography'];
    $oldEmail = $_SESSION['user']['email'];
    $newName = '';
    $newAvatar = '';
    $newBiography = '';
    $newEmail = '';

    if (isset($_POST['name'])) {
        $newName = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        if (!($newName === $oldName) || $newName != '') {
            $hasChanged = true;
            updateProfile($pdo, $id, 'name', $newName);
        }
    }

    if (isset($_POST['avatar'])) {
        if ($_POST['avatar'] != '') {
            $hasChanged = true;
            $newAvatar = '';
            guidv4();
            updateProfile($pdo, $id, 'avatar', $newAvatar);
        }
    }

    if (isset($_POST['biography'])) {
        $newBiography = filter_var(trim($_POST['biography']), FILTER_SANITIZE_STRING);
        if (!($newBiography === $oldBiography) || $newBiography != '') {
            $hasChanged = true;
            updateProfile($pdo, $id, 'biography', $newBiography);
        }
    }

    if (isset($_POST['email'])) {
        $newEmail = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $emailCheckUser = checkEmail($pdo, $newEmail);
        // check database for email, select * from users where email = $newEmail
        // if it returns false, email doesn't exist and we continue with changing email
        // same thing for name maybe?
        if (!($newEmail === $oldEmail) && $newEmail != '' && !isset($emailCheckUser['email'])) {
            $hasChanged = true;
            updateProfile($pdo, $id, 'email', $newEmail);
        }
    }

    if ($hasChanged) {
        // not database change, maybe msg
    }

    redirect('/profile.php');
}
// if ( name != user name) {
    // database write new name 
// }
// if ( email != user email) {
    // database write new email 
// }
// if ( avatar != user avatar) {
    // database write new avatar 
// }
// if ( biography != user biography) {
    // database write new biography 
// }
// if ( password != verify user password) {
    // database write new password 
// }
