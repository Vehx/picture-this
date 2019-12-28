<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/app/users/read.php'; ?>

<article>

    <?php
    // if (isset($_GET['uid'])) {
    //     require __DIR__ . '/views/profile.php';
    // } else {
    //     require __DIR__ . '/views/oprofile.php';
    // }
    ?>
    <h1>
        <?php
        echo $_SESSION['profile']['name'];
        ?>
    </h1>

    <img src="<?php echo $_SESSION['profile']['avatar']; ?>" alt="<?php echo $_SESSION['profile']['name']; ?>'s profile avatar picture">

    <h4>Biography</h4>
    <p>
        <?php
        echo $_SESSION['profile']['biography'];
        ?>
    </p>

    <?php showErrors(); ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>