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

async function addNewAdoptionRequestMsg() {
    let inputDiv = document.querySelector('#proposal-message-submit');
    let requestId = document.querySelector('input[name=requestID]').value;
    let user = document.querySelector('input[name=username]').value;

    let Msgtext = inputDiv.querySelector('textarea').value.slice(1);
    console.log(requestId, user, Msgtext);

    let params = [];
    let data = { requestId: requestId, user: user, Msgtext: Msgtext};

    for (i in data)
        params.push(encodeURIComponent(i) + "=" + encodeURIComponent(data[i]));
    
    console.log(params);

    let response = await fetch('AJAXRequests/addAdoptionMessage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params.join('&')
    });
    let jsonResponse = await response.json();
    console.log(jsonResponse);

    // Next step: ASYNC Request!
}