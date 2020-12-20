<template id="comment">
<div class="comment">
    <article class="comment">
        <span id="comment-user" class="user">
            <a href="user/"></a>
        </span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="user/">
            <img class="profile-pic" src="">
        </a>
        <span id="comment-date" class="date">2020-31-12 00:00:00</span>
        <div id="comment-content" <?php if(!isset($_SESSION['username'])) echo 'class="noedit"'; ?>>
            <p id="comment-text" class="comment-text"></p>
            <img id="comment-picture" class="comment-picture" src="">
        </div>
        <div id="comment-actions" class="actions" style="display: none;">
            <img id="action-edit"  class="icon" src="rest/client/resources/img/edit.svg" onclick="onClickCommentEdit (this.parentNode.parentNode.parentNode)" style="display: none;" title="Edit comment">
            <form id="action-delete" action="actions/delete_comment.php" method="post" style="display: none;" title="Delete comment">
                <input id="action-delete-id" name="id" type="hidden">
                <input id="action-delete-submit" name="submit" type="submit" style="display: none">
                <img class="icon" src="rest/client/resources/img/trash.svg" onclick="this.parentNode.querySelector(`input[name='submit']`).click()">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            </form>
            <img id="action-reply" class="icon" src="rest/client/resources/img/reply.svg" onclick="onClickCommentReply(this.parentNode.parentNode.parentNode)" title="Reply">
        </div>
    </article>
    <details id="comment-answers" class="comment-details" open>
        <summary></summary>
    </details>
</div>
</template>
<script>
    function onClickCommentEdit(comment_el) {
        let id_string = comment_el.id;
        let id = parseInt(id_string.split("-")[1]);

        let article_el = comment_el.querySelector(".comment");
        article_el.style.display = "none";

        let edit_comment_el = document.getElementById(`edit-comment-${id}`);
        edit_comment_el.style.display = "";
    }

    function onClickCommentReply(comment_el) {
        let id_string = comment_el.id;
        let id = parseInt(id_string.split("-")[1]);

        let new_comment_el = document.getElementById(`new-comment-${id}`);
        new_comment_el.style.display = (new_comment_el.style.display === "none" ? "" : "none");
    }

    if(typeof Template === 'undefined') Template = {};
    Template.comment = function (comment) {
        if(typeof Template.comment.template === 'undefined')
            Template.comment.template = document.querySelector("template#comment").content.firstElementChild;

        let commentElement = Template.comment.template.cloneNode(true);
        
        commentElement.id = `comment-${comment.id}`;

        let el_user = commentElement.querySelector("#comment-user");
        el_user.children[0].href = `user/${comment.user}`;
        el_user.children[0].innerHTML = comment.user;

        let el_pic = commentElement.querySelector("#comment-profile-pic-a");
        el_pic.href = `user/${comment.user}`;
        el_pic.children[0].src = `user/${comment.user}/photo`;

        let el_date = commentElement.querySelector("#comment-date"); el_date.innerHTML = comment.postedOn;
        let el_text = commentElement.querySelector("#comment-text"); el_text.innerHTML = comment.text;
        if (el_text.innerHTML === '') el_text.style.display = "none";
        let el_img = commentElement.querySelector("#comment-picture");
        api.head(`comment/${comment.id}/photo`)
        .then(function(response){
            if(response.status == 200) el_img.src = `comment/${comment.id}/photo`;
            else                       el_img.src = '';
        })
        .catch(function(error){
            console.error(error);
            el_img.src = '';
        })
        
        let el_deleteId = commentElement.querySelector("#action-delete-id"); el_deleteId.value = `${comment.id}`;

        // Change IDs
        let el_action_delete        = commentElement.querySelector('#action-delete'       ); el_action_delete       .id = `action-delete-${comment.id}`;
        let el_action_delete_id     = commentElement.querySelector('#action-delete-id'    ); el_action_delete_id    .id = `action-delete-id-${comment.id}`;
        let el_action_delete_submit = commentElement.querySelector('#action-delete-submit'); el_action_delete_submit.id = `action-delete-submit-${comment.id}`;

        return commentElement;
    }
</script>
