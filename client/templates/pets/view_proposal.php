<?php
    function drawSingleProposal($name, $adoptionMessage, $petId, $user, $reqDate) { ?>

        <div id="proposal"> 
            <div id="proposal-header">
                <a href="profile.php?username=<?=$user?>">
                    <img src="../server/resources/img/profiles/<?=$user?>.jpg">
                </a>
            </div>
            <div id="proposal-info">
                <p><?=$user?> on <?=$reqDate?> for <a id="proposal-pet" href="pet.php?id=<?=$petId?>"><?=$name?></a></p>
                
                <div id="proposal-message">
                    <textarea readonly><?=$adoptionMessage?></textarea>
                </div>  
            </div>
        </div>
            

   
    <?php } ?>

    <?php function drawProposals($adoptionRequests) {
        foreach($adoptionRequests as $adoptionReq) {
            drawSingleProposal($adoptionReq['name'], $adoptionReq['text'], $adoptionReq['id'], $adoptionReq['user'], $adoptionReq['requestDate']);

        }
    }