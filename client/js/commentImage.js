function onChangeCommentPictureInput(input){
    let element = input.parentNode;
    let file = input.files[0];
    let img = element.querySelector("#comment-picture");
    updateImgFromFile(img, file);
}

function newComment_checkTextOrImage(comment){
    let text = comment.querySelector('#comment-text');
    let file = comment.querySelector('#comment-picture-input');
    let good = (text.value != '' || file.value != '');
    if(!good) alert("New comment must have at least text or an image.");
    return good;
}

function editComment_checkTextOrImage(comment){
    let text = comment.querySelector('#comment-text');
    let file = comment.querySelector('#comment-picture-input');
    let deleteFile = comment.querySelector('#comment-deleteFile');
    let good = (text.value != '' || file.value != '' || deleteFile.value === '0');
    if(!good) alert("Edited comment must have at least text or an image.");
    return good;
}

function editComment_removePicture(comment){
    let deleteFile = comment.querySelector('#comment-deleteFile');
    deleteFile.value = "1";
    let img = comment.querySelector('#comment-picture');
    img.src = "";
}
