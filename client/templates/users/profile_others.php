<section id="profile">
    <header>
        <img class="profile-pic" id="profile_img" src="<?php echo (is_null($user['pictureUrl']) ? "resources/img/no-image.svg": $user['pictureUrl']) ?>">
        <span id="name"><?=$user['name']?></span>
        <span id="username"><?=$user['username']?></span>
    </header>
    <?php
    include_once 'templates/pets/view_pets_in_profile.php';
    
    $user = getUser($_GET['username']);
    if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) { ?>
        <div id="add-collaborator-proposal">
        <?php if (!checkUserBelongsToShelter($user['username'])) { 
                $outcome = shelterInvitationIsPending($user['username'], $_SESSION['username']);
                if (!$outcome) { ?>
                    <a href="propose_to_collaborate.php?username=<?=$user['username']?>"><h2>Propose to collaborate</h2></a>
                <?php }
                else { ?>
                    <a href="../server/actions/remove_collaboration_proposal.php?username=<?=$user['username']?>"><h2>Remove collaboration proposal</h2></a>
                <?php }
            ?>            
        <?php } else if ($user['shelter'] === $_SESSION['username']) { ?>
            <a href="../server/actions/remove_collaborator.php?username=<?=$user['username']?>"><h2>Remove this collaborator</h2></a>
            <?php } else { ?> 
                        <h2>This user is already associated with another shelter!</h2>
            <?php } ?>
        </div>
    <?php } ?>
</section> 