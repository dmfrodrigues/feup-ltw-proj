<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/errors/errors.php';

$users = User::allWithoutShelter();
$title = "Potential collaborators";

require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['username']))
    require_once CLIENT_DIR.'/templates/users/view_potential_collaborators.php';

require_once CLIENT_DIR.'/templates/common/footer.php';