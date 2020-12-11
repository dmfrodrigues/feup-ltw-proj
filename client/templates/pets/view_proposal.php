<?php
    function drawPetProposal($reqId, $name, $adoptionMessage, $petId, $user, $outcome, $reqDate, $isMyPetProposal) { 
        if($outcome == 'pending') { ?>
            <div id="proposal"> 
                <?php if($isMyPetProposal) { ?>
                    <div id="proposal-header">
                        <a href="profile.php?username=<?=$user?>">
                            <img id="proposal-pic" src="../server/resources/img/profiles/<?=$user?>.jpg">
                        </a>
                    </div>
                <?php } ?>
            <div id="proposal-info">
                <?php if($isMyPetProposal) { ?>
                    <p><?=$user?> on <?=$reqDate?> for <a id="proposal-pet" href="pet.php?id=<?=$petId?>"><?=$name?></a></p>
                <?php } else { ?>
                    <p><?=$reqDate?> for <a id="proposal-pet" href="pet.php?id=<?=$petId?>"><?=$name?></a></p>
                <?php } ?>
                
                <div id="proposal-message">
                    <textarea readonly><?=$adoptionMessage?></textarea>
                </div>  
                
                <?php if($isMyPetProposal) { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/change_adoptionRequest_outcome.php?requestId=<?=$reqId?>&username=<?=$_SESSION['username']?>&outcome=accepted&petId=<?=$petId?>'" id="acceptRequest">Accept Request</button>
                    <button onclick="location.href='adoptionMessages.php?id=<?=$reqId?>'"id="answerRequest">Answer Request</button>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/change_adoptionRequest_outcome.php?requestId=<?=$reqId?>&username=<?=$_SESSION['username']?>&outcome=rejected'" id="refuseRequest">Refuse Request</button>
                <?php } else { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/remove_proposal.php?id=<?=$petId?>'"id="cancelRequest">Cancel Request</button>
                    <button onclick="location.href='adoptionMessages.php?id=<?=$reqId?>'"id="answerRequest">View Chat</button>
                <?php } ?>

            </div>
        </div>
       <?php } ?>  
    <?php } ?>

    <?php 

    function drawAdoptionRequestInitialMessage($adoptionRequest) { ?>
        <section id="proposal-container">
            <div id="proposal-msg"> 
                <input type="hidden" value="<?=$_SESSION['username'] == $adoptionRequest['user']?>">
                <div id="proposal-header">
                    <a href="profile.php?username=<?=$adoptionRequest['user']?>">
                        <img id="proposal-pic" src="../server/resources/img/profiles/<?=$adoptionRequest['user']?>.jpg">
                    </a>
                </div>
                <div id="proposal-info">
                        <p><?=$adoptionRequest['user']?> on <?=$adoptionRequest['messDate']?> for <a id="proposal-pet" href="pet.php?id=<?=$adoptionRequest['pet']?>"><?=$adoptionRequest['petName']?></a></p>
                    
                    <div id="proposal-message">
                        <textarea readonly>&nbsp;<?=$adoptionRequest['text']?></textarea>
                    </div>  
                </div>
            </div>
    <?php } ?>
    
    <?php 

    function drawAllOtherMessages($adoptionRequestMessages) { 
        foreach($adoptionRequestMessages as $reqMessage) { ?>
            <div id="proposal-msg"> 
                <input type="hidden" value="<?=$_SESSION['username'] == $reqMessage['user']?>">
                <div id="proposal-header">
                    <a href="profile.php?username=<?=$reqMessage['user']?>">
                        <img id="proposal-pic" src="../server/resources/img/profiles/<?=$reqMessage['user']?>.jpg">
                    </a>
                </div>
                <div id="proposal-info">
                        <p><?=$reqMessage['user']?> on <?=$reqMessage['messDate']?> for <a id="proposal-pet" href="pet.php?id=<?=$reqMessage['pet']?>"><?=$reqMessage['petName']?></a></p>
                    
                    <div id="proposal-message">
                        <textarea readonly>&nbsp;<?=$reqMessage['text']?></textarea>
                    </div>  
                </div>
            </div>
        <?php } ?>      
    <?php } ?>

    <?php 

    function drawAnswerAdoptionRequest() { ?>
        <div id="proposal-msg"> 
            <input type="hidden" value="1">
            <input type="hidden" name="requestID" value="<?= $_GET['id']?>">
            <input type="hidden" name="username" value="<?= $_SESSION['username']?>">
            <div id="proposal-header">
                <a href="profile.php?username=<?=$_SESSION['username']?>">
                    <img id="proposal-pic" src="../server/resources/img/profiles/<?=$_SESSION['username']?>.jpg">
                </a>
            </div>
            <div id="proposal-info">
                    <p>&nbsp;</p>
                <div id="proposal-message-submit">
                    <textarea></textarea>
                    <button class="dark" onclick="addNewAdoptionRequestMsg()" id="submitAnswer">Submit</button>
                    <div id="proposal-messages-refresh"><button id="update" class="image" onclick="onClickedUpdateComments(this)"><img src="resources/img/update.svg"/></button></div>
                </div>  
            </div>
        </div>
    </section>
    <?php } ?>      

    <?php

    function drawProposals($adoptionRequests) {
        foreach($adoptionRequests as $adoptionReq) {
            if ($adoptionReq['outcome'] !== 'accepted')
                drawPetProposal($adoptionReq['requestId'], $adoptionReq['name'], $adoptionReq['text'], $adoptionReq['id'],
                    $adoptionReq['user'], $adoptionReq['outcome'], $adoptionReq['requestDate'], true);
            }    
    }

    function drawMyProposals($adoptionRequests) {
        foreach($adoptionRequests as $adoptionReq) 
            drawPetProposal($adoptionReq['requestId'], $adoptionReq['name'], $adoptionReq['text'], $adoptionReq['id'],
                $adoptionReq['user'], $adoptionReq['outcome'], $adoptionReq['requestDate'], false);
    }