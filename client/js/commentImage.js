function onChangeCommentPictureInput(input){
    let element = input.parentNode;
    let file = input.files[0];
    let img = element.querySelector("#comment-picture");
    updateImgFromFile(img, file);
}
