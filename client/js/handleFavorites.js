async function handleFavorites(target, username, petId) {
    
    let data = { username: username, petId: petId };
    let params = Object.keys(data).map((key) => encodeURIComponent(key) + "=" + encodeURIComponent(data[key])).join('&');
    
    let addToFavorites = checkAddToFavorites(target.innerHTML);

    let response = await ajaxAddOrRemoveFavorites(addToFavorites, params);
    console.log(response);
    if(!response.ok) {
        const message = `An error has occured: ${response.status}`;
        throw new Error(message);
    }

    let jsonResponse = await response.json();
    console.log(jsonResponse);

    if(jsonResponse.successful) 
        switchFavoriteButton(target, addToFavorites);
    else {
        const message = `An error has occured: ${jsonResponse}`;
        throw new Error(message);
    }
    
}

function switchFavoriteButton(target, removeFromFavorites) {
    if(removeFromFavorites) 
        target.innerHTML = '<img src="resources/img/anti-heart.svg" height="30px">Remove from favorites';
    else
        target.innerHTML = '<img src="resources/img/heart.svg" height="30px">Add to favorites';
}

function ajaxAddOrRemoveFavorites(addToFavorites, bodyParams) {
    let apiFile = addToFavorites ? 'add_favorite.php' : 'remove_favorite.php';
    return fetch('AJAXRequests/' + apiFile, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: bodyParams   
    });
}

function checkAddToFavorites(linkContent) {
    return /^.*Add to favorites$/.test(linkContent);
}