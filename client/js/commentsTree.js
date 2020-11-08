class CommentTree {
    constructor(comments){
    /// Initialize tree
    let tree = new Map();
    this.root = new Comment(
        null,
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
            c.userPictureUrl,
            c.postedOn,
            c.text,
            c.commentPictureUrl,
            (c.answerTo === null ? null : parseInt(c.answerTo))
        ));
    }
    /// Build tree
    for(let [id, c] of tree){
        // Replace parent ID by reference to parent
        if(c.parent !== null) c.parent = tree.get(c.parent);
        // Add children
        if(c.parent === null) this.root.addChild(c);
        else                  c.parent.addChild(c);
    }
    /// Sort children
    this.root.sortChildren();
    for(let [id, c] of tree)
        c.sortChildren();
    }
    addToElement(commentsSection){
        for(let i = 0; i < this.root.children.length; ++i){
            addCommentToDocument(commentsSection, this.root.children[i]);
        }
    }
}

function createEditElement(commentId, commentElement){
    let userElement = commentElement.querySelector('#comment-user');
    let userImgElement = commentElement.querySelector('#comment-profile-pic-a');
    let textElement = commentElement.querySelector('#comment-text');
    let commentImgElement = commentElement.querySelector('#comment-picture');

    let editElement = cloneNodeRecursive(document.querySelector("#templates>#edit-comment"));
    editElement.id = `edit-comment-${commentId}`;

    let el_commentId = editElement.querySelector('#commentId');
    el_commentId.value = commentId;

    let el_user = editElement.querySelector("#comment-user");
    el_user.children[0].href = userElement.children[0].href;
    el_user.children[0].innerHTML = userElement.children[0].innerHTML;

    let el_userPic = editElement.querySelector("#comment-profile-pic-a");
    el_userPic.href=userImgElement.href;
    el_userPic.children[0].src = userImgElement.children[0].src;

    let el_text = editElement.querySelector("#comment-text");
    el_text.value = textElement.innerHTML;

    let el_img = editElement.querySelector("#comment-picture");
    el_img.src = commentImgElement.attributes.src.value;

    return editElement;
}

function addCommentToDocument(parent, comment){
    let commentElement = comment.createElement();
    let detailsElement = commentElement.querySelector("details");

    if(typeof user !== 'undefined'){
        let actions_el = commentElement.querySelector(".actions");
        actions_el.style.display = "";

        let user_el = commentElement.querySelector("#comment-user");
        let user_name = user_el.children[0].innerHTML;
        if(user_name === user.username){
            let edit_el = actions_el.querySelector("#action-edit");
            edit_el.style.display = "";
        }

        let editElement = createEditElement(comment.id, commentElement);
        editElement.style.display = "none";
        commentElement.insertBefore(
            editElement,
            detailsElement
        );

        let answerElement = comment.createAnswerElement(user);
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

function clickedCommentReply(comment_el){
    let id_string = comment_el.id;
    let id = parseInt(id_string.split("-")[1]);

    let new_comment_el = document.getElementById(`new-comment-${id}`);
    new_comment_el.style.display = (new_comment_el.style.display === "none" ? "" : "none");
}

function clickedCommentEdit(comment_el){
    let id_string = comment_el.id;
    let id = parseInt(id_string.split("-")[1]);

    let article_el = comment_el.querySelector(".comment");
    article_el.style.display = "none";

    let edit_comment_el = document.getElementById(`edit-comment-${id}`);
    edit_comment_el.style.display = "";
}

$(document).ready(function(){
    let tree = new CommentTree(comments);
    let commentsSection = document.getElementById("comments");
    if(typeof user !== 'undefined'){
        commentsSection.appendChild(tree.root.createAnswerElement(user));
    }
    tree.addToElement(commentsSection);
});
