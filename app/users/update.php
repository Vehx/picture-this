<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we update a users information in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST) || isset($_FILES)) {
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
    if (isset($_FILES['avatar'])) {

        // checks that it's not an empty string
        if ($_FILES['avatar'] != '') {

            // checks that it's ok, not too big and of the right type
            if (isImageOk($_FILES['avatar']['size'], $_FILES['avatar']['type'])) {

                // prepares image, gives it a uuid and moves it to the uploads/avatars folder
                $newAvatar = prepareImage($_FILES['avatar']['name'], $_FILES['avatar']['tmp_name'], true);

                // deletes old avatar from uploads folder
                unlink(__DIR__ . '/../../' . $oldAvatar);

                // sends changes to be made in database
                $hasChanged = true;
                updateDatabase($pdo, $databaseTable, $id, 'avatar', $newAvatar);
                $_SESSION['user']['avatar'] = $newAvatar;
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

        // checks that new email is not same as old email, not an empty string and not an already existing email
        if (!($newEmail === $oldEmail) && $newEmail != '' && !isset($emailCheckUser['email'])) {

            // sends changes to be made in database
            $hasChanged = true;
            updateDatabase($pdo, $databaseTable, $id, 'email', $newEmail);
        } else {
            $_SESSION['errors'][] = "Please enter a valid email.";
            redirect('/profile.php');
        }
    }

    // checks if password is sent
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        $newPassword = $_POST['new-password'];
        $newPasswordConfirm = $_POST['new-password-confirm'];
        $user = getProfile($pdo, $id);

        // checks that current password is correct
        if (password_verify($password, $user['password'])) {

            // checks that a new password was sent and confirmed
            if ($newPassword != '' || $newPasswordConfirm != '') {

                // check that password is 4 characters or longer
                if (strlen($newPassword) < 4 || strlen($newPasswordConfirm) < 4) {
                    $_SESSION['errors'][] = "Error: Password needs to be 4 characters or longer.";
                    redirect('/password.php');
                }

                // check that both passwords are the same to confirm that the user knows what their password will be
                if (!($newPassword === $newPasswordConfirm)) {
                    $_SESSION['errors'][] = "Error: Passwords don't match, please try again.";
                    redirect('/password.php');
                }

                // password gets hashed before being put in database
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // sends changes to be made in database
                $hasChanged = true;
                updateDatabase($pdo, $databaseTable, $id, 'password', $hashedPassword);
            } else {
                // if new password or new password confirm wasn't sent in, user is sent back with an error
                $_SESSION['errors'][] = "Please enter a new password and confirm it.";
                unset($user);
                redirect('/password.php');
            }
        } else {
            // if current password was incorrect, user is sent back with an error
            $_SESSION['errors'][] = "Current password is incorrect.";
            unset($user);
            redirect('/password.php');
        }
    }

    if ($hasChanged) {
        // sends a message as an error to let user know information has been saved
        $_SESSION['errors'][] = "Changes have been saved.";
    }

    redirect('/profile.php');
}
