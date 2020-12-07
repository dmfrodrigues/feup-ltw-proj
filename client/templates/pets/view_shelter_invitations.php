<?php
    function drawInvitation($user, $shelter, $text, $requestDate) { ?>
            <div id="proposal"> 
                <div id="proposal-header">
                    <a href="profile_shelter.php?username=<?=$shelter?>"> 
                        <img id="proposal-pic" src="../server/resources/img/shelters/<?=$shelter?>.jpg">
                    </a>
                </div>
            <div id="proposal-info">
                <p><?=$shelter?> on <?=$requestDate?></p>
                
                <div id="proposal-message">
                    <textarea readonly><?=$text?></textarea>
                </div>  
        
                <button onclick="location.href='<?= SERVER_URL ?>/actions/accept_shelter_invitation.php?shelter=<?=$shelter?>'" id="acceptRequest">Accept Request</button>
                <button onclick="location.href='<?= SERVER_URL ?>/actions/refuse_shelter_invitation.php?shelter=<?=$shelter?>'" id="refuseRequest">Refuse Request</button>

            </div>
        </div>
    <?php } ?>

    <?php 

    function drawShelterInvitations($shelterInvitations) {
        foreach($shelterInvitations as $invitation) 
            drawInvitation(
                $invitation['user'],
                $invitation['shelter'],
                $invitation['text'],
                $invitation['requestDate']
            );
    }

    function drawInvitationError() { 
        $errorMsg = urldecode($_GET['errorMessage']); ?>
        <p style="text-align: center" id='simple-fail-msg'><?=$errorMsg?></p>
    <?php } ?>