<article id="change-password">
    <form method="post" onsubmit="return signup_check()" action="action_change_password.php?username=<?=$user['username']?>">
        <header>
            <h1>Change Password</h1>
        </header>
        <label>New Password:<br>
            <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
        <br>
        <label> Repeat Password:<br>
            <input type="password" id="rpt_pwd" placeholder="Password" required></label>
        <br>
        <input type="submit" value="Submit">
    </form>
</article>