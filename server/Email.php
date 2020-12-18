<?php
require_once __DIR__.'/server.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require SERVER_DIR.'/../PHPMailer/src/Exception.php';
require SERVER_DIR.'/../PHPMailer/src/PHPMailer.php';
require SERVER_DIR.'/../PHPMailer/src/SMTP.php';

/*
$emailServer = new EmailServer_PHPMailer();
$emailServer->setHost    ('smtp.gmail.com');
$emailServer->setUsername('...');
$emailServer->setPassword('...');
$emailServer->setFrom    ('foreverhomeorg@gmail.com', 'Forever Home');

$message = new EmailMessage();
$message->addReceiver('dmfrodrigues2000@gmail.com', 'Diogo Rodrigues');
$message->setSubject ('Password reset');
$message->setBody    ("Hello world!\r\n\r\nThis is an email.\r\n\r\nBest regards,\r\nForever Home");

$emailServer->sendMessage($message);
*/

class EmailMessage {
	public function __construct(){}
	private array $receivers;
	private string $subject;
	private string $body;
	public function addReceiver(string $address, string $name){ $this->receivers[] = ['address' => $address, 'name' => $name]; }
	public function setSubject (string $subject ){ $this->subject     = $subject;  }
	public function setBody    (string $body    ){ $this->body        = $body;     }
	public function getReceivers() : array  { return $this->receivers; }
	public function getSubject  () : string { return $this->subject;   }
	public function getBody     () : string { return $this->body;      }
}

interface EmailServer {
	public function setHost    (string       $host    );
	public function setUsername(string       $username);
	public function setPassword(string       $password);
	public function sendMessage(EmailMessage $message );
}

class EmailServer_PHPMailer implements EmailServer {
	private PHPMailer $mailer;
	public function __construct(){
		$this->mailer = new PHPMailer(true);
		$this->mailer->SMTPDebug  = SMTP::DEBUG_SERVER;
		$this->mailer->isSMTP();
		$this->mailer->SMTPAuth   = true;
		$this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$this->mailer->Port       = 587;									// TCP port to connect to, use 587 by default or 465 for `PHPMailer::ENCRYPTION_SMTPS`
	}
	public function setHost    (string $host    ){ $this->mailer->Host     = $host    ; }
	public function setUsername(string $username){ $this->mailer->Username = $username; }
	public function setPassword(string $password){ $this->mailer->Password = $password; }
	public function setFrom    (string $address, string $name){
		$this->mailer->setFrom($address, $name);
		$this->mailer->addReplyTo($address, $name);
	}

	public function sendMessage(EmailMessage $message){
		$receivers = $message->getReceivers();
		foreach($receivers as $receiver){
			$this->mailer->addAddress($receiver['address'], $receiver['name']);
		}
		$this->mailer->isHTML(false);
		$this->mailer->Subject = $message->getSubject();
		$this->mailer->Body    = $message->getBody();
		$this->mailer->send();
	}
}
