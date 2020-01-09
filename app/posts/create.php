<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we store/insert new posts in the database.

if (isset($_POST, $_FILES['image'])) {
    $image = $_FILES['image'];
    $descriptionExists = false;
    $titleExists = false;

    // checks if any keywords/hashtags were entered and sets a bool to true for use in the database storage code
    if (isset($_POST['title'])) {
        $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
        $titleExists = true;
    }
    if (isset($_POST['description'])) {
        $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
        $descriptionExists = true;
    }

    // we grab the current users id to make the post theirs in the database
    $userId = $_SESSION['user']['id'];

    // checks if image is the right size and type
    // if it is, it is uploaded and the path to give to database is returned
    if (isImageOk($image['size'], $image['type'])) {
        $imagePath = prepareImage($image['name'], $image['tmp_name']);
    } else {
        redirect('/');
    }

    // information about post is saved in database, note keywords/hashtags is optional
    $statement = $pdo->prepare('INSERT INTO posts (user_id, title, picture, keywords) VALUES (:user_id, :title, :picture, :keywords)');
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':picture', $imagePath, PDO::PARAM_STR);
    if ($titleExist) {
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
    }
    if ($descriptionExist) {
        $statement->bindParam(':hashtags', $description, PDO::PARAM_STR);
    }
    $statement->execute();
}
redirect('/');
