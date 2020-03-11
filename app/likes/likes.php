<?php

declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we add or remove likes from the database.

if (!isset($_SESSION['user'])) {
    redirect('/');
}

if (!isset($_POST['like']) && !isset($_POST['dislike'])) {
    redirect('/');
}

if (isset($_POST['like']) || isset($_POST['dislike']) || isset($_POST['remove'])) {
    $postId = '';
    $action = '';
    $likesState = '';
    $userId = $_SESSION['user']['id'];
    $likeExists = filter_var($_POST['exists'], FILTER_SANITIZE_STRING);

    if (isset($_POST['like'])) {
        $action = 'like';
    }
    if (isset($_POST['dislike'])) {
        $action = 'dislike';
    }
    if (isset($_POST['remove'])) {
        $action = 'remove';
    }
    // sets post id from whichever type was sent in post, sanatized for that extra crispy security :)
    $postId = filter_var($_POST["$action"], FILTER_SANITIZE_STRING);

    if ($likeExists === 'true') {
        if ($action === 'like' || $action === 'dislike') {
            // prepares statement for liking/disliking
            $statement = $pdo->prepare('UPDATE likes SET post_id = :post_id, user_id = :user_id, liked = :liked, disliked = :disliked');

            // setting variables to be used for binding parameteres in statement
            if ($action === 'like') {
                $liked = 'yes';
                $likedType = PDO::PARAM_STR;
                $disliked = '';
                $dislikedType = PDO::PARAM_NULL;
                $likesState = $postId.' is liked.';
            }
            if ($action === 'dislike') {
                $liked = '';
                $likedType = PDO::PARAM_NULL;
                $disliked = 'yes';
                $dislikedType = PDO::PARAM_STR;
                $likesState = $postId.' is disliked.';
            }

            // send info to function that binds parameters to statement and executes it
            setLike($statement, $postId, $userId, $liked, $likedType, $disliked, $dislikedType);
        }

        if ($action === 'remove') {
            removeLike($pdo, $postId, $userId);
            $likesState = $postId.' is removed.';
        }
    } else {
        if ($action === 'like' || $action === 'dislike') {
            // prepares statement for liking/disliking
            $statement = $pdo->prepare('INSERT INTO likes (post_id, user_id, liked, disliked) VALUES (:post_id, :user_id, :liked, :disliked)');

            // setting variables to be used for binding parameteres in statement
            if ($action === 'like') {
                $liked = 'yes';
                $likedType = PDO::PARAM_STR;
                $disliked = '';
                $dislikedType = PDO::PARAM_NULL;
                $likesState = $postId.' is liked.';
            }
            if ($action === 'dislike') {
                $liked = '';
                $likedType = PDO::PARAM_NULL;
                $disliked = 'yes';
                $dislikedType = PDO::PARAM_STR;
                $likesState = $postId.' is disliked.';
            }

            // send info to function that binds parameters to statement and executes it
            setLike($statement, $postId, $userId, $liked, $likedType, $disliked, $dislikedType);
        }

        if ($action === 'remove') {
            removeLike($pdo, $postId, $userId);
            $likesState = $postId.' is removed.';
        }
    }

    // returns some json to tell js that things went as expected
    header('Content-Type: application/json');
    echo json_encode($likesState);
}
