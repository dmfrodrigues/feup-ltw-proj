<section id="comments">
    <h2>Comments</h2>
    <?php
    if (isset($_SESSION['username'])) {
        $user = getUser($_SESSION['username']);
    ?>
        <form id="form-comment" action="action_add_comment" method="post">
            <article class="comment">
                <span class="user"><a href="profile.php?username=<?= $user['username'] ?>"><?= $user['username'] ?></a></span>
                <a class="profile-pic-a" href="profile.php?username?<?= $user['username'] ?>"><img class="profile-pic" src="<?= $user['pictureUrl'] ?>"></a>
                <textarea class="comment-text" name="comment-text" id="comment-text" placeholder="Write a comment..." rows="1"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
                <input type="submit" id="submit-comment" value="Submit">
            </article>
        </form>
    <?php
    }
    ?>
</section>