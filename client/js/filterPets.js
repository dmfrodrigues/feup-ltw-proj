function filterByName() {
    let input, filter, pet_name;
    input = document.getElementById("name");
    filter = input.value.toUpperCase();

    let visible_elements = Array.from(document.querySelectorAll('article.pet'));
    
    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('header h2 a').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1); 
    });

    return visible_elements;
}

function filterByParameter(parameter_id, query_selector, visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById(parameter_id);
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector(query_selector).innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1);
    });

    return visible_elements;
}

function filterByAllParameters() {
    
    let filtered = filterByName();
    let parameters_ids = ["location", "species", "age", "color", "size", "sex"];
    let query_selectors = ["p#hidden_location", "p#hidden_species", "p#hidden_age", "p#hidden_color", "p#hidden_size", "p#hidden_sex"];
    for (let i = 0; i < parameters_ids.length; i++) {
        filtered = filterByParameter(parameters_ids[i],query_selectors[i],filtered);
    }
    
    let petList = document.querySelector('section#pet-list').children;
    
    for(let x = 0; x < petList.length; x++) 
        petList[x].style.display = "none";

    filtered.forEach((article) => {
        console.log(article);
        document.querySelector('section#pet-list').appendChild(article);
        article.style.display = "";
    });
}