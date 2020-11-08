class Comment {
    constructor(id, pet, user, userPictureUrl, postedOn, text, commentPictureUrl, parent){
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
    addChild(childId){
        this.children.push(childId);
    }
    sortChildren(){
        this.children.sort(Comment.compare);
    }
    static compare(lhs, rhs){
        if     (lhs.pet      !== rhs.pet     ) return (lhs.pet      < rhs.pet      ? -1 : 1);
        else if(lhs.postedOn !== rhs.postedOn) return (lhs.postedOn > rhs.postedOn ? -1 : 1);
        else if(lhs.user     !== rhs.user    ) return (lhs.user     < rhs.user     ? -1 : 1);
        else if(lhs.id       !== rhs.id      ) return (lhs.id       < rhs.id       ? -1 : 1);
        else if(lhs.parent   !== rhs.parent  ) return (lhs.parent   < rhs.parent   ? -1 : 1);
        else if(lhs.text     !== rhs.text    ) return (lhs.text     < rhs.text     ? -1 : 1);
        else                                   return 0;
    }
    createElement(){
        let commentElement = cloneNodeRecursive(document.querySelector("#templates>#comment"));
        commentElement.id = `comment-${this.id}`;
        
        let el_user = commentElement.querySelector("#comment-user");
        el_user.children[0].href = `profile.php?username=${this.user}`;
        el_user.children[0].innerHTML = this.user;
        
        let el_pic = commentElement.querySelector("#comment-profile-pic-a");
        el_pic.href=`profile.php?username=${this.user}`;
        el_pic.children[0].src = this.userPictureUrl;
    
        let el_date = commentElement.querySelector("#comment-date"); el_date.innerHTML = this.postedOn;
        let el_text = commentElement.querySelector("#comment-text"); el_text.innerHTML = this.text;
        if(el_text.innerHTML === '') el_text.style.display = "none";
        let el_img  = commentElement.querySelector("#comment-picture"); el_img.src = this.commentPictureUrl;
    
        return commentElement;
    }
}
