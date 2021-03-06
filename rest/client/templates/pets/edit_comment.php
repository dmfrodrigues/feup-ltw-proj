<template id="editComment">
<form class="edit" enctype="multipart/form-data" onsubmit="return editComment_checkTextOrImage(this)" method="put">
    <input name="commentId" type="hidden">
    <input name="picture" type="file" style="display:none;" onchange="onChangeCommentPictureInput(this)">
    <input name="deleteFile" type="hidden" value="0">
    <article class="comment">
        <span id="comment-user" class="user"><a href="user/#">#</a></span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="user/#"><img class="profile-pic" src=""></a>
        <div id="comment-content">
            <textarea class="comment-text" name="text" placeholder="Write a comment..." rows="1"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
            <img id="comment-picture" class="comment-picture" src="">
        </div>
        <div id="comment-actions" class="actions">
            <img class="icon" src="rest/client/resources/img/annex.svg" onclick="this.parentNode.parentNode.parentNode.querySelector(`input[name='picture']`).click()" title="Add picture">
            <img class="icon" src="rest/client/resources/img/cross.svg" onclick="editComment_removePicture(this.parentNode.parentNode.parentNode)" title="Erase picture">
            <input type="submit" class="comment-submit" value="Submit">
        </div>
    </article>
</form>
</template>
<script>
    function editComment_checkTextOrImage(comment){
        let text = comment.querySelector('textarea[name="text"]');
        let file = comment.querySelector('input[name="picture"]');
        let deleteFile = comment.querySelector('input[name="deleteFile"]');
        let good = (text.value != '' || file.value != '' || deleteFile.value === '0');
        if(!good) alert("Edited comment must have at least text or an image.");
        return good;
    }

    function editComment_removePicture(comment){
        let deleteFile = comment.querySelector('input[name="deleteFile"]');
        deleteFile.value = "1";
        let inputFile = comment.querySelector('input[name="picture"]');
        inputFile.value = "";
        let img = comment.querySelector('#comment-picture');
        img.src = "";
    }

    function editComment_submitForm(editCommentForm){
        let id_split = editCommentForm.id.split('-');
        let id = id_split[id_split.length-1];

        let files = editCommentForm.querySelector('input[name="picture"]').files;
        let picture = (files.length <= 0 ? null : files[0]);
        let deleteFile = (
            editCommentForm.querySelector('input[name="deleteFile"]').value === "1" &&
            picture === null
        );

        api.put(
            `comment/${id}`,
            {
                text: editCommentForm.querySelector('textarea[name="text"]').value,
            }
        )
        .then(function (response){
            if     (deleteFile      ) return api.delete(`comment/${id}/photo`);
            else if(picture !== null) return api.put   (`comment/${id}/photo`, picture);
            else                      return Promise.resolve('');
        })
        .then(function(response){ updateCommentsSection(); });
    }

    function editComment_onSubmit(e){
        e.preventDefault();

        editCommentForm = e.target;

        newComment_checkTextOrImage(editCommentForm);
        editComment_submitForm(editCommentForm);
    }

    if(typeof Template === 'undefined') Template = {};
    Template.editComment = function (comment) {
        if(typeof Template.editComment.template === 'undefined')
            Template.editComment.template = document.querySelector("template#editComment").content.firstElementChild;

        let editElement = Template.editComment.template.cloneNode(true);

        editElement.id = `edit-comment-${comment.id}`;

        let el_commentId = editElement.querySelector('input[name="commentId"]');
        el_commentId.value = comment.id;

        let el_user = editElement.querySelector("#comment-user");
        el_user.children[0].href = `user/${comment.user}`;
        el_user.children[0].innerHTML = comment.user;

        let el_userPic = editElement.querySelector("#comment-profile-pic-a");
        el_userPic.href = `user/${comment.user}`;
        el_userPic.children[0].src = `user/${comment.user}/photo?csrf=<?=$_SESSION['csrf']?>`;

        let el_text = editElement.querySelector('textarea[name="text"]');
        el_text.value = comment.text;

        let el_img = editElement.querySelector("#comment-picture");
        api.head(`comment/${comment.id}/photo`)
        .then(function(response){
            if(response.status == 200) el_img.src = `comment/${comment.id}/photo?csrf=<?=$_SESSION['csrf']?>`;
            else                       el_img.src = '';
        })
        .catch(function(error){
            console.error(error);
            el_img.src = '';
        })

        editElement.addEventListener('submit', (e) => { editComment_onSubmit(e); })

        return editElement;
    }
</script>
