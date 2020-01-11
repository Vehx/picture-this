<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we get posts from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_SESSION['user'])) {

    // gets posts from database to send to posts.js
    $posts = getPosts($pdo);

    $postsWithLikes = getLikes($posts, $_SESSION['user']['id'], $pdo);
    echo json_encode($postsWithLikes);

    header('Content-Type: application/json');
}
