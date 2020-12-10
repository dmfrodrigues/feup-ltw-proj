let proposals = document.querySelectorAll('div#proposal-msg');
let allMsgs = document.querySelectorAll('#proposal-msg');
let submitMsg = allMsgs[allMsgs.length - 1];

proposals.forEach((proposal) => {
    let myMessage = proposal.querySelector('input[type=hidden]').value == "1";

    if(myMessage) {
        proposal.querySelector('div#proposal-header').style.right = '28.5em';
        proposal.querySelector('div#proposal-info').style.marginLeft = "15em";
    }
})

window.onload = function(event) {
    window.location='#proposal-message-submit';
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
        const message = `An error has occured: ${response.status}`;
        throw new Error(message);
    }
    let jsonResponse = await response.json();

    let mainObject = document.querySelector("header ~ main");
    mainObject.innerHTML = '';

    jsonResponse.comments.forEach((comment) => {
        addCommentToChat(comment, user, jsonResponse.petId.pet, jsonResponse.petName.name);
    });
    
    submitMsg.querySelector('textarea').value = "";
    mainObject.appendChild(submitMsg);
    window.location='#proposal-message-submit';
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
        ${lastInsertedComment.messageDate} <a id="proposal-pet" href="pet.php?id=${petId}">${petName}</a></p>`;
    
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

    let mainObject = document.querySelector("header ~ main");
    
    mainObject.appendChild(proposal);

}
