let nameInput = document.querySelector('form').firstElementChild;

function shelterSignUp(target) {
    target.style.display = "none";
    target.parentNode.style.fontWeight = 'bolder';
    let form = target.parentNode.parentNode;

    if(target.checked) {
        form.removeChild(nameInput);
        let inputs = [{name: "Name", required: true}, {name: "Location", required: true}, {name: "Description", required: false}];
        addShelterInputs(target.parentNode, inputs);
        form.setAttribute('action', '../../server/actions/signup_shelter.php');
    } else {        
        Array.from(target.parentNode.children).forEach((child) => {
            if(child.type != 'checkbox')
                target.parentNode.removeChild(child);
        });
        target.parentNode.style.fontWeight = 'normal';
        target.style.display = "inline-block";
        form.insertBefore(nameInput, form.firstElementChild);
        form.setAttribute('action', '../../server/actions/signup.php');
    }
}

function addInputs(target, inputs) {
    inputs.forEach((specificInput) => {
        let label = document.createElement('label');
        label.innerHTML = specificInput.name + ': ';
        
        let input = document.createElement('input');
        input.type = specificInput.inputType;
        input.name = specificInput.id_name;
        input.id = specificInput.id_name;
        input.placeholder = specificInput.placeholder;
        input.required = specificInput.required;
        if(specificInput.pattern)
            input.pattern = specificInput.pattern;
        label.appendChild(input);
        target.insertBefore(label, target.lastElementChild);
    });  
}

function switchSignUpForms(formType) {
    let form = document.querySelector('form');
    removeFormChilds(form);

    if(formType == 'user') {
        form.setAttribute('action', '../../server/actions/signup.php');
        generateUserForm(form);
        changeButtonColour('signup-user-button', 'signup-shelter-button');
    }
    else {
        form.setAttribute('action', '../../server/actions/signup_shelter.php');
        generateShelterForm(form);
        changeButtonColour('signup-shelter-button', 'signup-user-button');
    }
}

function generateUserForm(form) {
    let inputs = [
        {name: "Name", id_name: "name", placeholder: "Name", inputType: "text", required: true},
        {name: "Username", id_name: "username", placeholder: "Username", inputType: "text", required: true, pattern: '^[a-zA-Z0-9]+$'},
        {name: "Password", id_name: "pwd", placeholder: "Password", inputType: "password", required: false},
        {name: "Repeat Password", id_name: "rpt_pwd", placeholder: "Password", inputType: "password", required: true}
    ];
    addInputs(form, inputs);
}

function generateShelterForm(form) {
    let inputs = [
        {name: "Shelter Name", id_name: "shelterName", placeholder: "Shelter Name", inputType: "text", required: true},
        {name: "Description", id_name: "description", placeholder: "Small Description", inputType: "text", required: true},
        {name: "Location", id_name: "location", placeholder: "Location", inputType: "text", required: true},
        {name: "Username", id_name: "username", placeholder: "Username", inputType: "text", required: true, pattern: '^[a-zA-Z0-9]+$'},
        {name: "Password", id_name: "pwd", placeholder: "Password", inputType: "password", required: false},
        {name: "Repeat Password", id_name: "rpt_pwd", placeholder: "Password", inputType: "password", required: true}
    ];
    addInputs(form, inputs);
}

function changeButtonColour(idAddColor, idRemoveColor) {
    document.querySelector('#' + idAddColor).style.backgroundColor = ' #fc9d04';
    document.querySelector('#' + idRemoveColor).style.backgroundColor = ' #fccd81';
}

function removeFormChilds(form) {
    Array.from(form.children).forEach((child) => {
        if(child.type != 'submit')
            form.removeChild(child);
    });
}