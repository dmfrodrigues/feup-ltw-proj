let proposals = document.querySelectorAll('div#proposal-msg');
let allMsgs = document.querySelectorAll('#proposal-msg');
let submitMsg = allMsgs[allMsgs.length - 1];


window.onload = function(event) {
    window.location='#proposal-messages-refresh';
}

async function addNewAdoptionRequestMsg() {
    let inputDiv = document.querySelector('#proposal-message-submit');
    let requestId = document.querySelector('input[name=requestID]').value;
    let user = document.querySelector('input[name=username]').value;

    let Msgtext = inputDiv.querySelector('textarea').value;

    let data = { requestId: requestId, user: user, Msgtext: Msgtext};

    let params = Object.keys(data).map((key) => { return encodeURIComponent(key) + '=' + encodeURIComponent(data[key]) }).join('&');
    let response  = await ajaxAddAdoptionRequest(params);

    if(!response.ok) {
        const message = `An error has occurred: ${response.status}`;
        throw new Error(message);
    }

    updateAdoptionChat();
}

async function ajaxAddAdoptionRequest(bodyParams) {
    return fetch('AJAXRequests/addAdoptionMessage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: bodyParams
    });
}

function addCommentToChat(lastInsertedComment, user, petId, petName) {
    let proposal = document.createElement("div");
    proposal.id = "proposal-msg";

    let myMsg = document.createElement("input");
    myMsg.type = "hidden";
    myMsg.value = 1;

    let proposalHeader = document.createElement("div");
    proposalHeader.id = "proposal-header";

    let aLink = document.createElement("a");
    aLink.href = "profile.php?username=" + lastInsertedComment.user;

    let profilePic = document.createElement('img');
    profilePic.id = "proposal-pic";
    profilePic.src = "../server/resources/img/profiles/" + lastInsertedComment.user + ".jpg";

    let proposalInfo = document.createElement("div");
    proposalInfo.id = "proposal-info";
    
    if(lastInsertedComment.user == user) {
        proposalHeader.style.right = "28.5em";
        proposalInfo.style.marginLeft = "15em";
    }

    let authorInfo = document.createElement('p');
    authorInfo.innerHTML = `${lastInsertedComment.user} on 
        ${lastInsertedComment.messDate} for <a id="proposal-pet" href="pet.php?id=${petId}">${petName}</a></p>`;
    
    let proposalMsg = document.createElement('div');
    proposalMsg.id = 'proposal-message';

    let textMsg = document.createElement('textarea');
    textMsg.readOnly = true;
    textMsg.innerHTML = "&nbsp;" + lastInsertedComment.text;

    proposalMsg.appendChild(textMsg);
    proposalInfo.appendChild(authorInfo);
    proposalInfo.appendChild(proposalMsg);
    
    aLink.appendChild(profilePic);
    proposalHeader.appendChild(aLink);

    proposal.appendChild(myMsg);
    proposal.appendChild(proposalHeader);
    proposal.appendChild(proposalInfo);

    let mainObject = document.querySelector("section");
    
    mainObject.appendChild(proposal);

}

async function updateAdoptionChat() {
    let requestId = document.querySelector('input[name=requestID]').value;
    let response = await api.get(`adoptionMessage/${requestId}`);
    let jsonResponse = await response.json();

    let user = document.querySelector('input[name=username]').value;

    let mainObject = document.querySelector("section");
    let title =document.createElement('h1');
    mainObject.innerHTML = '';
    title.innerHTML = 'Proposal Chat';
    title.id = 'proposal-title';
    mainObject.appendChild(title);

    jsonResponse.forEach((comment) => {
        addCommentToChat(comment, user, jsonResponse[0].pet, jsonResponse[0].petName);
    });
    
    submitMsg.querySelector('textarea').value = "";
    mainObject.appendChild(submitMsg);
    window.location='#proposal-messages-refresh';
}

async function onClickedUpdateChat(el){
    el.classList.add("rotating");
    await sleep(1400);
    updateAdoptionChat();
    el.classList.remove("rotating");
}