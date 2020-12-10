<section id="notifications">
    <header>
        <h1>Notifications</h1>
    </header>
    <article id="notifications-body">
        <ul>
            <?php foreach($notifications as $notification) { 
                if ($notification['read'] == 0) { ?>
                    <li><div id="unread-notification">
                        <?=$notification['text']?>
                    </div></li>
                <?php } else { ?>
                    <li><div id="read-notification">
                        <?=$notification['text']?>
                    </div></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </article>
</section>