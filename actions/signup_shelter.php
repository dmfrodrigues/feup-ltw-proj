<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
require_once SERVER_DIR.'/classes/Shelter.php';

try {
    addShelter(
        htmlspecialchars($_POST['username']), 
        htmlspecialchars($_POST['shelterName']), 
        htmlspecialchars($_POST['location']), 
        htmlspecialchars($_POST['description']), 
        htmlspecialchars($_POST['pwd']),
        htmlspecialchars($_POST['email'])
    );
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['isShelter'] = 1;
    header_location('/user/'. $_SESSION['username']);
} catch(PDOException $e) {
    header_location('/user/new?failed=1&errorCode=-1');
} catch(UserAlreadyExistsException $e) {
    header_location('/user/new?failed=1&errorCode=2');
} catch(InvalidUsernameException $e) {
    header_location('/user/new?failed=1&errorCode=6');
} catch(Exception $e) {
    header_location('/user/new?failed=1&errorCode=5');
}

die();
