<?php
    include_once('../../server/connection.php');

    $stmt1 = $db->prepare('INSERT INTO AdoptionRequestMessage(text, request, user)
        VALUES(:message, :requestId, :user)');
    
    $stmt1->bindParam(':message', $_POST['Msgtext']);
    $stmt1->bindParam(':requestId', $_POST['requestId']);
    $stmt1->bindParam(':user', $_POST['user']);
    $stmt1->execute();
    $lastInsertedID = $db->lastInsertId();

    $stmt2 = $db->prepare('SELECT text, request, messageDate, user FROM AdoptionRequestMessage');
    $stmt2->execute();
    $insertedMsgs = $stmt2->fetchAll();

    $stmt3 = $db->prepare('SELECT pet FROM AdoptionRequest WHERE id =:requestId');
    $stmt3->bindParam(':requestId', $_POST['requestId']);
    $stmt3->execute();
    $petId = $stmt3->fetch();

    $stmt4 = $db->prepare('SELECT name FROM Pet WHERE id =:petId');
    $stmt4->bindParam(':petId', $petId['pet']);
    $stmt4->execute();
    $petName = $stmt4->fetch();

    $data = array(
        'comments' => $insertedMsgs,
        'petId' => $petId,
        'petName' => $petName,
    );

    echo json_encode($data);
    
