<article id="change-password">
    <form method="post" onsubmit="return onSubmit_resetPasswordNew(el)">
        <header>
            <h1>Change Password</h1>
        </header>
        <label>New Password:<br>
            <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
        <br>
        <label> Repeat Password:<br>
            <input type="password" id="rpt_pwd" placeholder="Password" required></label>
        <input type="submit" value="Submit">
    </form>
</article>
