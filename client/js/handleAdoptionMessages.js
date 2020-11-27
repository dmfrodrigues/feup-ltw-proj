let proposals = document.querySelectorAll('div#proposal');

proposals.forEach((proposal) => {
    let myMessage = proposal.querySelector('input[type=hidden]').value == "1";
    console.log(myMessage);
    if(myMessage) {
        proposal.querySelector('div#proposal-header').style.right = "33.5em";
        proposal.querySelector('div#proposal-info').style.marginLeft = "15em";
    }
})