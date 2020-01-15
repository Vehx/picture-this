<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we delete posts in the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST['edit-description']) && isset($_POST['post-id'])) {
    $newDescription = filter_var($_POST['edit-description'], FILTER_SANITIZE_STRING);
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_STRING);

    // gets post from database 
    $currentPost = getPost($pdo, $postId);

    if ($newDescription != $currentPost['description']) {

        // sends changes to be made in database
        updateDatabase($pdo, 'posts', $postId, 'description', $newDescription);
    }
}

redirect('/');
