<section id="profile">
    <header>
        <img class="profile-pic" id="profile_img" src="<?php echo (is_null($user['pictureUrl']) ? "resources/img/no-image.svg": $user['pictureUrl']) ?>">
        <span id="name"><?=$user['name']?></span>
        <span id="username"><?=$user['username']?></span>
    </header>
    <?php
    include_once 'templates/pets/view_pets_in_profile.php';
    
    $user = getUser($_GET['username']);
    if (!isset($_SESSION['isShelter'])) {
        $shelter = getUserShelter($user['username']);
        if (!is_null($shelter)) { ?>
            <h2>Associated with shelter <a href="profile.php?username=<?=$shelter?>"><?=$shelter?></a></h2>
        <?php }
    }
    else if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) { ?>
        <div id="add-collaborator-proposal">
        <?php if (!checkUserBelongsToShelter($user['username'])) { 
                $outcome = shelterInvitationIsPending($user['username'], $_SESSION['username']);
                if (!$outcome) { ?>
                    <button onclick="location.href = 'propose_to_collaborate.php?username=<?=$user['username']?>'">Propose to collaborate</button>
                <?php }
                else { ?>
                    <button onclick="location.href = '../server/actions/remove_collaboration_proposal.php?username=<?=$user['username']?>'">Remove collaboration proposal</button>
                <?php }
            ?>            
        <?php } else if ($user['shelter'] === $_SESSION['username']) { ?>
            <button onclick="location.href = '../server/actions/remove_collaborator.php?username=<?=$user['username']?>'">Remove this collaborator</button>
            <?php } else { ?> 
                        <h2>This user is already associated with shelter <a href="profile.php?username=<?=$user['shelter']?>"><?=$user['shelter']?></a></h2>
            <?php } ?>
        </div>
    <?php } ?>
</section> 