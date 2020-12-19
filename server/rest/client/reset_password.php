<?php

require_once __DIR__ . '/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once CLIENT_DIR . '/templates/common/header.php';
require_once CLIENT_DIR . '/templates/authentication/reset.php';
require_once CLIENT_DIR . '/templates/common/footer.php';
