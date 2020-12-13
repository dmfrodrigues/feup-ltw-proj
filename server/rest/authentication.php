<?php
namespace Authentication {
    require_once __DIR__ . '/api_main.php';
    require_once SERVER_DIR . '/User.php';
    require_once SERVER_DIR . '/Shelter.php';

    function check() : ?\User {
        if(isset($_SESSION['username'])){ 
            return \User::fromDatabase($_SESSION['username']);
        } else return null;
    }

    /**
     * Escape all HTML, JavaScript, and CSS
     * 
     * @param string $input The input string
     * @param string $encoding Which character encoding are we using?
     * @return string
     */
    function noHTML($input, $encoding = 'UTF-8') // XSS preventing - Escapes all characters.
    {
        return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
    }

    function CSPHeaderSet() { 
        $headerCSP = "Content-Security-Policy:" .
            "default-src 'self' ;" .  
            "img-src 'self' data: ;" .
            "script-src 'self' 'unsafe-inline';" .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' https://fonts.gstatic.com";

        header($headerCSP);
    }

    function CSRF_GetToken() : ?string {
        if(isset($_SESSION['username'])) {
            if(isset($_SESSION['csrf'])) 
                return $_SESSION['csrf'];
            else {
                $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
                $_SESSION['csrf'] = $csrfToken;
                return $csrfToken;
            }
        }
        return null;
    }

    function verifyCSRF_Token() : void {
        if(!isset($_GET['csrf'])) {
            if($_SESSION['csrf'] != $_POST['csrf']) {
                http_response_code(403);
                die();
            }
        }
        else {
            if($_SESSION['csrf'] != $_GET['csrf']) {
                http_response_code(403);
                die();
            }
        }
    }

    function verifyAPI_Token(string $token) {

        if($_SESSION['csrf'] != $token) {
            http_response_code(403);
            die();
        }
    }
}
