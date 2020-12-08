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
                $outcome = getShelterInvitation($user['username'], $_SESSION['username']);
                if (is_null($outcome)) { ?>
                    <a href="propose_to_collaborate.php?username=<?=$user['username']?>"><h2>Propose to collaborate</h2></a>
                <?php }
                else if ($outcome === 'pending') { ?>
                    <a href="remove_collaboration_proposal.php?username=<?=$user['username']?>"><h2>Remove collaboration proposal</h2></a>
                <?php }
                else if ($outcome === 'rejected') { ?> 
                    <a href="propose_to_collaborate.php?username=<?=$user['username']?>"><h2>The collaboration proposal was rejected! Try the send another proposal!</h2></a>
                <?php }
                else if ($outcome === 'accepted') { ?> 
                    <a href="propose_to_collaborate.php?username=<?=$user['username']?>"><h2>The collaboration proposal was accepted! <?=$user['username']?> is now in your team!</h2></a>
                <?php        
            ?>            
        <?php } else if ($user['shelter'] == $_SESSION['username']) { ?>
            <a href="remove_collaborator.php?username=<?=$user['username']?>"><h2>Remove this collaborator</h2></a>
            <?php } ?>
        </div>
    <?php } 
    }?>
</section>