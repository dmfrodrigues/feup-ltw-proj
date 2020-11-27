let proposals = document.querySelectorAll('div#proposal');

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
    alert('asd');
}