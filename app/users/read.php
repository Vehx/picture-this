<?php

declare(strict_types=1);
// In this file we get info on user profile from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_GET['uid'])) {
    $profile = getProfile($pdo, $_GET['uid']);
} else {
    $profile = getProfile($pdo, $_SESSION['user']['id']);
    $_SESSION['profile']['email'] = $profile['email'];
}

$_SESSION['profile']['name'] = $profile['name'];
$_SESSION['profile']['avatar'] = $profile['avatar'];
$_SESSION['profile']['biography'] = $profile['biography'];

unset($profile);
