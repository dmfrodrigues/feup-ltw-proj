class CommentTree {
    constructor(comments) {
        /// Initialize tree
        this.map = new Map();
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
        for (let i = 0; i < comments.length; ++i) {
            let c = comments[i];
            let id = parseInt(c.id);
            this.map.set(id, new Comment(
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
        for (let [id, c] of this.map) {
            // Replace parent ID by reference to parent
            if (c.parent !== null) c.parent = this.map.get(c.parent);
            // Add children
            if (c.parent === null) this.root.addChild(c);
            else c.parent.addChild(c);
        }
        /// Sort children
        this.root.sortChildren();
        for (let [id, c] of this.map)
            c.sortChildren();
    }
    addToElement(commentsSection) {
        for (let i = 0; i < this.root.children.length; ++i) {
            let child = this.root.children[i];
            child.addToDocument(commentsSection);
        }
    }
}

document.addEventListener("DOMContentLoaded", function(_event) {
    updateCommentsSection();
    // window.setInterval(updateCommentsSection, 10000);
});

api = new RestApi(API_URL);

/**
 * Update comments section
 */
function updateCommentsSection(){
    api.get(`pet/${pet.id}/comments`)
    .then(function(_comments){
        var tree = new CommentTree(_comments);
    
        let commentsSection = document.querySelector("#comments div");
        commentsSection.innerHTML = '';
        if (typeof user !== 'undefined'){
            commentsSection.appendChild(Template.newComment(tree.root, user));
        }
        tree.addToElement(commentsSection);
    }).catch(function(error){
        console.error(error);
    });
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function onClickedUpdateComments(el){
    el.classList.add("rotating");
    await sleep(1400);
    updateCommentsSection();
    el.classList.remove("rotating");
}
