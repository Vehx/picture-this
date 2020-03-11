<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>Search for posts.</p>
</article>

<?php if (isset($_SESSION['user'])) { ?>

    <form action="app/posts/search.php" method="POST" class="search__form">
        <div class="form-group">
            <label for="search">Search : </label>
            <input type="text" name="search" id="search" required>
        </div><!-- /form-group -->
    </form>

    <section class="post__container"></section>
    <script>
        const userId = "<?php echo $_SESSION['user']['id']; ?>";
    </script>
    <script src="assets/scripts/likes.js"></script>
    <script src="assets/scripts/search.js"></script>
<?php } ?>

<?php showErrors(); ?>
<?php require __DIR__.'/views/footer.php'; ?>