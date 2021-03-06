<?php 

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/errors/errors.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$title = "Sign Up";
$javascript_files = ['rest/client/js/signup.js'];
require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/authentication/signup.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
