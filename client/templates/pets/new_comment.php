<template id="newComment">
    <form class="answer" enctype="multipart/form-data" onsubmit="return newComment_checkTextOrImage(this)" action="<?= PROTOCOL_SERVER_URL ?>/actions/add_comment.php" method="post">
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
</template>
<script>
    if(typeof Template === 'undefined') Template = {};
    Template.newComment = function (comment, user) {
        if(typeof Template.newComment.template === 'undefined')
            Template.newComment.template = document.querySelector("template#newComment").content.firstElementChild;

        let answerElement = Template.newComment.template.cloneNode(true);
        
        answerElement.id = `new-comment-${comment.id}`;

        let el_answerTo = answerElement.querySelector('#comment-answerTo');
        el_answerTo.value = comment.id;

        let el_user = answerElement.querySelector("#comment-user");
        el_user.children[0].href = `profile.php?username=${user.username}`;
        el_user.children[0].innerHTML = user.username;

        let el_pic = answerElement.querySelector("#comment-profile-pic-a");
        el_pic.href = `profile.php?username=${user.username}`;
        el_pic.children[0].src = (user.pictureUrl !== null ? user.pictureUrl : 'resources/img/no-image.svg');

        return answerElement;
    }
</script>
