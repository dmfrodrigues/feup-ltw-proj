function browsePetPhoto(element){
    let id = parseInt(element.parentNode.id.split('-')[1]);
    element.parentNode.parentNode.parentNode.querySelector(`#new-${id}`).click()
}

$(function(){
    $("input[id^='new-'").change(updatePetPhoto);
});

function addPetPhoto(element){
    let N = parseInt(element.querySelector('#photo-number').value);

    let inputs = element.querySelector('#pet-photos-inputs');
    let old_el = document.createElement("input");
    old_el.id = `old-${N}`; old_el.name = old_el.id; old_el.value = ''; old_el.type = "hidden";
    let new_el = document.createElement("input");
    new_el.id = `new-${N}`; new_el.name = new_el.id; new_el.value = ''; new_el.type = "file"; new_el.style.display = "none";
    inputs.appendChild(old_el);
    inputs.appendChild(new_el);

    let picture = document.createElement('div');
    picture.id = `picture-${N}`;
    picture.innerHTML = `
        <img id="img-${N}" src=""/>
        <a onclick="this.parentNode.parentNode.parentNode.querySelector('#new-${N}').click()">Browse new picture</a>
        <a onclick="
            let inputs = this.parentNode.parentNode.parentNode.querySelector('#pet-photos-inputs');
            inputs.removeChild(inputs.querySelector('#old-${N}'));
            inputs.removeChild(inputs.querySelector('#new-${N}'));
            this.parentNode.parentNode.removeChild(this.parentNode);
        ">Delete</a>
    `;
    let pictures = element.querySelector('#pet-photos-row');
    pictures.appendChild(picture);

    $("input[id^='new-'").change(updatePetPhoto);

    element.querySelector('#photo-number').value = `${N+1}`;
}

function deletePetPhoto(element){
    let id = parseInt(element.parentNode.id.split('-')[1]);
    let inputs = element.parentNode.parentNode.parentNode.querySelector('#pet-photos-inputs');
    let pictures = element.parentNode.parentNode.parentNode.querySelector('#pet-photos-row');
    let photo_number = element.parentNode.parentNode.parentNode.querySelector('#photo-number');
    let N = parseInt(photo_number.value);
    inputs.removeChild(inputs.querySelector(`#old-${id}`));
    inputs.removeChild(inputs.querySelector(`#new-${id}`));
    element.parentNode.parentNode.removeChild(element.parentNode);
    for(let i = id+1; i < N; ++i){
        let old_el = inputs.querySelector(`#old-${i}`); old_el.id = `old-${i-1}`; old_el.name = old_el.id;
        let new_el = inputs.querySelector(`#new-${i}`); new_el.id = `new-${i-1}`; new_el.name = new_el.id;
        let img = pictures.querySelector(`#img-${i}`); img.id = `img-${i-1}`;
        let picture = pictures.querySelector(`#picture-${i}`); picture.id = `picture-${i-1}`;
    }
    photo_number.value = `${N-1}`;
}

function updatePetPhoto(e){
    let id = parseInt(e.target.id.split('-')[1]);
    let element = e.target.parentNode.parentNode.parentNode;
    let file = e.originalEvent.srcElement.files[0];
    let img = element.querySelector(`#img-${id}`);
    updateImgFromFile(img, file);
}
