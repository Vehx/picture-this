<?php

declare(strict_types=1);
// In this file we delete new posts in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_GET['uid'])) {
    $ownProfile = false;
    $profile = getProfile($pdo, $_GET['uid']);
} else {
    $ownProfile = true;
    $profile = getProfile($pdo, $_SESSION['user']['id']);
}

$_SESSION['profile']['name'] = $profile['name'];
$_SESSION['profile']['avatar'] = $profile['avatar'];
$_SESSION['profile']['biography'] = $profile['biography'];
if ($ownProfile) {
    $_SESSION['profile']['email'] = $profile['email'];
}

unset($profile);
