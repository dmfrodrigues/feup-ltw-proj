function filterByAllParameters() {

    const parameters_ids = ["name", "location", "species", "age", "color", "size", "sex"];
    const query_selectors = ["header h2 a", "p#hidden_location", "p#hidden_species", "p#hidden_age", "p#hidden_color", "p#hidden_size", "p#hidden_sex"];

    let pet_elements = document.querySelectorAll('article.pet');
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