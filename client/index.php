<?php

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';

require_once CLIENT_DIR.'/templates/common/header.php';
?> <h3><a href="<?= PROTOCOL_API_URL ?>/pet">View Pets Listed For Adoption</a></h3> <?php
?> <h3><a href="<?= PROTOCOL_API_URL ?>/pet/adopted">View Adopted Pets</a></h3> <?php
require_once CLIENT_DIR.'/templates/common/footer.php';
