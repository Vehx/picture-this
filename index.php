<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>This is the home page.</p>
</article>

<?php if (isset($_SESSION['user'])) : ?>
    <section>
        <form action="app/posts/create.php" method="POST" enctype="multipart/form-data" class="post__form hidden">
            <label for="title">Title : </label>
            <input type="text" name="title" id="title" required>
            <label for="hashtags">Hashtags (optional) : </label>
            <input type="text" name="hashtags" id="hashtags">
            <label for="image">Image : </label>
            <input type="file" name="image" id="image" accept="jpeg, jpg, png" required>
            <button type="submit" class="btn btn-primary post__submit-btn">Submit post</button>
        </form>
        <button class="btn btn-primary post__create-btn">Create post</button>
    </section>
    <section class="post__container"></section>
    <script src="assets/scripts/posts.js"></script>
<?php endif; ?>
<?php showErrors(); ?>

<?php require __DIR__ . '/views/footer.php'; ?>