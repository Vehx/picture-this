<?php require __DIR__ . '/views/header.php'; ?>

<form action="app/users/update.php" method="post">

    <div class="form-group">
        <label for="email">Current password</label>
        <input class="form-control" type="password" name="password" minlength="4" maxlength="255">
        <small class="form-text text-muted">Please enter your password (passphrase). <br>Must be 4 characters or longer.</small>
    </div><!-- /form-group -->

    <div class="form-group">
        <label for="password">New password</label>
        <input class="form-control" type="password" name="new-password" minlength="4" maxlength="255">
        <small class="form-text text-muted">Please enter your new password (passphrase). <br>Must be 4 characters or longer.</small>
    </div><!-- /form-group -->
    <div class="form-group">
        <label for="password-confirm">Confirm new password</label>
        <input class="form-control" type="password" name="new-password-confirm" minlength="4" maxlength="255">
        <small class="form-text text-muted">Please enter the same as above to confirm your new password (passphrase).</small>
    </div><!-- /form-group -->

    <button type="submit" class="btn btn-primary">Save</button>
</form>

<?php showErrors(); ?>

<?php require __DIR__ . '/views/footer.php'; ?>