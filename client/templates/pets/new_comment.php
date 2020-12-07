<form id="new-comment" class="answer" enctype="multipart/form-data" onsubmit="return newComment_checkTextOrImage(this)" action="<?= SERVER_URL ?>/actions/add_comment.php" method="post">
    <input id="comment-petId" name="petId" type="hidden" value="<?= $pet['id'] ?>">
    <input id="comment-username" name="username" type="hidden" value="<?= $user['username'] ?>">
    <input id="comment-answerTo" name="answerTo" type="hidden">
    <input id="comment-picture-input" name="picture" type="file" style="display:none;" onchange="onChangeCommentPictureInput(this)">
    <article class="comment">
        <span id="comment-user" class="user"><a href="profile.php?username=#">#</a></span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="profile.php?username?#"><img class="profile-pic" src="#"></a>
        <div id="comment-content">
            <textarea id="comment-text" class="comment-text" name="text" placeholder="Write a comment..." rows="1"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
            <img id="comment-picture" class="comment-picture" src="">
        </div>
        <div id="comment-actions" class="actions">
            <img class="icon" src="resources/img/annex.svg" onclick="this.parentNode.parentNode.parentNode.querySelector('#comment-picture-input').click()" title="Add picture">
            <input type="submit" id="comment-submit" value="Submit">
        </div>
    </article>
</form>
