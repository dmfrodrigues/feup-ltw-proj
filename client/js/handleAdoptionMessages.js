let proposals = document.querySelectorAll('div#proposal-msg');

proposals.forEach((proposal) => {
    let myMessage = proposal.querySelector('input[type=hidden]').value == "1";
    // console.log(myMessage);
    if(myMessage) {
        proposal.querySelector('div#proposal-header').style.right = "35em";
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

    let params = [];
    let data = { requestId: requestId, user: user, Msgtext: Msgtext};

    for (i in data)
        params.push(encodeURIComponent(i) + "=" + encodeURIComponent(data[i]));
    
    let response = await fetch('AJAXRequests/addAdoptionMessage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params.join('&')
    });
    let jsonResponse = await response.json();
    console.log(jsonResponse);
    // addCommentToChat(jsonResponse);
}

function addCommentToChat(lastInsertedComment) {
    let proposal = document.createElement("div");
    proposal.id = "proposal-msg";

    let myMsg = document.createElement("input");
    myMsg.type = "hidden";
    myMsg.value = 1;

    let proposalHeader = document.createElement("div");
    proposalHeader.id = "proposal-header";
    proposalHeader.style.right = "35em";

    let aLink = document.createElement("a");
    aLink.href = "profile.php?username=" + lastInsertedComment.user;

    let profilePic = document.createElement('img');
    profilePic.id = "proposal-pic";
    profilePic.src = "../server/resources/img/profiles/" + lastInsertedComment.user + ".jpg";

    let proposalInfo = document.createElement("div");
    proposalInfo.id = "proposal-info";
    proposalInfo.style.marginLeft = "15em";

    // 5 | NewPet hardcode - CHANGE!
    let authorInfo = document.createElement('p');
    authorInfo.innerHTML = `${lastInsertedComment.user} on 
        ${lastInsertedComment.messageDate} <a id="proposal-pet" href="pet.php?id=5">NewPet</a></p>`;
    
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

    let mainObject = document.querySelector("header ~ div");
    let messages = mainObject.querySelectorAll('div#proposal-msg');
    let lastMsg = messages[messages.length - 1];
    
    mainObject.insertBefore(proposal, lastMsg);
    window.location='#proposal-message-submit';

    document.querySelector('#proposal-message-submit').querySelector('textarea').value = " ";
}