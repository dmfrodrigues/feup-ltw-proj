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
            let child = this.root.children[i];
            child.addToDocument(commentsSection);
        }
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
