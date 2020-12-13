<?php

    require_once SERVER_DIR.'/server.php';
    require_once SERVER_DIR.'/connection.php';
    require_once SERVER_DIR.'/User.php';   

    try {
        $pet = Pet::fromDatabase(intval($_POST['petId']));
        $user = User::fromDatabase($_POST['username']);
        $pet->removeFromFavorites($user);

        $data = array('successful' => true);
        echo json_encode($data);
    }
    catch(Exception $e) {
        $data = array('successful' => false);
        echo json_encode($data);
    }

