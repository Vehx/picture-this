<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/"><?php echo $config['title']; ?></a>

    <ul class="navbar-nav">

        <?php if (isset($_SESSION['user'])) : ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/profile.php' ? 'active' : ''; ?>" href="profile.php">Profile</a>
            </li><!-- /nav-item -->
        <?php endif; ?>

        <li class="nav-item">
            <?php if (isset($_SESSION['user'])) : ?>
                <a class="nav-link" href="/app/users/logout.php">Logout</a>
            <?php else : ?>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
            <?php endif; ?>
        </li><!-- /nav-item -->

        <?php if (!isset($_SESSION['user'])) : ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/register.php' ? 'active' : ''; ?>" href="register.php">Register</a>
            </li><!-- /nav-item -->
        <?php endif; ?>

    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->