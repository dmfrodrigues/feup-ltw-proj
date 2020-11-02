function filterByName() {
    let input, filter, pet_name;
    input = document.getElementById("name");
    filter = input.value.toUpperCase();
    
    let pet_elements = document.querySelectorAll('article.pet');
    
    for (let i = 0; i < pet_elements.length; i++) {
        pet_name = pet_elements[i].querySelector('header h2 a').innerHTML;

        if (pet_name.toUpperCase().indexOf(filter) > -1) {
            pet_elements[i].style.display = "";
        } 
        else {
            pet_elements[i].style.display = "none";
        }
    }
}

