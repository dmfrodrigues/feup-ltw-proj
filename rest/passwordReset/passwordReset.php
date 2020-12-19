<?php
require_once __DIR__ . '/../../server.php';
require_once __DIR__ . '/../../authentication.php';
require_once __DIR__ . '/../../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once __DIR__ . '/../email.php';
require_once SERVER_DIR . '/classes/PasswordResetToken.php';
require_once SERVER_DIR . '/classes/Email.php';

use function Authentication\yesHTML;

$passwordReset_GET = function(array $args): void {
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/reset_password.php';
};

$passwordReset_PUT = function(array $args): void {
    $_PUT = getPUT();
    $username = $_PUT['username'];
    
    $user = User::fromDatabase($username);
    if($user == null) exit();
    
    $reset = new PasswordResetToken();
    $reset->setUser($username);
    $reset->generateToken();
    $reset->addToDatabase();

    $email = yesHTML($user->getEmail());
    $subject = "Forever Home Password Reset";
    $content =
        "Hello {$user->getName()},\r\n".
        "\r\n".
        "You requested to reset the password for your Forever Home account {$user->getUsername()} ".
        "with the email address {$email}.\r\n".
        "\r\n".
        "Please click the following link to reset your password:\r\n".
        PROTOCOL_SERVER_URL."/user/{$user->getUsername()}/password/change/?token={$reset->getToken()}\r\n".
        "This link is only available for 24h.\r\n".
        "\r\n".
        "Best regards,\r\n".
        "The Forever Home Team\r\n".
        "foreverhomeorg@gmail.com\r\n".
        "\r\n".
        "If you did not request a password reset, please feel free to ignore this message.\r\n"
    ;
    $message = new EmailMessage();
    $message->addReceiver($email, $user->getName());
    $message->setSubject($subject);
    $message->setBody($content);

    global $emailServer;
    $emailServer->sendMessage($message);
};
