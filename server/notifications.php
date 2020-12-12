<?php

require_once __DIR__.'/server.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/pets.php';


/**
 * Add new notification to database.
 *
 * @param string $user          User's username
 * @param string $subject       Notification's subject
 * @param string $text          Notification's subject
 * @return int ID of the new notification
 */
function addNotification(string $user, string $subject, string $text) : int {
    global $db;

    $stmt = $db->prepare('INSERT INTO Notification
    (subject, text, user)
    VALUES
    (:subject, :text, :user)');

    $stmt->bindValue(':subject', $subject);
    $stmt->bindValue(':text', $text);
    $stmt->bindValue(':user', $user);
    $stmt->execute();
    $notificationId = intval($db->lastInsertId());

    return $notificationId;
}

/**
 * Get all notifications of the user.
 *
 * @param string $username      User's username
 * @return array                Array containing all user's notifications
 */
function getNotifications(string $username) : array {
    global $db;

    $stmt = $db->prepare('SELECT
    id,
    read,
    subject,
    text,
    user
    FROM Notification INNER JOIN User ON Notification.user=User.username
    WHERE User.username=:username');

    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $userNotifications = $stmt->fetchAll();

    return array_reverse($userNotifications, TRUE);
}

/**
 * Set a notification as read.
 *
 * @param integer $notificationId    Notification's ID
 * @return void
 */
function readNotification(int $notificationId) {
    global $db;

    $stmt = $db->prepare('UPDATE Notification SET 
    read=1
    WHERE id=:notificationId');

    $stmt->bindValue(':notificationId', $notificationId);
    $stmt->execute();
}

/**
 * Deletes a notification.
 *
 * @param integer $notificationId    Notification's ID
 * @return void
 */
function deleteNotification(int $notificationId) {
    global $db;

    $stmt = $db->prepare('DELETE FROM Notification
    WHERE id=:notificationId');

    $stmt->bindValue(':notificationId', $notificationId);
    $stmt->execute();
}

/**
 * Deletes all user's notifications.
 *
 * @param string $username    User's username
 * @return void
 */
function deleteAllNotifications(string $username) {
    
    $notifications = getNotifications($username);

    foreach($notifications as $notification)
        deleteNotification($notification['id']);
}

/**
 * Checks if the user has unread notifications.
 *
 * @param string $username    User's username
 * @return bool               True if the user has unread notifications; false otherwise.
 */
function userHasUnreadNotifications(string $username) : bool {

    $notifications = getNotifications($username);

    foreach($notifications as $notification)
        if ($notification['read'] == 0) return true;
        
    return false;
}
