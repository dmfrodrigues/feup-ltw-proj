async function handleFavorites(target, username, petId) {  
    let addToFavorites = checkAddToFavorites(target.innerHTML);
    let petOwner = document.querySelector('input[name=petOwner]').value;
    let petLink = document.querySelector('input[name=petName]').value;
    let userLink = document.querySelector('input[name=userLink]').value;

    if(addToFavorites) {
        api.put(
            `user/${username}/favorite`,
            {
                petId: petId
            }
        ).then((response) => {
            switchFavoriteButton(target, addToFavorites);
        });

        api.put(
            `notification`,
            {
                username: petOwner,
                subject : `newMessage`,
                text    : `The user ` + userLink + " added your pet " +  petLink + " to his favorite's list."
            }
        );

    } else {
        api.delete(
            `user/${username}/favorite/${petId}`, { }
        ).then((response) => {
            switchFavoriteButton(target, addToFavorites);
        });

        api.put(
            `notification`,
            {
                username: petOwner,
                subject : `newMessage`,
                text    : `The user ` + userLink + " removed your pet " +  petLink + " from his favorite's list."
            }
        );
    }   
}

function switchFavoriteButton(target, removeFromFavorites) {
    if(removeFromFavorites) 
        target.innerHTML = `<img src="${PROTOCOL_CLIENT_URL}/resources/img/anti-heart.svg" height="30px">Remove from favorites`;
    else
        target.innerHTML = `<img src="${PROTOCOL_CLIENT_URL}/resources/img/heart.svg" height="30px">Add to favorites`;
}

function checkAddToFavorites(linkContent) {
    return /^.*Add to favorites$/.test(linkContent);
}