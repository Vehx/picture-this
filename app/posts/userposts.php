<?php

declare(strict_types=1);
require __DIR__.'/../autoload.php';

if (!isset($_SESSION['user'])) {
    redirect('/');
}

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $userId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));

    $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :userId ORDER BY id DESC');

    if (!$statement) {
        $error = $pdo->errorInfo();
        echo json_encode($error);
        exit;
    }

    $statement->execute([
        ':userId' => $userId,
    ]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $postsWithLikes = getLikes($posts, $_SESSION['user']['id'], $pdo);
    $postsWithLikesAndPoster = getPoster($postsWithLikes, $pdo);
    echo json_encode($postsWithLikesAndPoster);
    exit;
}
