<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// adoptionMessages.php
$adoptionRequest_id_message_GET = function(array $args): void {
    $id = $args[1];
    $request = AdoptionRequest::fromDatabase($id);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::ADOPTION_REQUEST,
        Authorization\Method::READ,
        $auth,
        $request
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) { 
        $adoptionMessages = $request->getAdoptionRequestMessages();
        array_unshift($adoptionMessages, $request);
        print_result($adoptionMessages);
    }
    else
        require_once CLIENT_DIR.'/adoptionMessages.php';
    
};

$adoptionRequest_id_message_PUT = function(array $args): void {
    $id = $args[1];
    $request = AdoptionRequest::fromDatabase($id);
    $_PUT = getPUT();

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::ADOPTION_REQUEST_MESSAGE,
        Authorization\Method::WRITE,
        $auth,
        $request
    );

    $message = new AdoptionRequestMessage();
    $message->setText   ($_PUT['Msgtext']    );
    $message->setRequest($id                 );
    $message->setUser   ($auth->getUsername());
    $message->addToDatabase();
};
