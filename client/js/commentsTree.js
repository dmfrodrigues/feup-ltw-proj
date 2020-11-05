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

function addCommentToDocument(parent, comment){
    let detailsElement = cloneNodeRecursive(document.querySelector("#templates > #comment"));
    detailsElement.id = `comment-${comment.id}`;
    
    let el_user = detailsElement.getElementsByClassName("user")[0];
    el_user.children[0].href = `profile.php?username=${comment.user}`;
    el_user.children[0].innerHTML = comment.user;
    
    let el_pic = detailsElement.getElementsByClassName("profile-pic-a")[0];
    el_pic.href=`profile.php?username=${comment.user}`;
    el_pic.children[0].src = comment.pictureUrl;

    let el_date = detailsElement.getElementsByClassName("date")[0]; el_date.innerHTML = comment.postedOn;
    let el_text = detailsElement.getElementsByClassName("comment-text")[0]; el_text.innerHTML = comment.text;

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
