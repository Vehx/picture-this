<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>This is the home page.</p>
</article>

<?php if (isset($_SESSION['user'])) : ?>
    <section>
        <form action="app/posts/store.php" method="POST" enctype="multipart/form-data" class="post-form hidden">
            <label for="title">Title : </label>
            <input type="text" name="title" id="title" required>
            <label for="hashtags">Hashtags (optional) : </label>
            <input type="text" name="hashtags" id="hashtags">
            <label for="image">Image : </label>
            <input type="file" name="image" id="image" accept="jpeg, jpg, png" required>
            <button type="submit" class="btn btn-primary submit-post-btn">Submit post</button>
        </form>
        <button class="btn btn-primary create-post-btn">Create post</button>
    </section>
<?php endif; ?>
<?php showErrors(); ?>

<?php require __DIR__ . '/views/footer.php'; ?>