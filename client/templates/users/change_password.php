<article id="change-password">
    <form method="post" onsubmit="return signup_check()" action="<?= PROTOCOL_SERVER_URL ?>/actions/change_password.php?username=<?=$user->getUsername()?>">
        <header>
            <h1>Change Password</h1>
        </header>
        <label>New Password:<br>
            <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
        <br>
        <label> Repeat Password:<br>
            <input type="password" id="rpt_pwd" placeholder="Password" required></label>
        <br>
            <?php if(isset($_GET['failed']) && isset($_GET['errorCode'])) { ?>
                <p id="simple-fail-msg">Sign In Failed! - <?= $errorsArray[$_GET['errorCode']] ?></p>
            <?php } ?>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Submit" id="submit-password">
    </form>
</article>