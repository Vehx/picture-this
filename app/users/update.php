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
    $databaseTable = 'users';

    // checks if name is sent
    if (isset($_POST['name'])) {
        // cleans sent name up
        $newName = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        // checks that name is not same as old name and not an empty string
        if (!($newName === $oldName) && $newName != '') {
            // sends changes to be made in database
            $hasChanged = true;
            updateDatabase($pdo, $databaseTable, $id, 'name', $newName);
        }
    }

    // checks if avatar is sent
    if (isset($_POST['avatar'])) {
        // checks that it's not an empty string
        if ($_POST['avatar'] != '') {
            // checks that it's ok, not too big and of the right type
            if (isImageOk($_POST['avatar']['size'], $_POST['avatar']['type'])) {
                // prepares image, gives it a uuid and moves it to the uploads/avatars folder
                $newAvatar = prepareImage($_POST['avatar']['name'], $_POST['avatar']['tmp_name'], true);
                // sends changes to be made in database
                $hasChanged = true;
                updateDatabase($pdo, $databaseTable, $id, 'avatar', $newAvatar);
            } else {
                // redirects back with errors from isImageOk function
                redirect('/profile.php');
            }
        }
    }

    // checks if biography is sent
    if (isset($_POST['biography'])) {
        $newBiography = filter_var(trim($_POST['biography']), FILTER_SANITIZE_STRING);
        if (!($newBiography === $oldBiography) || $newBiography != '') {
            // sends changes to be made in database
            $hasChanged = true;
            updateDatabase($pdo, $databaseTable, $id, 'biography', $newBiography);
        }
    }

    // checks if email is sent
    if (isset($_POST['email'])) {
        $newEmail = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        // checks database for email, to make sure it isn't a duplicate
        $emailCheckUser = checkEmail($pdo, $newEmail);

        // checks that new email is not same as old email, not an empty string and not a duplicate email
        if (!($newEmail === $oldEmail) && $newEmail != '' && !isset($emailCheckUser['email'])) {
            // sends changes to be made in database
            $hasChanged = true;
            updateDatabase($pdo, $databaseTable, $id, 'email', $newEmail);
        }
    }

    if ($hasChanged) {
        // sends a message as an error to let user know information has been saved
        $_SESSION['errors'][] = "Changes have been saved.";
    }

    redirect('/profile.php');
}
