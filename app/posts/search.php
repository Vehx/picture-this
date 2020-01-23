<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_POST['search'])) {
    $search = trim(filter_var($_POST['search'], FILTER_SANITIZE_STRING));

    if (strlen($search) < 1) {
        $emptyArray = [];
        echo json_encode($emptyArray);
        exit;
    }

    $search = "%" . $search . "%";

    $statement = $pdo->prepare('SELECT * FROM posts WHERE description LIKE :search');

    if (!$statement) {
        $error = $pdo->errorInfo();
        echo json_encode($error);
        exit;
    }

    $statement->execute([
        ':search' => $search
    ]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $postsWithLikes = getLikes($posts, $_SESSION['user']['id'], $pdo);
    $postsWithLikesAndPoster = getPoster($postsWithLikes, $pdo);
    echo json_encode($postsWithLikesAndPoster);

    header('Content-Type: application/json');
}
