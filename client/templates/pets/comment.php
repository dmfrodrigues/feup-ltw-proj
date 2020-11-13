<div id="comment" class="comment">
    <article class="comment">
        <span id="comment-user" class="user">
            <a href="profile.php?username="></a>
        </span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="profile.php?username=">
            <img class="profile-pic" src="">
        </a>
        <span id="comment-date" class="date">2020-31-12 00:00:00</span>
        <div id="comment-content">
            <p id="comment-text" class="comment-text"></p>
            <img id="comment-picture" class="comment-picture" src="">
        </div>
        <div id="comment-actions" class="actions" style="display: none;">
            <img id="action-edit"  class="icon" src="resources/img/edit.svg" onclick="clickedCommentEdit (this.parentNode.parentNode.parentNode)" style="display: none;" title="Edit comment">
            <form id="action-delete" action="<?= SERVER_URL ?>/actions/delete_comment.php" method="post" style="display: none;" title="Delete comment">
                <input id="action-delete-id" name="id" type="hidden">
                <input id="action-delete-submit" type="submit" style="display: none">
                <img class="icon" src="resources/img/trash.svg" onclick="this.parentNode.querySelector('#action-delete-submit').click()">
            </form>
            <img id="action-reply" class="icon" src="resources/img/reply.svg" onclick="clickedCommentReply(this.parentNode.parentNode.parentNode)" title="Reply">
        </div>
    </article>
    <details id="comment-answers" class="comment-details" open>
        <summary></summary>
    </details>
</div>
