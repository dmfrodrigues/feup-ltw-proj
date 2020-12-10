<?php
    function drawInvitation($user, $shelter, $text, $requestDate, $isShelter) { ?>
            <div id="proposal"> 
                <div id="proposal-header">
                    <a href="profile.php?username=<?=$shelter?>"> 
                        <img id="proposal-pic" src="<?php 
                        $shelter_pic = getUserPicture($shelter);
                        echo (is_null($shelter_pic) ? "resources/img/no-image.svg" : $shelter_pic) ?>
                        ">
                    </a>
                </div>
            <div id="proposal-info">
                <?php if (!$isShelter) { ?>
                    <p><?=$shelter?> on <?=$requestDate?></p>
                <?php } else { ?>
                    <p>To <a href="profile.php?username=<?=$user?>"><?=$user?></a> on <?=$requestDate?></p>
                <?php } ?>
                <div id="proposal-message">
                    <textarea readonly><?=$text?></textarea>
                </div>  
                
                <?php if(!$isShelter) { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/accept_shelter_invitation.php?shelter=<?=$shelter?>'" id="acceptRequest">Accept Request</button>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/refuse_shelter_invitation.php?shelter=<?=$shelter?>'" id="refuseRequest">Refuse Request</button>
                <?php } else { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/shelter_cancel_invitation.php?username=<?=$user?>'" id="refuseRequest">Remove Request</button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <?php 

    function drawEmptyInvitations() { ?>
        <h2 style="text-align: center">No Shelter Invitations found!</h2>
    <?php } 

    function drawShelterInvitations($shelterInvitations, $isShelter) {
        if(count($shelterInvitations) > 0) { 
            foreach($shelterInvitations as $invitation) 
                drawInvitation(
                    $invitation['user'],
                    $invitation['shelter'],
                    $invitation['text'],
                    $invitation['requestDate'],
                    $isShelter
                );
        } else { 
            drawEmptyInvitations();
        }
    }

    function drawInvitationError() { 
        global $errorsArray; ?>
            <p style="text-align: center" id='simple-fail-msg'><?= $errorsArray[$_GET['errorCode']] ?></p>
    <?php } 