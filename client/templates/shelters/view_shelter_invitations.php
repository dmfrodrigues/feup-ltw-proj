<?php
    function drawInvitation($user, $shelter, $text, $requestDate) { ?>
            <div id="proposal"> 
                <div id="proposal-header">
                    <a href="profile.php?username=<?=$shelter?>"> 
                        <img id="proposal-pic" src="../server/resources/img/shelters/<?=$shelter?>.jpg">
                    </a>
                </div>
            <div id="proposal-info">
                <p><?=$shelter?> on <?=$requestDate?></p>
                
                <div id="proposal-message">
                    <textarea readonly><?=$text?></textarea>
                </div>  
        
                <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/accept_shelter_invitation.php?shelter=<?=$shelter?>'" id="acceptRequest">Accept Request</button>
                <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/refuse_shelter_invitation.php?shelter=<?=$shelter?>'" id="refuseRequest">Refuse Request</button>

            </div>
        </div>
    <?php } ?>

    <?php 

    function drawEmptyInvitations() { ?>
        <h2 style="text-align: center">No Shelter Invitations found!</h2>
    <?php } 

    function drawShelterInvitations($shelterInvitations) {
        if(count($shelterInvitations) > 0) { 
            foreach($shelterInvitations as $invitation) 
                drawInvitation(
                    $invitation['user'],
                    $invitation['shelter'],
                    $invitation['text'],
                    $invitation['requestDate']
                );
        } else { 
            drawEmptyInvitations();
        }
    }

    function drawInvitationError() { 
        include_once 'errors/errors.php'; ?>
            <p style="text-align: center" id='simple-fail-msg'><?= $errorsArray[$_GET['errorCode']] ?></p>
    <?php } 