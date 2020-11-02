<article id="change-password">
    <form action="action_change_password.php?username=<?= $user['username']?>" method="post">
        <header>
            <h1>Change Password</h1>
        </header>
        <section id="password">
            <h3>New Password:</h3>
            <input type="password" name="password" id="password">
        </section>
        <input type="submit" value="Submit">
    </form>
</article>