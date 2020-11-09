<?php
    function drawSingleProposal($reqId, $name, $adoptionMessage, $petId, $user, $outcome, $reqDate) { 
        if($outcome == 'pending') { ?>
            <div id="proposal"> 
            <div id="proposal-header">
                <a href="profile.php?username=<?=$user?>">
                    <img id="proposal-pic" src="../server/resources/img/profiles/<?=$user?>.jpg">
                </a>
            </div>
            <div id="proposal-info">
                <p><?=$user?> on <?=$reqDate?> for <a id="proposal-pet" href="pet.php?id=<?=$petId?>"><?=$name?></a></p>
                
                <div id="proposal-message">
                    <textarea readonly><?=$adoptionMessage?></textarea>
                </div>  
  
                <button onclick="location.href='action_change_adoptionRequest_outcome.php?requestId=<?=$reqId?>&username=<?=$_SESSION['username']?>&outcome=accepted'" id="acceptRequest">Accept Request</button>
                <button onclick="location.href='requestAdoption.php?id=<?=$reqId?>'"id="answerRequest">Answer Request</button>
                <button onclick="location.href='action_change_adoptionRequest_outcome.php?requestId=<?=$reqId?>&username=<?=$_SESSION['username']?>&outcome=rejected'" id="refuseRequest">Refuse Request</button>

            </div>
        </div>
       <?php } ?>  
    <?php } ?>

    <?php function drawProposals($adoptionRequests) {
        foreach($adoptionRequests as $adoptionReq) {
            drawSingleProposal($adoptionReq['requestId'], $adoptionReq['name'], $adoptionReq['text'], $adoptionReq['id'], $adoptionReq['user'], $adoptionReq['outcome'], $adoptionReq['requestDate']);
        }
    }