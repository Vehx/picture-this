<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we store/insert new posts in the database.

if (isset($_POST['title'], $_FILES['image'])) {
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $image = $_FILES['image'];
    $hashtagsExist = false;
    $uuidGen = [];

    // checks if any keywords/hashtags were entered and sets a bool to true for use in the database storage code
    if (isset($_POST['hashtags'])) {
        $hashtags = filter_var(trim($_POST['hashtags']), FILTER_SANITIZE_STRING);
        $hashtagsExist = true;
    }

    // checks size and type of image and creates errors if wrong and redirects back with error message
    if ($image['size'] > 2000000) {
        $_SESSION['errors'][] = "It's too big!";
        redirect('/');
    }
    if ($image['type'] !== 'image/png' && $image['type'] !== 'image/jpg' && $image['type'] !== 'image/jpeg') {
        $_SESSION['errors'][] = "Thats not a valid file type!";
        redirect('/');
    }

    // we grab the current users id to make the post theirs in the database
    $userId = $_SESSION['user']['id'];

    // image name is set to a uuid before stored in uploads folder and database
    $uuidGen = explode('.', $image['name']);
    $uuidGen[0] = guidv4();
    $picturePath = 'app/database/uploads/posts/' . $uuidGen[0] . '.' . $uuidGen[1];

    // the image path is set with its uuid name and saved in variable for use when storing information in database
    $imagePath = '../database/uploads/posts/' . $uuidGen[0] . '.' . $uuidGen[1];

    // image is moved to storage in file structure
    move_uploaded_file(
        $image['tmp_name'],
        $imagePath
    );

    // information about post is saved in database, note keywords/hashtags is optional
    $statement = $pdo->prepare('INSERT INTO posts (user_id, title, picture, keywords) VALUES (:user_id, :title, :picture, :keywords)');
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':picture', $picturePath, PDO::PARAM_STR);
    if ($hashtagsExist) {
        $statement->bindParam(':keywords', $hashtags, PDO::PARAM_STR);
    }
    $statement->execute();
}
redirect('/');
