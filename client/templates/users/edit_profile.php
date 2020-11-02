<article id="edit-profile">
    <form action="action_edit_profile.php?username=<?=$user['username']?>" method="post">
        <header>
            <h1>Edit Profile</h1>
        </header>
        <section id="profile-photo">
            <h3>Profile Photo:</h3>
            <img src="<?=$user['pictureUrl']?>">
            <h1>✎</h1></br>
        </section>
        <section id="name">
            <h3>Name:</h3>
            <textarea name="name"><?=$user['name']?></textarea>
        </section>
        <section id="username">
            <h3>Username:</h3>
            <textarea name="username"><?=$user['username']?></textarea>
        </section>
        <section id="password">
            <h3>Change password</h3>
            <a href="change_password.php?username=<?= $user['username']?>"><h1>✎</h1></br></a>
        </section>
        <input type="submit" value="Submit">
    </form>
</article>