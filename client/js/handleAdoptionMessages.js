let allMsgs = document.querySelectorAll('#proposal-msg');
let submitMsg = allMsgs[allMsgs.length - 1];
let petOwner;
let userWhoProposed;
let isOwnerSendingMessage;

window.onload = function(event) {
    petOwner = document.querySelector('input[name=petOwner]').value;
    userWhoProposed = document.querySelector('input[name=userWhoProposed]').value;
    isOwnerSendingMessage = document.querySelector('input[name=isOwnerSending]').value;
    window.location='#proposal-messages-refresh';
}

async function addNewAdoptionRequestMsg() {
    let inputDiv = document.querySelector('#proposal-message-submit');
    let requestId = document.querySelector('input[name=requestID]').value;

    let Msg = inputDiv.querySelector('textarea').value;

    // --------------------- Notification ---------------------

    let notificationUser, userWhoSend;

    if (isOwnerSendingMessage == 1) {
        notificationUser = userWhoProposed;
        userWhoSend = petOwner;
    }
    else {
        notificationUser = petOwner;
        userWhoSend = userWhoProposed;
    }

    api.put(
        `notification`,
        {
            username: notificationUser,
            subject : `newMessage`,
            text    : `You received a new message from ` + userWhoSend + ", regarding " +  document.querySelector('#proposal-info a').innerHTML
        }
    );

    // --------------------- Adoption Request Message ---------------------

    api.put(
        `adoptionRequest/${requestId}/message`,
        {
            Msgtext: Msg
        }
    ).then((response) => {
        updateAdoptionChat();
    })
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
    aLink.href = API_URL+"/user/" + lastInsertedComment.user;

    let profilePic = document.createElement('img');
    profilePic.id = "proposal-pic";
    profilePic.src = PROTOCOL_SERVER_URL+"/resources/img/profiles/" + lastInsertedComment.user + ".jpg";

    let proposalInfo = document.createElement("div");
    proposalInfo.id = "proposal-info";
    
    /*
    if(lastInsertedComment.user == user) {
        proposalHeader.style.right = "28.5em";
        proposalInfo.style.marginLeft = "15em";
    }*/

    let authorInfo = document.createElement('p');
    authorInfo.innerHTML = `${lastInsertedComment.user} on 
        ${lastInsertedComment.messDate} for <a id="proposal-pet" href="${API_URL}/pet/${petId}">${petName}</a></p>`;
    
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
    let photo = document.getElementById('proposal-pet-photo');
    
    mainObject.innerHTML = '';
    title.innerHTML = 'Proposal Chat';
    title.id = 'proposal-title';
    mainObject.appendChild(title);
    mainObject.appendChild(photo);

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