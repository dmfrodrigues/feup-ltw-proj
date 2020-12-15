<?php
namespace Authentication {
    require_once __DIR__ . '/api_main.php';
    require_once SERVER_DIR . '/User.php';
    require_once SERVER_DIR . '/Shelter.php';

    function check(bool $harmless = false) : ?\User {
        if(!$harmless) {
            $headers = apache_request_headers();
            if(!isset($headers['X-CSRFToken']) && !isset($_GET['csrf'])) {
                my_response_code(400);
                die();
            }
            $csrfTok = isset($headers['X-CSRFToken']) ? $headers['X-CSRFToken'] : $_GET['csrf'];
            if(!\Authentication\verifyAPI_Token($csrfTok))
                return null;
        }
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

    /**
     * Generate CSP Header.
     * 
     * @return void
     */
    function CSPHeaderSet() : void { 
        $headerCSP = "Content-Security-Policy:" .
            "default-src 'self' ;" .  
            "img-src 'self' data: ;" .
            "script-src 'self' 'unsafe-inline';" .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' https://fonts.gstatic.com";

        header($headerCSP);
    }

    /**
     * Get CSRF Token.
     * 
     * @return string Returns the CSRF token.
     */
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

    /**
     * Verify if CSRF Token is correct (ACTIONS).
     * 
     * @return void 
     */
    function verifyCSRF_Token() : void {
        if(!isset($_GET['csrf'])) {
            if($_SESSION['csrf'] != $_POST['csrf']) {
                my_response_code(403);
                die();
            }
        }
        else {
            if($_SESSION['csrf'] != $_GET['csrf']) {
                my_response_code(403);
                die();
            }
        }
    }

    /**
     * Verify if CSRF Token is correct (API REST).
     * 
     * @return void 
     */
    function verifyAPI_Token(string $token) : bool{
        if($_SESSION['csrf'] != $token) 
            return false;
        return true;
    }
}
