class Comment {
    constructor(id, pet, user, userPictureUrl, postedOn, text, parent){
        this.id = id;
        this.pet = pet;
        this.user = user;
        this.userPictureUrl = userPictureUrl;
        this.postedOn = postedOn;
        this.text = text;
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
}
