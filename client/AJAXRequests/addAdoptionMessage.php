<?php
    require_once('../../server/connection.php');

    $stmt1 = $db->prepare('INSERT INTO AdoptionRequestMessage(text, request, user)
        VALUES(:message, :requestId, :user)');
    
    $stmt1->bindValue(':message', $_POST['Msgtext']);
    $stmt1->bindValue(':requestId', $_POST['requestId']);
    $stmt1->bindValue(':user', $_POST['user']);
    $stmt1->execute();

    echo json_encode(array('success' => true));
