$(function(){
    $("input#comment-picture-input").change(function(e){
        let element = e.target.parentNode.parentNode;
        console.log(element);
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
