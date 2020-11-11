<form id="edit-comment" class="edit" enctype="multipart/form-data" onsubmit="return editComment_checkTextOrImage(this)" action="<?= SERVER_URL ?>/action_edit_comment.php" method="post">
    <input id="commentId" name="commentId" type="hidden">
    <input id="comment-picture-input" name="picture" type="file" style="display:none;">
    <input id="comment-deleteFile" name="deleteFile" type="hidden" value="0">
    <article class="comment">
        <span id="comment-user" class="user"><a href="profile.php?username=#">#</a></span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="profile.php?username=#"><img class="profile-pic" src="#"></a>
        <div id="comment-content">
            <textarea id="comment-text" class="comment-text" name="text" placeholder="Write a comment..." rows="1"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
            <img id="comment-picture" class="comment-picture" src="">
        </div>
        <div id="comment-actions" class="actions">
            <img class="icon" src="resources/img/annex.svg" onclick="this.parentNode.parentNode.parentNode.querySelector('#comment-picture-input').click()" title="Add picture">
            <img class="icon" src="resources/img/cross.svg" onclick="editComment_removePicture(this.parentNode.parentNode.parentNode)" title="Erase picture">
            <input type="submit" id="comment-submit" value="Submit">
        </div>
    </article>
</form>
