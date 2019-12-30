<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we update a users information in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST)) {
    if (isset($_POST['name'])) {
    }

    if (isset($_POST['avatar'])) {
    }

    if (isset($_POST['biography'])) {
    }

    if (isset($_POST['email'])) {
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
