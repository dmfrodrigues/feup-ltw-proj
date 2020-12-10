function updateImgFromFile(img, file){
    var reader = new FileReader();
    reader.onloadend = function() {
        img.src = reader.result;
    }
    reader.readAsDataURL(file);
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}