<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we add or remove likes from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (!isset($_POST['like']) && !isset($_POST['dislike'])) {
    redirect('/');
}

if (isset($_POST['like']) || isset($_POST['dislike'])) {
    $postId = "";
    $action = "";
    $userId = $_SESSION['user']['id'];

    if (isset($_POST['like'])) {
        $action = "like";
    };
    if (isset($_POST['dislike'])) {
        $action = "dislike";
    };

    $postId = filter_var($_POST["$action"], FILTER_SANITIZE_STRING);
    $testMsg = $postId . " got a $action.";

    // prepares statement for liking/disliking
    $statement = $pdo->prepare('INSERT INTO likes (post_id, user_id, liked, disliked) VALUES (:post_id, :user_id, :liked, :disliked)');

    // setting variables to be used for binding parameteres in statement
    if ($action === "like") {
        $liked = "yes";
        $likedType = PDO::PARAM_STR;
        $disliked = null;
        $dislikedType = PDO::PARAM_NULL;
    }
    if ($action === "dislike") {
        $liked = null;
        $likedType = PDO::PARAM_NULL;
        $disliked = "yes";
        $dislikedType = PDO::PARAM_STR;
    }

    // todo use delete statement below to make delete logic
    // $statement = $pdo->prepare('DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id');

    // binds parameters to use for liking/disliking
    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':liked', $liked, $likedType);
    $statement->bindParam(':disliked', $disliked, $dislikedType);

    $statement->execute();

    // returns some json to tell js that things went as expected
    header('Content-Type: application/json');
    echo json_encode($testMsg);
}
