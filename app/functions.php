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
     * @return void
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
