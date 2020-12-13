<?php
    function drawInvitation(User $user, Shelter $shelter, $text, $requestDate, $isShelter): void { ?>
            <div id="proposal"> 
                <div id="proposal-header">
                    <a href="<?= PROTOCOL_API_URL ?>/user/<?= $shelter->getUsername() ?>"> 
                        <img id="proposal-pic" src="<?php 
                        $shelter_pic = $shelter->getPictureUrl();
                        echo (is_null($shelter_pic) ? "resources/img/no-image.svg" : $shelter_pic) ?>
                        ">
                    </a>
                </div>
            <div id="proposal-info">
                <?php if (!$isShelter) { ?>
                    <p><?= $shelter->getUsername() ?> on <?=$requestDate?></p>
                <?php } else { ?>
                    <p>To <a href="<?= PROTOCOL_API_URL ?>/user/<?= $user->getUsername() ?>"><?= $user->getUsername() ?></a> on <?=$requestDate?></p>
                <?php } ?>
                <div id="proposal-message">
                    <textarea readonly><?=$text?></textarea>
                </div>  
                
                <?php if(!$isShelter) { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/accept_shelter_invitation.php?shelter=<?= $shelter->getUsername() ?>'" id="acceptRequest">Accept Request</button>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/refuse_shelter_invitation.php?shelter=<?= $shelter->getUsername() ?>'" id="refuseRequest">Refuse Request</button>
                <?php } else { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/shelter_cancel_invitation.php?username=<?= $user->getUsername() ?>'" id="refuseRequest">Remove Request</button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <?php 

    function drawEmptyInvitations(): void { ?>
        <h2 style="text-align: center">No Shelter Invitations found!</h2>
    <?php } 

    function drawShelterInvitations($shelterInvitations, $isShelter): void {
        if(count($shelterInvitations) > 0) { 
            foreach($shelterInvitations as $invitation){
                $user    = User   ::fromDatabase($invitation['user'   ]);
                $shelter = Shelter::fromDatabase($invitation['shelter']);
                drawInvitation(
                    $user,
                    $shelter,
                    $invitation['text'],
                    $invitation['requestDate'],
                    $isShelter
                );
            }
        } else { 
            drawEmptyInvitations();
        }
    }

    function drawInvitationError(): void { 
        global $errorsArray; ?>
            <p style="text-align: center" id='simple-fail-msg'><?= $errorsArray[$_GET['errorCode']] ?></p>
    <?php } 