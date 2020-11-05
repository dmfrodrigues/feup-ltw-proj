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
    let commentElement = document.createElement("article");
    commentElement.id = `comment-${comment.id}`;
    commentElement.classList = ["comment"];
    commentElement.innerHTML=`
        <span class="user">
            <a href="profile.php?username=${comment.user}">
                ${comment.user}
            </a>
        </span>
        <a class="profile-pic-a" href="profile.php?username=${comment.user}">
            <img class="profile-pic" src="${comment.pictureUrl}">
        </a>
        <span class="date">${comment.postedOn}</span>
        <p class="comment-text">${comment.text}</p>
        <div class="actions">
            <img class="icon" src="resources/img/reply.svg">
        </div>
    `;

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
