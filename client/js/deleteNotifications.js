async function deleteUserNotifications(username) {  
    
    api.delete(
        `user/${username}/notifications`, { }
    ).then(document.querySelector("#notifications-body ul").style.display = "none");
}