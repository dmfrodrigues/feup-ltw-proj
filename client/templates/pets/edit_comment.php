<template id="editComment">
    <form class="edit" enctype="multipart/form-data" onsubmit="return editComment_checkTextOrImage(this)" action="<?= PROTOCOL_SERVER_URL ?>/actions/edit_comment.php" method="post">
        <input id="commentId" name="commentId" type="hidden">
        <input id="comment-picture-input" name="picture" type="file" style="display:none;" onchange="onChangeCommentPictureInput(this)">
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
</template>
<script>
    if(typeof Template === 'undefined') Template = {};
    Template.editComment = function (comment) {
        if(typeof Template.editComment.template === 'undefined')
            Template.editComment.template = document.querySelector("template#editComment").content.firstElementChild;

        let editElement = Template.editComment.template.cloneNode(true);

        editElement.id = `edit-comment-${comment.id}`;

        let el_commentId = editElement.querySelector('#commentId');
        el_commentId.value = comment.id;

        let el_user = editElement.querySelector("#comment-user");
        el_user.children[0].href = `profile.php?username=${comment.user}`;
        el_user.children[0].innerHTML = comment.user;

        let el_userPic = editElement.querySelector("#comment-profile-pic-a");
        el_userPic.href = `profile.php?username=${comment.user}`;
        el_userPic.children[0].src = (comment.userPictureUrl !== null ? comment.userPictureUrl : 'resources/img/no-image.svg');

        let el_text = editElement.querySelector("#comment-text");
        el_text.value = comment.text;

        let el_img = editElement.querySelector("#comment-picture");
        el_img.src = (comment.commentPictureUrl !== null ? comment.commentPictureUrl : '');

        return editElement;
    }
</script>
