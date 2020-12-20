<article id="change-password">
    <form method="post" onsubmit="return signup_check()" action="<?= PROTOCOL_SERVER_URL ?>/actions/change_password.php?username=<?=$user->getUsername()?>">
        <header>
            <h1>Change Password</h1>
        </header>
        <label>New Password:
            <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
        <label> Repeat Password:
            <input type="password" id="rpt_pwd" placeholder="Password" required></label>
        <?php if(isset($_GET['failed']) && isset($_GET['errorCode'])) { ?>
            <p id="simple-fail-msg">Change password failed! - <?= $errorsArray[$_GET['errorCode']] ?></p>
        <?php } ?>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Submit" id="submit-password">
    </form>
</article>