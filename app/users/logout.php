<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';
// In this file we logout users.

// todo add some sort of msg to confirm logout happened
// Remove the user session variable and redirect the user back to the homepage.
unset($_SESSION['user']);

redirect('/');
