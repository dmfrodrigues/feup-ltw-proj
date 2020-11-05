function createTree(comments){
    /// Initialize tree
    let tree = new Map();
    root = new Comment(
        null,
        null,
        null,
        null,
        null,
        null,
        null
    );
    for(let i = 0; i < comments.length; ++i){
        let c = comments[i];
        let id = parseInt(c.id);
        tree.set(id, new Comment(
            parseInt(c.id),
            parseInt(c.pet),
            c.user,
            c.pictureUrl,
            c.postedOn,
            c.text,
            (c.answerTo === null ? null : parseInt(c.answerTo))
        ));
    }
    /// Build tree
    for(let [id, c] of tree){
        if(c.parent === null) root.addChild(c);
        else                  tree.get(c.parent).addChild(c);
    }
    /// Sort children
    root.sortChildren();
    for(let [id, c] of tree)
        c.sortChildren();
    /// Return
    return root;
}

function cloneNodeRecursive(element){
    let ret = element.cloneNode();
    for(let i = 0; i < element.children.length; ++i){
        let child = cloneNodeRecursive(element.children[i]);
        ret.appendChild(child);
    }
    return ret;
}

function createCommentElement(comment){
    let commentElement = cloneNodeRecursive(document.querySelector("#templates>#comment"));
    commentElement.id = `comment-${comment.id}`;
    
    let el_user = commentElement.querySelector("#comment-user");
    el_user.children[0].href = `profile.php?username=${comment.user}`;
    el_user.children[0].innerHTML = comment.user;
    
    let el_pic = commentElement.querySelector("#comment-profile-pic-a");
    el_pic.href=`profile.php?username=${comment.user}`;
    el_pic.children[0].src = comment.pictureUrl;

    let el_date = commentElement.querySelector("#comment-date"); el_date.innerHTML = comment.postedOn;
    let el_text = commentElement.querySelector("#comment-text"); el_text.innerHTML = comment.text;

    return commentElement;
}

function createAnswerElement(commentId){
    let answerElement = cloneNodeRecursive(document.querySelector("#templates>#new-comment"));
    answerElement.id = `new-comment-${commentId}`;

    let el_user = answerElement.querySelector("#comment-user");
    el_user.children[0].href = `profile.php?username=${user.username}`;
    el_user.children[0].innerHTML = user.username;
    
    let el_pic = answerElement.querySelector("#comment-profile-pic-a");
    el_pic.href=`profile.php?username=${user.username}`;
    el_pic.children[0].src = user.pictureUrl;

    return answerElement;
}

function addCommentToDocument(parent, comment){
    let commentElement = createCommentElement(comment);
    let detailsElement = commentElement.querySelector("details");

    if(typeof user !== 'undefined'){
        let actions_el = commentElement.querySelector(".actions");
        actions_el.style.display = "";

        let action_reply_el = actions_el.querySelector("#action-reply");
        action_reply_el.onclick = clickedCommentReply;

        let answerElement = createAnswerElement(comment.id);
        answerElement.style.display="none";
        commentElement.insertBefore(
            answerElement,
            detailsElement
        );
    }

    parent.appendChild(commentElement);

    if(comment.children.length > 0){
        for(let i = 0; i < comment.children.length; ++i){
            addCommentToDocument(detailsElement, comment.children[i]);
        }
    } else {
        detailsElement.style.display = "none"; 
    }
}

function clickedCommentReply(event){
    let id_string = event.target.parentElement.parentElement.parentElement.id;
    let id = parseInt(id_string.split("-")[1]);

    let new_comment_el = document.getElementById(`new-comment-${id}`);
    new_comment_el.style.display = (new_comment_el.style.display === "none" ? "" : "none");
}

$(document).ready(function(){
    let root = createTree(comments);
    let commentsSection = document.getElementById("comments");
    if(typeof user !== 'undefined'){
        commentsSection.appendChild(createAnswerElement(null));
    }
    for(let i = 0; i < root.children.length; ++i){
        addCommentToDocument(commentsSection, root.children[i]);
    }    
});
