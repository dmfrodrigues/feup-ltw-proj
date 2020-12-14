async function handleFavorites(target, username, petId) {  
    let addToFavorites = checkAddToFavorites(target.innerHTML);

    if(addToFavorites) {
        api.put(
            `user/${username}/favorite`,
            {
                petId: petId
            }
        ).then((response) => {
            switchFavoriteButton(target, addToFavorites);
        });
    } else {
        api.delete(
            `user/${username}/favorite/${petId}`, { }
        ).then((response) => {
            switchFavoriteButton(target, addToFavorites);
        });
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