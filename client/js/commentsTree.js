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

function addCommentToDocument(parent, comment){
    let span_user = document.createElement("span");
    span_user.classList = ["user"];
    span_user.innerHTML = `<a href="profile.php?username=${comment.user}">${comment.user}</a>`;

    let img_user = document.createElement("img");
    img_user.classList = ["profile-pic"];
    img_user.src = comment.pictureUrl;
    let img_link_user = document.createElement("a");
    img_link_user.href = `profile.php?username=${comment.user}`;
    img_link_user.classList = ["profile-pic"];
    img_link_user.appendChild(img_user);

    let span_date = document.createElement("span");
    span_date.classList = ["date"];
    span_date.innerHTML = comment.postedOn;

    let p_comment = document.createElement("p");
    p_comment.classList = ["comment-text"]
    p_comment.innerHTML = comment.text;

    let action_answer = document.createElement("img");
    action_answer.classList = ["icon"];
    action_answer.src = "resources/img/reply.svg";
    let actions = document.createElement("div");
    actions.classList = ["actions"];
    actions.appendChild(action_answer);

    let commentElement = document.createElement("article");
    commentElement.id = `comment-${comment.id}`;
    commentElement.classList = ["comment"];
    commentElement.appendChild(span_user);
    commentElement.appendChild(img_link_user);
    commentElement.appendChild(span_date);
    commentElement.appendChild(p_comment);
    commentElement.appendChild(actions);

    let summaryElement = document.createElement("summary");
    summaryElement.appendChild(commentElement);

    let detailsElement = document.createElement("details");
    detailsElement.classList = ["comment-details"];
    detailsElement.appendChild(summaryElement)

    parent.appendChild(detailsElement);

    for(let i = 0; i < comment.children.length; ++i){
        addCommentToDocument(detailsElement, comment.children[i]);
    }
}

$(document).ready(function(){
    let root = createTree(comments);
    let commentsSection = document.getElementById("comments");
    for(let i = 0; i < root.children.length; ++i){
        addCommentToDocument(commentsSection, root.children[i]);
    }    
});
