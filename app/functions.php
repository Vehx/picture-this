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
            foreach ($_SESSION['errors'] as $error) { ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $error; ?>
                </div>
<?php
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
     * @param string $userId
     * @param object $database
     *
     * @return array
     */
    function getLikes(array $posts, string $userId, object $database)
    {
        $postsWithLikes = [];
        foreach ($posts as $post) {
            $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND liked = 'yes'");
            $statement->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $statement->execute();
            $postLikes = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $database->prepare("SELECT count(*) FROM likes WHERE post_id = :post_id AND disliked = 'yes'");
            $statement->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $statement->execute();
            $postDislikes = $statement->fetch(PDO::FETCH_ASSOC);

            $post['likes'] = $postLikes['count(*)'] - $postDislikes['count(*)'];
            $post['liked'] = getUserLikes($database, $post['id'], $userId, 'liked');
            $post['disliked'] = getUserLikes($database, $post['id'], $userId, 'disliked');
            $postsWithLikes[] = $post;
        }
        return $postsWithLikes;
    }
}

if (!function_exists('getUserLikes')) {
    /**
     * Checks if user has liked/disliked post previously.
     * Takes id of post and user to check, column to check liked/disliked and database.
     * Returns result stored in column, yes or no in case of liked/disliked.
     * 
     * @param object $database
     * @param int $postId
     * @param string $userId
     * @param string $column
     *
     * @return string
     */
    function getUserLikes(object $database, int $postId, string $userId, string $column)
    {
        $query = "SELECT count(*) FROM likes WHERE post_id = :post_id AND user_id = :user_id AND ";
        if ($column === 'liked') {
            $query = $query . "liked = 'yes'";
        }
        if ($column === 'disliked') {
            $query = $query . "disliked = 'yes'";
        }
        $statement = $database->prepare($query);
        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
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
     * @param object $database
     *
     * @param string $postId
     * @param string $userId
     * 
     * @return void
     */
    function removeLike(object $database, string $postId, string $userId)
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
     * @param object $statment
     * 
     * @param string $postId
     * @param string $userId
     * 
     * @param string $liked
     * @param int $likedType
     * 
     * @param string $disliked
     * @param int $dislikedType
     *
     * @return void
     */
    function setLike(object $statement, string $postId, string $userId, string $liked, int $likedType, string $disliked, int $dislikedType)
    {
        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':liked', $liked, $likedType);
        $statement->bindParam(':disliked', $disliked, $dislikedType);

        $statement->execute();
    }
}

if (!function_exists('getProfile')) {
    /**
     * Gets profile information from the database about the user sent in.
     * 
     * @param object $database
     * @param string $id
     *
     * @return string
     */
    function getProfile(object $database, string $id)
    {
        $query = 'SELECT * FROM users WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();
        $profile = $statement->fetch(PDO::FETCH_ASSOC);

        return $profile;
    }
}

if (!function_exists('updateDatabase')) {
    /**
     * Updates profile information in the database with the user input sent in.
     * 
     * @param object $database
     * @param string $id
     * @param string $column
     * @param string $value
     *
     * @return void
     */
    function updateDatabase(object $database, string $table, string $id, string $column, string $value)
    {
        $query = "UPDATE $table SET $column = :value WHERE id = :id";
        $statement = $database->prepare($query);
        $statement->bindParam(':value', $value, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();
    }
}

if (!function_exists('checkEmail')) {
    /**
     * Gets user by email and returns it, can be used to check if email is already in use.
     * 
     * @param object $database
     * @param string $email
     *
     * @return string
     */
    function checkEmail(object $database, string $email)
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $statement = $database->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('prepareImage')) {
    /**
     * Uploads image and gives it a uuid name.
     * Returns path to set in database.
     * 
     * @param string $imageName
     * @param string $imageTmpName
     * @param bool $isAvatar
     *
     * @return string
     */
    function prepareImage(string $imageName, string $imageTmpName, bool $isAvatar = false)
    {
        $type = 'posts';
        if ($isAvatar) {
            $type = 'avatars';
        }

        // image name is set to a uuid before stored in uploads folder and database
        $uuidName = explode('.', $imageName);
        $uuidName[0] = guidv4();
        $imageRealPath = "app/database/uploads/$type/" . $uuidName[0] . '.' . $uuidName[1];

        // the image path is set with its uuid name and saved in variable for use when storing information in database
        $imageRelativePath = "../database/uploads/$type/" . $uuidName[0] . '.' . $uuidName[1];

        // image is moved to storage in file structure
        move_uploaded_file(
            $imageTmpName,
            $imageRelativePath
        );
        return $imageRealPath;
    }
}

if (!function_exists('isImageOk')) {
    /**
     * Checks if image size and image type is ok.
     * Returns false if either is not after setting an error in $_SESSION['errors'].
     * Returns true if image is ok.
     * 
     * @param int $imageSize
     * @param string $imageType
     *
     * @return bool
     */
    function isImageOk(int $imageSize, string $imageType)
    {

        // checks size and type of image and creates errors if wrong and redirects back with error message
        if ($imageSize > 2000000) {
            $_SESSION['errors'][] = "It's too big!";
            return false;
        }
        if ($imageType !== 'image/png' && $imageType !== 'image/jpg' && $imageType !== 'image/jpeg') {
            $_SESSION['errors'][] = "Thats not a valid file type!";
            return false;
        }

        return true;
    }
}

if (!function_exists('getPosts')) {
    /**
     * Gets posts from database.
     * 
     * @param object $database
     *
     * @return array
     */
    function getPosts(object $database)
    {
        $statement = $database->prepare('SELECT * FROM posts ORDER BY id DESC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('getPost')) {
    /**
     * Gets post from database.
     * 
     * @param object $database
     * @param string $postId
     *
     * @return array
     */
    function getPost(object $database, string $postId)
    {
        $statement = $database->prepare('SELECT * FROM posts WHERE id = :id');
        $statement->bindParam(':id', $postId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('getUserPosts')) {
    /**
     * Gets given users posts from database.
     * 
     * @param object $database
     * @param string $userId
     *
     * @return array
     */
    function getUserPosts(object $database, string $userId)
    {
        $statement = $database->prepare('SELECT * FROM posts WHERE user_id = :user_id ORDER BY id DESC');
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('deletePost')) {
    /**
     * Deletes post from database.
     * Database to delete from, post id to delete and user id of post owner.
     * 
     * @param object $database
     * @param string $postId
     * @param string $userId
     *
     * @return void
     */
    function deletePost(object $database, string $postId, string $userId)
    {
        $statement = $database->prepare('DELETE FROM posts WHERE id = :post_id AND user_id = :user_id');
        $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();
    }
}

if (!function_exists('getPoster')) {
    /**
     * Gets each posts posters information, name and avatar and puts it in the post.
     * @param array $posts
     * @param object $database
     *
     * @return array
     */
    function getPoster(array $posts, object $database)
    {
        $postsWithPoster = [];
        foreach ($posts as $post) {
            $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
            $statement->bindParam(':id', $post['user_id'], PDO::PARAM_INT);
            $statement->execute();
            $poster = $statement->fetch(PDO::FETCH_ASSOC);

            $post['poster_avatar'] = $poster['avatar'];
            $post['poster_name'] = $poster['name'];
            $postsWithPoster[] = $post;
        }
        return $postsWithPoster;
    }
}
