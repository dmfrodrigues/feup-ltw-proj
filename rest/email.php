<?php
require_once __DIR__.'/../server.php';
require_once SERVER_DIR.'/Email.php';

$email_credentials_file_path = __DIR__.'/email.cred';
$email_credentials_file = fopen($email_credentials_file_path, 'r');
if(!$email_credentials_file) { echo "Failed: Email server"; http_response_code(500); die(); }
$email_address  = fgets($email_credentials_file);
$email_password = fgets($email_credentials_file);

$emailServer = new EmailServer_PHPMailer_Gmail(
    $email_address,
    $email_password,
    'Forever Home'
);
