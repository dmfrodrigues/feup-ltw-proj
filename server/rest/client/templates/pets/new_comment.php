<template id="newComment">
<form class="answer" enctype="multipart/form-data" method="put">
    <input id="comment-petId" name="petId" type="hidden" value="<?= $pet->getId() ?>">
    <input id="comment-username" name="username" type="hidden" value="<?= $user->getUsername() ?>">
    <input id="comment-answerTo" name="answerTo" type="hidden">
    <input id="comment-picture-input" name="picture" type="file" style="display:none;" onchange="onChangeCommentPictureInput(this)">
    <?php 
    $petLink = "<a href='" . PROTOCOL_API_URL . '/pet/' . $pet->getId() . "'>" . $pet->getName() . "</a>";
    $userLink = "<a href='" . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . "'>" . $_SESSION['username'] . "</a>";
    ?>
    <input type="hidden" name="petLink" value="<?=$petLink?>">
    <input type="hidden" name="petOwner" value="<?=$pet->getPostedById()?>"> 
    <input type="hidden" name="userLink" value="<?=$userLink?>">
    <article class="comment">
        <span id="comment-user" class="user"><a href="<?= PROTOCOL_API_URL ?>/user/#">#</a></span>
        <a id="comment-profile-pic-a" class="profile-pic-a" href="<?= PROTOCOL_API_URL ?>/user/#"><img class="profile-pic" src=""></a>
        <div id="comment-content">
            <textarea id="comment-text" class="comment-text" name="text" placeholder="Write a comment..." rows="1"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
            <img id="comment-picture" class="comment-picture" src="">
        </div>
        <div id="comment-actions" class="actions">
            <img class="icon" src="<?= PROTOCOL_CLIENT_URL ?>/resources/img/annex.svg" onclick="this.parentNode.parentNode.parentNode.querySelector('#comment-picture-input').click()" title="Add picture">
            <input type="submit" id="comment-submit" value="Submit">
        </div>
    </article>
</form>
</template>
<script>
    function newComment_checkTextOrImage(newCommentForm){
        let text = newCommentForm.querySelector('#comment-text');
        let file = newCommentForm.querySelector('#comment-picture-input');
        let good = (text.value != '' || file.value != '');
        if(!good) alert("New comment must have at least text or an image.");
        return good;
    }

    function newComment_submitForm(newCommentForm){
        let files = newCommentForm.querySelector('#comment-picture-input').files;
        let picture = (files.length <= 0 ? null : files[0]);

        if(picture !== null){
            api.put(
                'comment/photo',
                picture
            )
            .then((response) => response.json())
            .then((tmpPhotoId) =>
                api.put(
                    'comment',
                    {
                        petId   : newCommentForm.querySelector('#comment-petId'        ).value,
                        username: newCommentForm.querySelector('#comment-username'     ).value,
                        answerTo: newCommentForm.querySelector('#comment-answerTo'     ).value,
                        text    : newCommentForm.querySelector('#comment-text'         ).value,
                        picture : tmpPhotoId
                    }
                )
            )
            .then(function (response){
                updateCommentsSection();
            });
        } else {
            api.put(
                'comment',
                {
                    petId   : newCommentForm.querySelector('#comment-petId'        ).value,
                    username: newCommentForm.querySelector('#comment-username'     ).value,
                    answerTo: newCommentForm.querySelector('#comment-answerTo'     ).value,
                    text    : newCommentForm.querySelector('#comment-text'         ).value,
                    picture : null
                }
            )
            .then(function (response){
                updateCommentsSection();
            });
        }

        let petOwner = document.querySelector('input[name=petOwner]').value;
        let petLink = document.querySelector('input[name=petLink]').value;
        let userLink = newCommentForm.querySelector('input[name=userLink]').value

        api.put(
            `notification`,
            {
                username: petOwner,
                subject : `newMessage`,
                text    : `The user ` + userLink + " commented your pet " +  petLink + "."
            }
        );
        
    }

    function newComment_onSubmit(e){
        e.preventDefault();

        newCommentForm = e.target;

        newComment_checkTextOrImage(newCommentForm);
        newComment_submitForm(newCommentForm);
        return false;
    }

    if(typeof Template === 'undefined') Template = {};
    Template.newComment = function (comment, user) {
        if(typeof Template.newComment.template === 'undefined')
            Template.newComment.template = document.querySelector("template#newComment").content.firstElementChild;

        let answerElement = Template.newComment.template.cloneNode(true);
        
        answerElement.id = `new-comment-${comment.id}`;

        let el_answerTo = answerElement.querySelector('#comment-answerTo');
        el_answerTo.value = comment.id;

        let el_user = answerElement.querySelector("#comment-user");
        el_user.children[0].href = `<?= PROTOCOL_API_URL ?>/user/${user.username}`;
        el_user.children[0].innerHTML = user.username;

        let el_pic = answerElement.querySelector("#comment-profile-pic-a");
        el_pic.href = `<?= PROTOCOL_API_URL ?>/user/${user.username}`;
        el_pic.children[0].src = API_URL + `user/${user.username}/photo?csrf=<?=$_SESSION['csrf']?>`;

        answerElement.addEventListener('submit', (e) => { newComment_onSubmit(e); });

        return answerElement;
    }
</script>
