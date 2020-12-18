<?php
    function drawPetProposal(AdoptionRequest $request, bool $isMyPetProposal): void {
        if($request->getOutcome() == 'pending') { ?>
            <div id="proposal"> 
                <?php if($isMyPetProposal) { ?>
                    <div id="proposal-header">
                        <a href="<?= PROTOCOL_API_URL ?>/user/<?=$request->getUserId()?>">
                            <?php $proposal_pic = User::fromDatabase($request->getUserId())->getPictureUrl();?>
                            <img id="proposal-pic" src="<?php echo (is_null($proposal_pic) ? PROTOCOL_CLIENT_URL."/resources/img/no-image.svg" : $proposal_pic)?>">
                        </a>
                    </div>
                <?php } ?>
            <div id="proposal-info-box">
                <?php if($isMyPetProposal) { ?>
                    <p><?=$request->getUserId()?> on <?=$request->getDate()?> for <a id="proposal-pet" href="<?= PROTOCOL_API_URL ?>/pet/<?=$request->getPetId()?>"><?=$request->getPet()->getName()?></a></p>
                <?php } else { ?>
                    <p>                              <?=$request->getDate()?> for <a id="proposal-pet" href="<?= PROTOCOL_API_URL ?>/pet/<?=$request->getPetId()?>"><?=$request->getPet()->getName()?></a></p>
                <?php } ?>
                
                <div id="proposal-message">
                    <textarea readonly><?=$request->getText()?></textarea>
                </div>  
                
                <?php if($isMyPetProposal) { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/change_adoptionRequest_outcome.php?csrf=<?=$_SESSION['csrf']?>&requestId=<?=$request->getId()?>&username=<?=$_SESSION['username']?>&outcome=accepted&petId=<?=$request->getPetId()?>'" id="acceptRequest">Accept Request</button>
                    <button onclick="location.href='<?= PROTOCOL_API_URL ?>/adoptionRequest/<?=$request->getId()?>/message'" id="answerRequest">Answer Request</button>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/change_adoptionRequest_outcome.php?csrf=<?=$_SESSION['csrf']?>&requestId=<?=$request->getId()?>&username=<?=$_SESSION['username']?>&outcome=rejected&petId=<?=$request->getPetId()?>'" id="refuseRequest">Refuse Request</button>
                <?php } else { ?>
                    <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/remove_proposal.php?csrf=<?=$_SESSION['csrf']?>&id=<?=$request->getPetId()?>'"id="cancelRequest">Cancel Request</button>
                    <button onclick="location.href='<?= PROTOCOL_API_URL ?>/adoptionRequest/<?=$request->getId()?>/message'" id="answerRequest">View Chat</button>
                <?php } ?>

            </div>
        </div>
       <?php } ?>  
    <?php } ?>

    <?php 

    function drawAdoptionRequestInitialMessage($adoptionRequest) { 
            $userWhoProposed = $adoptionRequest->getUser()->getUsername();
            $userWhoProposedLink = "<a href='" . PROTOCOL_API_URL . '/user/' . $userWhoProposed . "'>" . $userWhoProposed . "</a>";
            $petOwner = $adoptionRequest->getPet()->getPostedById();
            $petOwnerLink = "<a href='" . PROTOCOL_API_URL . '/user/' . $petOwner . "'>" . $petOwner . "</a>";
            $petLink = "<a href='" . PROTOCOL_API_URL . '/pet/' . $adoptionRequest->getPet()->getId() . "'>" . $adoptionRequest->getPet()->getName() . "</a>";
        ?>
        <input type="hidden" name="isOwnerSending" value="<?=$_SESSION['username'] === $petOwner ?>">
        <input type="hidden" name="userWhoProposed" value="<?=$userWhoProposed ?>">
        <input type="hidden" name="petOwner" value="<?=$petOwner ?>">
        <input type="hidden" name="userWhoProposedLink" value="<?=$userWhoProposedLink ?>">
        <input type="hidden" name="petOwnerLink" value="<?=$petOwnerLink ?>">
        <input type="hidden" name="petLink" value="<?=$petLink ?>">
        <section class="messages-column-body">
            <h1 class="secondary-title">Proposal Chat</h1>
            <img id="proposal-pet-photo" alt="Pet photo" src="<?= getPetMainPhoto($adoptionRequest->getPet()) ?>">
            <div id="proposal-msg"> 
                <input type="hidden" value="<?=$_SESSION['username'] == $adoptionRequest->getUserId() ?>">
                <div id="proposal-header">
                    <a href="<?= PROTOCOL_API_URL ?>/user/<?=$adoptionRequest->getUserId()?>">
                        <?php $proposal_pic = User::fromDatabase($adoptionRequest->getUserId())->getPictureUrl();?>
                        <img id="proposal-pic" src="<?php echo (is_null($proposal_pic) ? PROTOCOL_CLIENT_URL."/resources/img/no-image.svg" : $proposal_pic)?>">
                    </a>
                </div>
                <div id="proposal-info">
                        <p><?=$adoptionRequest->getUserId()?> on <?=$adoptionRequest->getDate()?> for <a id="proposal-pet" href="<?= PROTOCOL_API_URL ?>/pet/<?=$adoptionRequest->getPetId()?>"><?=$adoptionRequest->getPet()->getName()?></a></p>
                    
                    <div id="proposal-message">
                        <textarea readonly>&nbsp;<?=$adoptionRequest->getText()?></textarea>
                    </div>  
                </div>
            </div>
    <?php } ?>
    
    <?php 

    function drawAllOtherMessages($adoptionRequestMessages): void { 
        foreach($adoptionRequestMessages as $reqMessage) { ?>
            <div id="proposal-msg"> 
                <div id="proposal-header">
                    <a href="<?= PROTOCOL_API_URL ?>/user/<?=$reqMessage->getUserId()?>">
                        <?php $proposal_pic = User::fromDatabase($reqMessage->getUserId())->getPictureUrl();?>
                        <img id="proposal-pic" src="<?php echo (is_null($proposal_pic) ? PROTOCOL_CLIENT_URL."/resources/img/no-image.svg" : $proposal_pic)?>">
                    </a>
                </div>
                <div id="proposal-info">
                        <p><?=$reqMessage->getUserId()?> on <?=$reqMessage->getMessageDate()?> for <a id="proposal-pet" href="<?= PROTOCOL_API_URL ?>/pet/<?=$reqMessage->getPet()->getName()?>"><?=$reqMessage->getPet()->getName()?></a></p>
                    
                    <div id="proposal-message">
                        <textarea readonly>&nbsp;<?=$reqMessage->getText()?></textarea>
                    </div>  
                </div>
            </div>
        <?php } ?>      
    <?php } ?>

    <?php 

    function drawAnswerAdoptionRequest($request): void { ?>
        <div id="proposal-msg"> 
            <input type="hidden" value="1">
            <input type="hidden" name="requestID" value="<?= $request->getId()?>">
            <input type="hidden" name="username" value="<?= $_SESSION['username']?>">
            <div id="proposal-header">
                <a href="<?= PROTOCOL_API_URL ?>/user/<?=$_SESSION['username']?>">
                    <?php $proposal_pic = User::fromDatabase($_SESSION['username'])->getPictureUrl();?>
                    <img id="proposal-pic" src="<?php echo (is_null($proposal_pic) ? PROTOCOL_CLIENT_URL."/resources/img/no-image.svg" : $proposal_pic)?>">
                </a>
            </div>
            <div id="proposal-info">
                    <p>&nbsp;</p>
                <div id="proposal-message-submit">
                    <textarea></textarea>
                    <button class="dark" onclick="addNewAdoptionRequestMsg()" id="submitAnswer">Submit</button>
                    <div id="proposal-messages-refresh"><button id="update" class="image" onclick="onClickedUpdateChat(this)"><img src="<?= PROTOCOL_CLIENT_URL ?>/resources/img/update.svg"/></button></div>
                </div>  
            </div>
        </div>
    </section>
    <?php } ?>

    <?php

    function drawProposals(array $adoptionRequests): void { ?> 
        <h1 class="secondary-title">Adoption Requests</h1><?php

        $counter = 0;
        foreach($adoptionRequests as $request)
            if ($request->getOutcome() !== 'accepted') $counter++;

        if ($counter == 0) { ?>
            <p class="default-info-text">There are no new adoption proposals!</p>
        <?php }

        foreach($adoptionRequests as $request) {
            if ($request->getOutcome() !== 'accepted')
                drawPetProposal($request, true);
            }    
    }

    function drawMyProposals(array $adoptionRequests): void { ?>
        <h1 class="secondary-title">My Adoption Requests</h1><?php

        $counter = 0;
        foreach($adoptionRequests as $request)
            if ($request->getOutcome() !== 'accepted') $counter++;
        
        if ($counter == 0) { ?>
            <p class="default-info-text">There are no new adoption requests made by you!</p>
        <?php }
        foreach($adoptionRequests as $request) 
            drawPetProposal($request, false);
    }