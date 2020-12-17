class Comment {
    constructor(id, pet, user, userPictureUrl, postedOn, text, commentPictureUrl, parent) {
        this.id = id;
        this.pet = pet;
        this.user = user;
        this.userPictureUrl = userPictureUrl;
        this.postedOn = postedOn;
        this.text = text;
        this.commentPictureUrl = commentPictureUrl;
        this.parent = parent;
        this.children = [];
    }
    addChild(childId) {
        this.children.push(childId);
    }
    sortChildren() {
        this.children.sort(Comment.compare);
    }
    static compare(lhs, rhs) {
        if (lhs.pet !== rhs.pet) return (lhs.pet < rhs.pet ? -1 : 1);
        else if (lhs.postedOn !== rhs.postedOn) return (lhs.postedOn > rhs.postedOn ? -1 : 1);
        else if (lhs.user !== rhs.user) return (lhs.user < rhs.user ? -1 : 1);
        else if (lhs.id !== rhs.id) return (lhs.id < rhs.id ? -1 : 1);
        else if (lhs.parent !== rhs.parent) return (lhs.parent < rhs.parent ? -1 : 1);
        else if (lhs.text !== rhs.text) return (lhs.text < rhs.text ? -1 : 1);
        else return 0;
    }

    addToDocument(parent) {
        let commentElement = Template.comment(this);
        let detailsElement = commentElement.querySelector("details");

        if (typeof user !== 'undefined') {
            let actions_el = commentElement.querySelector(".actions");
            actions_el.style.display = "";

            let user_el = commentElement.querySelector("#comment-user");
            let user_name = user_el.children[0].innerHTML;
            if (user_name === user.username) {
                let edit_el = actions_el.querySelector("#action-edit");
                edit_el.style.display = "";
                let delete_el = actions_el.querySelector(`#action-delete-${this.id}`);
                delete_el.style.display = "";
            }

            let editElement = Template.editComment(this);
            editElement.style.display = "none";
            commentElement.insertBefore(
                editElement,
                detailsElement
            );

            let answerElement = Template.newComment(this, user);
            answerElement.style.display = "none";
            commentElement.insertBefore(
                answerElement,
                detailsElement
            );
        }

        parent.appendChild(commentElement);

        if (this.children.length > 0) {
            for (let i = 0; i < this.children.length; ++i) {
                this.children[i].addToDocument(detailsElement);
            }
        } else {
            detailsElement.style.display = "none";
        }
    }
}
