<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

try {
    if (isset($_POST["csrf"]) && isset($_COOKIE["CSRFtoken"])) {
        if ($_POST["csrf"] == $_COOKIE["CSRFtoken"]) {
            if (User::checkCredentials($_POST['username'], $_POST['password'])) {
                if (!isShelter($_POST['username'])){
                    $_SESSION['username'] = $_POST['username'];
                    header('Location: ' . PROTOCOL_SERVER_URL);
                } else {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['isShelter'] = 1;
                    header('Location: ' . PROTOCOL_SERVER_URL);
                }
            } else {
                header('Location: ' . PROTOCOL_SERVER_URL . '/login?failed=1&errorCode=3');
            }
        }
    }
} catch(PDOException $e) {
    header('Location: ' . PROTOCOL_SERVER_URL . '/login?failed=1&errorCode=-1');
} catch(Exception $e) {
    header('Location: ' . PROTOCOL_SERVER_URL . '/login?failed=1&errorCode=-1');
}

die();
