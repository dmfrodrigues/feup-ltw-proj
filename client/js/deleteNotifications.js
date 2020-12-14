async function deleteUserNotifications(username) {  
    
    api.put(
        `notification`,
        {
            username: username,
            subject : `newMessage`,
            text    : "This is a test!"
        }
    );
}