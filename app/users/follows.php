<?php

declare(strict_types=1);
// In this file we get info on user profile from the database.
require __DIR__.'/../autoload.php';

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST['id'])) {
    $followingId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
    $followerId = $_SESSION['user']['id'];

    $isFollowing = followExists($followerId, $followingId, $pdo);

    if ($isFollowing) {
        $statement = $pdo->prepare('DELETE FROM follows WHERE follower_id = :followerId AND following_id = :followingId');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':followerId'  => $followerId,
            ':followingId' => $followingId,
        ]);
    } else {
        $statement = $pdo->prepare('INSERT INTO follows (follower_id, following_id) VALUES (:followerId, :followingId)');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':followerId'  => $followerId,
            ':followingId' => $followingId,
        ]);
    }
    redirect('/profile.php?uid='.$followingId);
}
