<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we delete new posts in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_SESSION['uid'])) {
    echo $_SESSION['uid']['name'];
    unset($_SESSION['uid']['name']);
}
