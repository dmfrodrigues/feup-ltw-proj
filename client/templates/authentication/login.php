<section id="login">
    <header><h2>Sign In</h2></header>
    <form action="<?= PROTOCOL_SERVER_URL ?>/actions/login.php" method="post">
        <label>
            Username <input type="text" name="username" required>
        </label>
        <label>
            Password <input type="password" name="password" required>
        </label>
        <?php 
            if(isset($_GET['failed']) && isset($_GET['errorCode'])) { ?>
                <p id="simple-fail-msg">Sign In Failed! - <?= $errorsArray[$_GET['errorCode']] ?></p>
          <?php } ?>
        <input type="submit" value="Login" id="submit-login">
    </form>
    <a href="">Forgot Password?</a>
    <footer>
        <p>New User? <a href="signup.php">Sign up</a></p>
    </footer>
</section>