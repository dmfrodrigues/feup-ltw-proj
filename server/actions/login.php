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
                    header('Location: ' . PROTOCOL_CLIENT_URL . '/index.php');
                } else {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['isShelter'] = 1;
                    header('Location: ' . PROTOCOL_CLIENT_URL . '/index.php');
                }
            }
        }
    } else {
        header('Location: ' . PROTOCOL_CLIENT_URL . '/login.php?failed=1&errorCode=3');
    }
} catch(PDOException $e) {
    header('Location: ' . CLIENT_URL . '/login.php?failed=1&errorCode=-1');
} catch(Exception $e) {
    header('Location: ' . CLIENT_URL . '/login.php?failed=1&errorCode=-1');
}

die();
