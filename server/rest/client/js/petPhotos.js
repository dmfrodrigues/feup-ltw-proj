function selectPhoto(){
    document.getElementsByClassName("selected")[0].classList.remove("selected");
    let selected = event.target;
    selected.classList.add("selected");
    document.getElementById("pet-selected-img").src = selected.src;
}
