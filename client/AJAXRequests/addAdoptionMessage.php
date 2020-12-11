<?php
    require_once('../../server/connection.php');

    $stmt1 = $db->prepare('INSERT INTO AdoptionRequestMessage(text, request, user)
        VALUES(:message, :requestId, :user)');
    
    $stmt1->bindParam(':message', $_POST['Msgtext']);
    $stmt1->bindParam(':requestId', $_POST['requestId']);
    $stmt1->bindParam(':user', $_POST['user']);
    $stmt1->execute();

    echo json_encode(array('success' => true));
    
