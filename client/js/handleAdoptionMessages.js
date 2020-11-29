let proposals = document.querySelectorAll('div#proposal-msg');

proposals.forEach((proposal) => {
    let myMessage = proposal.querySelector('input[type=hidden]').value == "1";
    console.log(myMessage);
    if(myMessage) {
        proposal.querySelector('div#proposal-header').style.right = "35em";
        proposal.querySelector('div#proposal-info').style.marginLeft = "15em";
    }
})

window.onload = function(event) {
    window.location='#proposal-message-submit';
}

function addNewAdoptionRequestMsg() {
    let inputDiv = document.querySelector('#proposal-message-submit');
    let requestId = document.querySelector('input[name=requestID]').value;
    let user = document.querySelector('input[name=username]').value;

    let Msgtext = inputDiv.querySelector('textarea').value.slice(1);
    console.log(requestId, user, Msgtext);


    // Next step: ASYNC Request!
}