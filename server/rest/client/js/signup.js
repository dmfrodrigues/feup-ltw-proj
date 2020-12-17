function signup_check() {
    let pwd     = document.getElementById('pwd'    ).value;
    let rpt_pwd = document.getElementById('rpt_pwd').value;
    if(pwd != rpt_pwd) {
        document.querySelector('p').remove();
        let errorMsg = document.createElement('p');
        let errorString = 'Passwords don\'t match!';
        errorMsg.id = 'simple-fail-msg';
        errorMsg.innerHTML = errorString;
        if(document.querySelector('form').lastElementChild.previousElementSibling.innerHTML != errorString)
            document.querySelector('form').insertBefore(errorMsg, document.querySelector('form').lastElementChild);
        return false;
    } 
    return true;
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
        form.setAttribute('action', PROTOCOL_SERVER_URL+'/actions/signup.php');
        generateUserForm(form);
        changeButtonColour('signup-user-button', 'signup-shelter-button');
    }
    else {
        form.setAttribute('action', PROTOCOL_SERVER_URL+'/actions/signup_shelter.php');
        generateShelterForm(form);
        changeButtonColour('signup-shelter-button', 'signup-user-button');
    }
}

function generateUserForm(form) {
    let inputs = [
        {name: "Name", id_name: "name", placeholder: "Name", inputType: "text", required: true},
        {name: "Username", id_name: "username", placeholder: "Username", inputType: "text", required: true, pattern: '^[a-zA-Z0-9]+$'},
        {name: "Email", id_name: "email", placeholder: "Email", inputType: "email", required: true, pattern: '^.+@.+\..+$'},
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
        {name: "Email", id_name: "email", placeholder: "Email", inputType: "email", required: true, pattern: '^.+@.+\..+$'},
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