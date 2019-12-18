<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we get posts from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_SESSION['user'])) {

    // calls database to see if theres a user with given email
    $statement = $pdo->prepare('SELECT * FROM posts ORDER BY id DESC');
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $postsWithLikes = getLikes($posts);
    echo json_encode($postsWithLikes);

    header('Content-Type: application/json');
}
