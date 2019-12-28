<?php

declare(strict_types=1);
// In this file we delete new posts in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_GET['uid'])) {
    $ownProfile = false;
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $_GET['uid'], PDO::PARAM_INT);

    $statement->execute();
} else {
    $ownProfile = true;
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);

    $statement->execute();
}

$profile = $statement->fetch(PDO::FETCH_ASSOC);

$_SESSION['profile']['name'] = $profile['name'];
$_SESSION['profile']['avatar'] = $profile['avatar'];
$_SESSION['profile']['biography'] = $profile['biography'];
if ($ownProfile) {
    $_SESSION['profile']['email'] = $profile['email'];
}
