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
}
