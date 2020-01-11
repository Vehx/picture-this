<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we delete posts from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST['post-id'])) {

    // if ($_SESSION['user']['id'] === )
}

redirect('/');
