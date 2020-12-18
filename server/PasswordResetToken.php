<?php

require_once __DIR__.'/server.php';

// https://stackoverflow.com/a/3291689/12283316
function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 0) return $min; // not so random...
    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

// https://stackoverflow.com/a/3291689/12283316
function getToken(int $length = 32){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    for($i = 0; $i < $length; $i++){
        $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
    }
    return $token;
}

class PasswordResetToken {
    public static int $VALIDITY = 24*60*60; // 24 hours

    private string $username;
    private string $token;
    private string $created;
    private string $expires;
    public function __construct(){}

    public function getUser   () : ?User  { return User::fromDatabase($this->username); }
    public function getUserId () : string { return $this->username                    ; }
    public function getToken  () : string { return $this->token                       ; }
    public function getCreated() : int    { return strtotime($this->created)          ; }
    public function getExpires() : int    { return strtotime($this->expires)          ; }

    public function setUser   (string $username) : void { $this->username = $username; }

    public function generateToken() : void {
        $this->token = 'ABC';

        $this->expires = date("Y-m-d H:i:s", time() + PasswordResetToken::$VALIDITY);
    }

    static public function fromDatabase(string $username) : ?PasswordResetToken {
        global $db;
        $stmt = $db->prepare('SELECT * FROM PasswordResetToken WHERE username=:username');
        $stmt->bindValue(':username', $username);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'PasswordResetToken');
        $stmt->execute();
        $reset = $stmt->fetch();
        if($reset == false) return null;
        return $reset;
    }

    public function addToDatabase() : void {
        $oldReset = PasswordResetToken::fromDatabase($this->username);
        if($oldReset !== null) $oldReset->deleteFromDatabase();
        
        global $db;
        $stmt = $db->prepare('INSERT INTO PasswordResetToken(username, token, expires)
        VALUES (:username, :token, :expires)');
        $stmt->bindValue(':username', $this->username);
        $stmt->bindValue(':token'   , $this->token   );
        $stmt->bindValue(':expires' , $this->expires );
        if(!$stmt->execute()) throw new RuntimeException("Could not add PasswordResetToken to database");
        
        $newReset = PasswordResetToken::fromDatabase($this->username);
        $this->created = $newReset->created;
    }

    public function deleteFromDatabase() : void {
        global $db;
        $stmt = $db->prepare('DELETE FROM PasswordResetToken
        WHERE username=:username');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
    }

    static public function cleanOldEntries() : void {
        /*
        global $db;
        $stmt = $db->prepare('SELECT * FROM PasswordResetToken WHERE username=:username');
        $stmt->bindValue(':username', $username);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'PasswordResetToken');
        $stmt->execute();
        $reset = $stmt->fetch();
        if($reset == false) throw new RuntimeException("No such password reset token");
        return $reset;
        */
    }
}

require_once SERVER_DIR.'/connection.php';

$reset = new PasswordResetToken();
$reset->setUser('dmfr');
$reset->generateToken();
$reset->addToDatabase();
