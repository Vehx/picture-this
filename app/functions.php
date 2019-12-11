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
