<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>The site to share your imgs.</p>
</article>

<?php if (isset($_SESSION['user'])) { ?>
    <section>
        <form action="app/posts/create.php" method="POST" enctype="multipart/form-data" class="post__form hidden">
            <div class="form-group">
                <label for="image">Image : </label>
                <input type="file" name="image" id="image" accept="jpeg, jpg, png" required>
            </div><!-- /form-group -->
            <div class="form-group">
                <label for="description">Description (optional) : </label>
                <input type="text" name="description" id="description">
            </div><!-- /form-group -->
            <button type="submit" class="btn btn-primary post__submit-btn">Submit post</button>
        </form>
        <button class="btn btn-primary post__create-btn">Create post</button>
        <button class="mt-2 btn btn-secondary post__cancel-btn hidden">Cancel</button>
    </section>
    <section class="post__container"></section>
    <script>
        const userId = "<?php echo $_SESSION['user']['id']; ?>";
    </script>
    <script src="assets/scripts/likes.js"></script>
    <script src="assets/scripts/posts.js"></script>
<?php } ?>

<?php showErrors(); ?>
<?php require __DIR__.'/views/footer.php'; ?>