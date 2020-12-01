<?php $added_pets = getAddedPets($_SESSION['username']);
    $adoption_requests = getAdoptionRequests($_SESSION['username']);
    if (checkIfAdopted($pet['id']) === false) {
        if (!in_array($pet, $added_pets)) { 
            if (!userRequestedPet($_SESSION['username'], $pet['id'])) { ?>
                <div id="propose"><a href="add_proposal.php?id=<?= $pet['id'] ?>"> <img src="resources/img/adopt-me.png" height="100px" width="100px"> </a></span>
    <?php } else { 
                if (getAdoptionRequestOutcome($_SESSION['username'], $pet['id']) === 'pending') { ?>
                    <div id="remove-proposal"><a href="<?= SERVER_URL ?>/actions/remove_proposal.php?id=<?= $pet['id'] ?>" onclick="return confirm('Do you want to remove the adoption request?')"> <img src="resources/img/remove-proposal.svg" height="30px">Remove Proposal</a></span>
                <?php } else if (getAdoptionRequestOutcome($_SESSION['username'], $pet['id']) === 'rejected') { ?>
                    <div id="rejected-proposal">The proposal was rejected :( Try make another proposal</div>
                    <div id="propose"><a href="add_proposal.php?id=<?= $pet['id'] ?>"> <img src="resources/img/adopt-me.png" height="100px" width="100px"> </a></span>
                <?php } else if (getAdoptionRequestOutcome($_SESSION['username'], $pet['id']) === 'accepted') { ?>
                    <div id="rejected-proposal">The proposal was accepted! :)</div>
                <?php }
                }
            }
    } else if ($_SESSION['username'] !== $pet['postedBy']) { ?>
        <div id="pet-already-adopted">The pet was already adopted!</div>
    <?php }