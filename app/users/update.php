<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we update a users information in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST)) {
    $hasChanged = false;
    $oldName = $_SESSION['user']['name'];
    $oldAvatar = $_SESSION['user']['avatar'];
    $oldBiography = $_SESSION['user']['biography'];
    $oldEmail = $_SESSION['user']['email'];
    $newName = '';
    $newAvatar = '';
    $newBiography = '';
    $newEmail = '';

    $changes = [];
    $query = '';

    if (isset($_POST['name'])) {
        $newName = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        if (!($newName === $oldName) || $newName != '') {
            $hasChanged = true;
            $changes[] = "name = $newName";
        }
    }

    if (isset($_POST['avatar'])) {
        $hasChanged = true;
        $newAvatar = '';
    }

    if (isset($_POST['biography'])) {
        $hasChanged = true;
        $newBiography = '';
    }

    if (isset($_POST['email'])) {
        $hasChanged = true;
        $newEmail = '';
        // check database for email, select * from users where email = $newEmail
        // if it returns false, email doesn't exist and we continue with changing email
        // same thing for name maybe?
    }

    if ($hasChanged) {
        // database change
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
