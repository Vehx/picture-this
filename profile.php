<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/app/users/read.php'; ?>

<article>

    <?php
    $name = $_SESSION['profile']['name'];
    $avatar = $_SESSION['profile']['avatar'];
    $biography = $_SESSION['profile']['biography'];
    $email = $_SESSION['profile']['email'];
    ?>
    <h1 class="profile__name">
        <?php echo $name; ?>
    </h1>

    <img class="rounded-circle profile__avatar" height="75" width="75" src="<?php echo $avatar; ?>" alt="<?php echo $name; ?>'s avatar picture">

    <h4 class="profile__biography-title">Biography</h4>
    <p class="profile__biography">
        <?php echo $biography; ?>
    </p>

    <?php
    if ($_SESSION['user']['id'] === $_SESSION['profile']['id']) :
    ?>
        <form action="app/users/update.php" method="POST" enctype="multipart/form-data" class="profile__form hidden">
            <label class="profile__name-label" for="name">Name :</label>
            <input class="profile__name-input" type="text" id="name" name="name" value="<?php echo $name; ?>">
            <br>
            <label class="profile__avatar-label" for="avatar">Avatar :</label>
            <input class="profile__avatar-input" type="file" id="avatar" name="avatar" accept="jpeg, jpg, png">
            <br>
            <label class="profile__biography-label" for="biography">Biography :</label>
            <input class="profile__biography-input" type="text" id="biography" name="biography" value="<?php echo $biography; ?>">
            <br>
            <label class="profile__email-label" for="email">Email :</label>
            <input class="profile__email-input" type="text" id="email" name="email" value="<?php echo $email; ?>">
            <br>
            <button type="submit" class="btn btn-primary profile__submit-btn">Save</button>
        </form>

        <a href="/password.php"><button class="btn btn-primary profile__password-btn hidden">Change password</button></a>
        <button class="btn btn-primary profile__delete-btn hidden">Delete account</button>
        <button class="btn btn-primary profile__cancel-btn hidden">Cancel</button>

        <button class="btn btn-primary profile__edit-btn">Edit</button>

        <script src="assets/scripts/profile.js"></script>
    <?php endif; ?>

    <?php showErrors(); ?>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>