<section id="profile">
    <header>
        <img class="profile-pic" id="profile_img" src="<?php echo (is_null($user->getPictureUrl()) ? "resources/img/no-image.svg": $user->getPictureUrl()) ?>">
        <span id="name"><?=$user->getName()?></span>
        <span id="username"><?=$user->getUsername()?></span>
    </header>
    <?php
    require_once 'templates/pets/view_pets_in_profile.php';
    
    $user = User::fromDatabase($_GET['username']);
    if (!isset($_SESSION['isShelter'])) {
        $shelter = getUserShelter($user->getUsername());
        if (!is_null($shelter)) { ?>
            <h2>Associated with shelter <a href="profile.php?username=<?=$shelter?>"><?=$shelter?></a></h2>
        <?php }
    }
    else if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) { ?>
        <div id="add-collaborator-proposal">
        <?php if (!checkUserBelongsToShelter($user->getUsername())) { 
                $outcome = shelterInvitationIsPending($user->getUsername(), $_SESSION['username']);
                if (!$outcome) { ?>
                    <button onclick="location.href = 'propose_to_collaborate.php?username=<?=$user->getUsername()?>'">Propose to collaborate</button>
                <?php }
                else { ?>
                    <button onclick="location.href = '../server/actions/remove_collaboration_proposal.php?username=<?=$user->getUsername()?>'">Remove collaboration proposal</button>
                <?php }
            ?>            
        <?php } else if ($user->getShelter() === $_SESSION['username']) { ?>
            <button onclick="location.href = '../server/actions/remove_collaborator.php?username=<?=$user->getUsername()?>'">Remove this collaborator</button>
            <?php } else { ?> 
                        <h2>This user is already associated with shelter <a href="profile.php?username=<?=$user->getShelter()?>"><?=$user->getShelter()?></a></h2>
            <?php } ?>
        </div>
    <?php } ?>
</section> 