$(function(){
    $("input#comment-picture-input").change(function(e){
        let element = e.target.parentNode;
        let file = e.originalEvent.srcElement.files[0];
        let img = element.querySelector("#comment-picture");
        changedCommentPicture(img, file);
    });
});

function changedCommentPicture(img, file){
    var reader = new FileReader();
    reader.onloadend = function() {
        img.src = reader.result;
    }
    reader.readAsDataURL(file);
}

function newComment_checkTextOrImage(comment){
    let text = comment.querySelector('#comment-text');
    let file = comment.querySelector('#comment-picture-input');
    let good = (text.value != '' || file.value != '');
    if(!good) alert("New comment must have at least text or an image.");
    return good;
}
