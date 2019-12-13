<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we store/insert new posts in the database.

if (isset($_POST['title'], $_FILES['image'])) {
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $image = $_FILES['image'];
    if (isset($_POST['hashtags'])) {
        $hashtags = filter_var(trim($_POST['hashtags']), FILTER_SANITIZE_STRING);
    }
    // die(var_dump($title, $image));

    if ($image['size'] > 2000000) {
        $_SESSION['errors'][] = "It's too big!";
    }
    if ($image['type'] !== 'image/png' && $image !== 'image/jpg' && $image !== 'image/jpeg') {
        $_SESSION['errors'][] = "Thats not a valid file type!";
    }

    if ($_SESSION['errors']) {
        die(var_dump($_SESSION));
    }
    move_uploaded_file(
        $image['tmp_name'],
        '../database/uploads/posts/' . $image['name']
    );
}
// die(var_dump($_FILES));
redirect('/');
