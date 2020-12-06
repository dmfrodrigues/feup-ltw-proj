<?php

    include_once('../../server/server.php');
    include_once('../../server/connection.php');
    include_once('../../server/users.php');   

    try {
        removeFromFavorites($_POST['username'], $_POST['petId']);
        $data = array('successful' => true);
        echo json_encode($data);
    }
    catch(Exception $e) {
        $data = array('successful' => false);
        echo json_encode($data);
    }

