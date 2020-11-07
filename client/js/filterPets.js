function filterByTextParameters() {

    const parameters_ids = ["name", "location", "species", "age", "color"];
    const query_selectors = ["div div div h2", "p#hidden_location", "p#hidden_species", "p#hidden_age", "p#hidden_color"];

    let pet_elements = document.querySelectorAll('article.pet-card');
    for(let i = 0; i < pet_elements.length; ++i){
        let pet_element = pet_elements[i];
        let isVisible = true;

        for(let j = 0; j < parameters_ids.length; ++j){
            let parameter_id = parameters_ids[j];
            let query_selector = query_selectors[j];

            let pet_parameter = pet_element.querySelector(query_selector).innerHTML;
            isVisible &= (pet_parameter.toUpperCase().indexOf(document.getElementById(parameter_id).value.toUpperCase()) > -1);
            if(!isVisible) break;
        }

        pet_element.style.display = (isVisible ? "" : "none");
    }

}

function filterByCheckBoxes() {
    let sizes = [], genders = [];
    let checkbox = document.getElementById('size').nextElementSibling;
    while(checkbox.type == "checkbox") {
        if(checkbox.checked) 
            sizes.push(checkbox.value);
        
        checkbox = checkbox.nextElementSibling.nextElementSibling;
    }

    checkbox = document.getElementById('sex').nextElementSibling;
    while(checkbox != null) {
        if(checkbox.checked) 
            genders.push(checkbox.value);
        
        checkbox = checkbox.nextElementSibling.nextElementSibling;
    }

    let pet_elements = document.querySelectorAll('article.pet-card');
    let query_selectors = ["p#hidden_size", "p#hidden_sex"];

    for(let i = 0; i < pet_elements.length; ++i){
        let pet_element = pet_elements[i];
        let isVisible = true;

        if(pet_element.style.display != "none") {
            if(sizes.length > 0) {
                let pet_parameter = pet_element.querySelector(query_selectors[0]).innerHTML;
                isVisible &= sizes.includes(pet_parameter.toUpperCase());  
            }
            if(genders.length > 0 && isVisible) {
                let pet_parameter = pet_element.querySelector(query_selectors[1]).innerHTML;
                isVisible &= genders.includes(pet_parameter.toUpperCase());
            }

            pet_element.style.display = (isVisible ? "" : "none");
        }
    }


}

function filterByAllParameters() {
    filterByTextParameters();
    filterByCheckBoxes();
}