<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';

try {
    if (isset($_POST["csrf"]) && isset($_COOKIE["CSRFtoken"])) {
        if ($_POST["csrf"] == $_COOKIE["CSRFtoken"]) {
            if (User::checkCredentials($_POST['username'], $_POST['password'])) {
                if (!isShelter($_POST['username'])){
                    $_SESSION['username'] = $_POST['username'];
                    header_location('');
                } else {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['isShelter'] = 1;
                    header_location('');
                }
            } else {
                header_location('/login?failed=1&errorCode=3');
            }
        }
    }
} catch(PDOException $e) {
    header_location('/login?failed=1&errorCode=-1');
} catch(Exception $e) {
    header_location('/login?failed=1&errorCode=-1');
}

die();
