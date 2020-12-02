<?php
    include_once('../../server/connection.php');

    $stmt1 = $db->prepare('INSERT INTO AdoptionRequestMessage(text, request, user)
        VALUES(?, ?, ?)');
    
    $stmt1->execute(array($_POST['Msgtext'], $_POST['requestId'], $_POST['user']));

    // $stmt = $db->prepare('SELECT * FROM AdoptionRequestMessage')