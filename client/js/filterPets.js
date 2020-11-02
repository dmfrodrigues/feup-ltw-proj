function filterByName() {
    let input, filter, pet_name;
    input = document.getElementById("name");
    filter = input.value.toUpperCase();
    
    let pet_elements = Array.from(document.querySelectorAll('article.pet'));
    let visible_elements = pet_elements;
    
    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('header h2 a').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1); 
    });

    console.log(visible_elements);
    return visible_elements;
}

function filterByLocation(visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById("location");
    filter = input.value.toUpperCase();
    
    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('p#hidden_location').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1); 
    });

    console.log(visible_elements);
    return visible_elements;
}

function filterBySpecies(visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById("species");
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('p#hidden_species').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1);
    });

    console.log(visible_elements);
    return visible_elements;
}

function filterByAge(visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById("age");
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('p#hidden_age').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1);
    });

    console.log(visible_elements);
    return visible_elements;
}

function filterByColor(visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById("color");
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('p#hidden_color').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1);
    });

    console.log(visible_elements);
    return visible_elements;
}

function filterBySize(visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById("size");
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('p#hidden_size').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1);
    });

    console.log(visible_elements);
    return visible_elements;
}

function filterBySex(visible_elements) {
    let input, filter, pet_name;
    input = document.getElementById("sex");
    filter = input.value.toUpperCase();

    visible_elements = visible_elements.filter((pet_element) => {
        pet_name = pet_element.querySelector('p#hidden_sex').innerHTML;
        return (pet_name.toUpperCase().indexOf(filter) > -1);
    });

    console.log(visible_elements);
    return visible_elements;
}


function filterByAllParameters() {
    
    let filterNames = filterByName();
    let filterLocations = filterByLocation(filterNames);
    let filterSpecies = filterBySpecies(filterLocations);
    let filterAge = filterByAge(filterSpecies);
    let filterColor = filterByColor(filterAge);
    let filterSize = filterBySize(filterColor);
    let filterSex = filterBySex(filterSize);
    
    let petList = document.querySelector('section#pet-list').children;
    
    for(let x = 0; x < petList.length; x++) 
        petList[x].style.display = "none";

    filterSex.forEach((article) => {
        console.log(article);
        document.querySelector('section#pet-list').appendChild(article);
        article.style.display = "";
    });
      
}