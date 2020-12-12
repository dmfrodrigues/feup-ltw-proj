<?php
namespace Authentication {
    require_once __DIR__ . '/api_constants.php';
    require_once SERVER_DIR . '/users.php';

    function check() : ?\User {
        if(isset($_SESSION['username'])){ 
            return \User::fromDatabase($_SESSION['username']);
        } else return null;
    }
}
