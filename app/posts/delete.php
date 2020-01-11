<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we delete posts from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST['post-id'])) {
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user']['id'];

    // gets post to be deleted from database to check that the user that made it is the same trying to delete it
    $databasePost = getPost($pdo, $postId);
    if ($userId === $databasePost['user_id']) {
        deletePost($pdo, $postId, $userId);
    }
}

redirect('/');
