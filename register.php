<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Register</h1>

    <form action="app/users/register.php" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" maxlength="255" placeholder="Francis" value="Paul" required>
            <small class="form-text text-muted">Please provide your name. <br>(This will be visable to other users.)</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="text" name="email" maxlength="255" placeholder="francis@darjeeling.com" value="paul@walker.rip" required>
            <small class="form-text text-muted">Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" minlength="4" maxlength="255" value="test" required>
            <small class="form-text text-muted">Please enter your password (passphrase). <br>Must be 4 characters or longer.</small>
        </div><!-- /form-group -->
        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input class="form-control" type="password" name="password-confirm" minlength="4" maxlength="255" value="test" required>
            <small class="form-text text-muted">Please enter the same as above to confirm your password (passphrase).</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <?php showErrors(); ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>