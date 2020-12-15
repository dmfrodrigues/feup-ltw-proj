<section id="notifications">
    <header>
        <h1>Notifications</h1>
    </header>
    <article id="notifications-body">
        <div id="delete-all-notifications">
            <button onclick="deleteUserNotifications('<?= $_SESSION['username'] ?>')">Delete All Notifications</button>
        </div>
        <ul>
            <?php foreach($notifications as $notification) { 
                if ($notification['read'] == 0) { ?>
                    <li><div id="unread-notification">
                        <p>
                        <?=$notification['text']?>
                        </p>
                    </div></li>
                <?php } else { ?>
                    <li><div id="read-notification">
                        <p>
                        <?=$notification['text']?>
                        </p>
                    </div></li>
                <?php } ?>
            <?php } ?>
            <?php foreach($notifications as $notification) { 
                if ($notification['read'] == 0) {
                    readNotification($notification['id']);
                }
            } ?>
        </ul>
    </article>
</section>