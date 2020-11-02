
function filterByParameter(parameter_id, query_selector, visible_elements) {
    let input, filter, pet_parameter;
    input = document.getElementById(parameter_id);
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_parameter = pet_element.querySelector(query_selector).innerHTML;
        return (pet_parameter.toUpperCase().indexOf(filter) > -1);
    });

    return visible_elements;
}

function filterByAllParameters() {

    const parameters_ids = ["name", "location", "species", "age", "color", "size", "sex"];
    const query_selectors = ["header h2 a", "p#hidden_location", "p#hidden_species", "p#hidden_age", "p#hidden_color", "p#hidden_size", "p#hidden_sex"];

    let filtered = Array.from(document.querySelectorAll('article.pet'));

    for (let i = 0; i < parameters_ids.length; i++) {
        filtered = filterByParameter(parameters_ids[i],query_selectors[i],filtered);
    }
    
    let petList = document.querySelector('section#pet-list').children;
    
    for(let x = 0; x < petList.length; x++) 
        petList[x].style.display = "none";

    // sort elements by pet name
    filtered.sort((a, b) => {
        return a.firstElementChild.firstElementChild.innerText.toLowerCase().localeCompare(b.firstElementChild.firstElementChild.innerText.toLowerCase());
    });

    filtered.forEach((article) => {
        document.querySelector('section#pet-list').appendChild(article);
        article.style.display = "";
    });


}