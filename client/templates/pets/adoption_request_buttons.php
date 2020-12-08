<?php $added_pets = getAddedPets($_SESSION['username']);
    $adoption_requests = getAdoptionRequests($_SESSION['username']);
    if (!isShelter($_SESSION['username'])) {
        if (!checkIfAdopted($pet['id'])) {
            if (!in_array($pet, $added_pets)) { 
                if (!userRequestedPet($_SESSION['username'], $pet['id'])) { ?>
                    <div id="propose"><a href="add_proposal.php?id=<?= $pet['id'] ?>"> <img src="resources/img/adopt-me.png" height="100px" width="100px"> </a></span>
        <?php } else { 
                    if (getAdoptionRequestOutcome($_SESSION['username'], $pet['id']) === 'pending') { ?>
                        <div id="remove-proposal"><a href="<?= SERVER_URL ?>/actions/remove_proposal.php?id=<?= $pet['id'] ?>" onclick="return confirm('Do you want to remove the adoption request?')"> <img src="resources/img/remove-proposal.svg" height="30px">Remove Proposal</a></span>
                    <?php } else if (getAdoptionRequestOutcome($_SESSION['username'], $pet['id']) === 'rejected') { ?>
                        <div id="rejected-proposal">The proposal was rejected 😿 </div>
                        <div id="propose"><a href="add_proposal.php?id=<?= $pet['id'] ?>"> <img src="resources/img/adopt-me.png" height="100px" width="100px"> </a></span>
                    <?php } else if (getAdoptionRequestOutcome($_SESSION['username'], $pet['id']) === 'accepted') { ?>
                        <div id="rejected-proposal">The proposal was accepted! 😺</div>
                    <?php }
                    }
                }
        } else if ($_SESSION['username'] !== $pet['postedBy']) {
            $userWhoAdoptedPet = getUserWhoAdoptedPet($pet['id']); 
            if ($userWhoAdoptedPet['username'] == $_SESSION['username']) { ?>
                        <div id="rejected-proposal">The proposal was accepted! Have fun with your new pet! 😺</div>
            <?php } else { ?>
            <div id="pet-already-adopted">The pet was already adopted by <a href="profile.php?username=<?=$userWhoAdoptedPet['username']?>"><?=$userWhoAdoptedPet['username']?></a> </div>
        <?php } }
    }