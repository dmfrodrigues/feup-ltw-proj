<?php

    require_once('../../server/server.php');
    require_once('../../server/connection.php');
    require_once('../../server/users.php');

    try {
        addToFavorites($_POST['username'], $_POST['petId']);
        $data = array('successful' => true);
        echo json_encode($data);
    }
    catch(Exception $e) {
        $data = array('successful' => false);
        echo json_encode($data);
    }

