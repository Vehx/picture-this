<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     * With a http response code, 200 by default.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}

if (!function_exists('showErrors')) {
    /**
     * If errors exists in $_SESSION['errors'] this function echo's them out.
     * When done it empties $_SESSION['errors']
     *
     * @return void
     */
    function showErrors()
    {
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo $error;
            }
            unset($_SESSION['errors']);
        }
    }
}

if (!function_exists('isLoggedIn')) {
    /**
     * Checks if user is logged in or not, returns true or false.
     *
     * @return bool
     */
    function isLoggedIn()
    {
        // todo add logic for function
    }
}

if (!function_exists('guidv4')) {
    /**
     * This creates a uuid for image names using com_create_guid on windows.
     * With a linux fallback using openssl.
     *
     * Returns generated uuid as a string.
     * @return string
     */
    function guidv4()
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

if (!function_exists('getLikes')) {
    /**
     * Checks if user has liked/disliked post previously.
     * @param array $posts
     * @param mixed $database
     *
     * @return array
     */
    function getLikes($posts, $database)
    {
        // todo add logic for function
        // needs to work with both likes.phps check for user already liked post
        // and posts/read.phps check to see how many likes a post has and if one of them is from current user
        $postsWithLikes = [];
        foreach ($posts as $post) {
            $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND liked = 'yes'");
            $statement->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $statement->execute();
            $postLikes = intval($statement->fetch(PDO::FETCH_ASSOC));

            $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND disliked = 'yes'");
            $statement->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $statement->execute();
            $postDislikes = intval($statement->fetch(PDO::FETCH_ASSOC));

            $post['likes'] = $postLikes - $postDislikes;
            $post['liked'] = 'no';
            $post['disliked'] = 'no';

            $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND user_id = :user_id AND liked = 'yes'");
            $statement->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
            $statement->execute();
            $postLiked = $statement->fetch(PDO::FETCH_ASSOC);
            // $post['liked'] = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND user_id = :user_id AND disliked = 'yes'");
            $statement->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
            $statement->execute();
            $postDisliked = $statement->fetch(PDO::FETCH_ASSOC);
            // $post['disliked'] = $statement->fetch();

            if ($postLiked['count(*)'] === '1') {
                $post['liked'] = 'yes';
            }
            if ($postDisliked['count(*)'] === '1') {
                $post['disliked'] = 'yes';
            }
            $postsWithLikes[] = $post;
        }
        return $postsWithLikes;
    }
}

if (!function_exists('getUserLikes')) {
    /**
     * Checks if user has liked/disliked post previously.
     * Takes id of post to check, column to check liked/disliked and database.
     * Returns result stored in column, yes or no in case of liked/disliked.
     * 
     * @param string $postId
     * @param string $column
     * @param mixed $database
     *
     * @return array
     */
    function getUserLikes($postId, $column, $database)
    {
        // todo add logic for function
        // needs to work with both likes.phps check for user already liked post
        // and posts/read.phps check to see how many likes a post has and if one of them is from current user
        $userLikesOnPost = [];
        $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND user_id = :user_id AND :column = 'yes'");
        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $statement->bindParam(':column', $column, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $userLikesOnPost = $result['count(*)'];
        return $userLikesOnPost;
    }
}

if (!function_exists('removeLike')) {
    /**
     * Removes like from database. Send in database, postId and userId.
     * Function will then query database with delete statement.
     * 
     * @param mixed $database
     *
     * @param string $postId
     * @param string $userId
     * 
     * @return void
     */
    function removeLike($database, $postId, $userId)
    {
        $statement = $database->prepare('DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id');
        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();
    }
}

if (!function_exists('setLike')) {
    /**
     * Takes in pdo statement, postid for targetted post, current users userid.
     * liked and disliked can be string yes or null.
     * likedType and dislikedType are pdo param variables,
     * either PDO::PARAM_STR or PDO::PARAM_NULL depending on what like and disliked is set to.
     * 
     * @param mixed $statment
     * 
     * @param string $postId
     * @param string $userId
     * 
     * @param mixed $liked
     * @param mixed $likedType
     * 
     * @param mixed $disliked
     * @param mixed $dislikedType
     *
     * @return void
     */
    function setLike($statement, $postId, $userId, $liked, $likedType, $disliked, $dislikedType)
    {
        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':liked', $liked, $likedType);
        $statement->bindParam(':disliked', $disliked, $dislikedType);

        $statement->execute();
    }
}
