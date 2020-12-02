<?php
    include_once('../../server/connection.php');

    $stmt1 = $db->prepare('INSERT INTO AdoptionRequestMessage(text, request, user)
        VALUES(?, ?, ?)');
    
    $stmt1->execute(array($_POST['Msgtext'], $_POST['requestId'], $_POST['user']));
    $lastInsertedID = $db->lastInsertId();

    $stmt2 = $db->prepare('SELECT text, request, messageDate, user FROM AdoptionRequestMessage');
    $stmt2->execute();
    $insertedMsgs = $stmt2->fetchAll();

    $stmt3 = $db->prepare('SELECT pet FROM AdoptionRequest WHERE id = ?');
    $stmt3->execute(array($_POST['requestId']));
    $petId = $stmt3->fetch();

    $stmt4 = $db->prepare('SELECT name FROM Pet WHERE id = ?');
    $stmt4->execute(array($petId['pet']));
    $petName = $stmt4->fetch();

    $data = array(
        'comments' => $insertedMsgs,
        'petId' => $petId,
        'petName' => $petName,
    );

    echo json_encode($data);
    
