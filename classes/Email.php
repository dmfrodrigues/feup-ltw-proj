<?php
require_once __DIR__.'/../server.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require SERVER_DIR.'/../PHPMailer/src/Exception.php';
require SERVER_DIR.'/../PHPMailer/src/PHPMailer.php';
require SERVER_DIR.'/../PHPMailer/src/SMTP.php';

/*
$emailServer = new EmailServer_PHPMailer_Gmail(
	'...',
	'...',
	'...'
);

$message = new EmailMessage();
$message->addReceiver('a@b.com', 'Arnaldo');
$message->setSubject ('Password reset');
$message->setBody    ("Hello world!\r\n\r\nThis is an email.\r\n\r\nBest regards,\r\nForever Home");

if(!$emailServer->sendMessage($message)) echo "Failed";
else echo "Success!";
*/

class EmailMessage {
	public function __construct(){}
	private array $receivers;
	private string $subject;
	private string $body;
	public function addReceiver(string $address, string $name) : void { $this->receivers[] = ['address' => $address, 'name' => $name]; }
	public function setSubject (string $subject ) : void { $this->subject     = $subject;  }
	public function setBody    (string $body    ) : void { $this->body        = $body;     }
	public function getReceivers() : array  { return $this->receivers; }
	public function getSubject  () : string { return $this->subject;   }
	public function getBody     () : string { return $this->body;      }
}

interface EmailServer {
	public function sendMessage(EmailMessage $message) : bool;
}

class EmailServer_PHPMailer implements EmailServer {
	private PHPMailer $mailer;
	public function __construct(){
		$this->mailer = new PHPMailer(true);
		$this->mailer->SMTPDebug  = SMTP::DEBUG_SERVER;
		$this->mailer->isSMTP();
		$this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	}

	public function setHost(string $host) : void {
		$this->mailer->Host = $host;
	}
	public function setPort(int $port) : void {
		$this->mailer->Port = $port;
	}
	public function authenticate(string $username, string $password) : void {
		$this->mailer->SMTPAuth = true;
		$this->mailer->Username = $username;
		$this->mailer->Password = $password;
	}
	public function setFrom    (string $address, string $name) : void {
		$this->mailer->setFrom($address, $name);
		$this->mailer->addReplyTo($address, $name);
	}

	public function sendMessage(EmailMessage $message) : bool {
		$receivers = $message->getReceivers();
		foreach($receivers as $receiver){
			$this->mailer->addAddress($receiver['address'], $receiver['name']);
		}
		$this->mailer->isHTML(false);
		$this->mailer->Subject = $message->getSubject();
		$this->mailer->Body    = $message->getBody();
		return $this->mailer->send();
	}
}

class EmailServer_PHPMailer_Gmail implements EmailServer {
	private EmailServer_PHPMailer $server;
	public function __construct(
		string $address,
		string $password,
		string $name
	){
		$this->server = new EmailServer_PHPMailer();
		$this->server->setHost('smtp.gmail.com');
		$this->server->setPort(587);
		$this->server->authenticate($address, $password);
		$this->server->setFrom($address, $name);
	}
	public function sendMessage(EmailMessage $message) : bool {
		return $this->server->sendMessage($message);
	}
}

/*
class EmailServer_PHPMailer_FEUP implements EmailServer {
	private EmailServer_PHPMailer $server;
	public function __construct(
		string $address,
		string $name
	){
		$this->server = new EmailServer_PHPMailer();
		$this->server->setHost('smtp.fe.up.pt');
		$this->server->setPort(25);
		$this->server->setFrom($address, $name);
	}
	public function sendMessage(EmailMessage $message) : bool {
		return $this->server->sendMessage($message);
	}
}
*/
