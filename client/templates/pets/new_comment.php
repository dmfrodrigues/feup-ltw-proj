<form id="new-comment" class="answer" action="action_add_comment.php" method="post">
    <input id="comment-answerTo" name="answerTo" type="hidden">
    <article class="comment">
        <span id="comment-user" class="user"><a href="profile.php?username=#">#</a></span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="profile.php?username?#"><img class="profile-pic" src="#"></a>
        <textarea id="comment-text" class="comment-text" name="comment-text" placeholder="Write a comment..." rows="1"
            oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
        <input type="submit" id="comment-submit" value="Submit">
    </article>
</form>
