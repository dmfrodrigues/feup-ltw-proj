<?php
    include_once('../../server/connection.php');

    $stmt1 = $db->prepare('INSERT INTO AdoptionRequestMessage(text, request, user)
        VALUES(?, ?, ?)');
    
    $stmt1->execute(array($_POST['Msgtext'], $_POST['requestId'], $_POST['user']));
    $lastInsertedID = $db->lastInsertId();

    $stmt2 = $db->prepare('SELECT text, request, messageDate, user FROM AdoptionRequestMessage WHERE id = ?');
    $stmt2->execute(array($lastInsertedID));
    $lastInsertedMsg = $stmt2->fetch();

    echo json_encode($lastInsertedMsg);
    
