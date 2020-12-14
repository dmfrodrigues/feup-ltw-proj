<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

try {
    if (isset($_POST["csrf"]) && isset($_COOKIE["CSRFtoken"])) {
        if ($_POST["csrf"] == $_COOKIE["CSRFtoken"]) {
            if (User::checkCredentials($_POST['username'], $_POST['password'])) {
                if (!isShelter($_POST['username'])){
                    $_SESSION['username'] = $_POST['username'];
                    header('Location: ' . PROTOCOL_API_URL);
                } else {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['isShelter'] = 1;
                    header('Location: ' . PROTOCOL_API_URL);
                }
            } else {
                header('Location: ' . PROTOCOL_API_URL . '/login?failed=1&errorCode=3');
            }
        }
    }
} catch(PDOException $e) {
    // $errorMessage = urlencode('Something Went Wrong');
    header('Location: ' . PROTOCOL_API_URL . '/login?failed=1&errorCode=-1');
} catch(Exception $e) {
    // $errorMessage = urlencode($e->getMessage());
    header('Location: ' . PROTOCOL_API_URL . '/login?failed=1&errorCode=-1');
}

die();
