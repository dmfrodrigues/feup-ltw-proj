<section id="profile">
    <header>
        <img class="profile-pic" id="profile_img" src="<?php echo (is_null($user->getPictureUrl()) ? PROTOCOL_CLIENT_URL."/resources/img/no-image.svg": $user->getPictureUrl()) ?>">
        <span id="name"><?=$user->getName()?></span>
        <span id="username"><?=$user->getUsername()?></span>
    </header>
    <?php
    require_once CLIENT_DIR.'/templates/pets/view_pets_in_profile.php';
    
    if (!isset($_SESSION['isShelter'])) {
        $shelter = User::fromDatabase($user->getUsername())->getShelterId();
        if ($shelter != "") { ?>
            <h2>Associated with shelter <a href="<?= PROTOCOL_API_URL ?>/user/<?=$shelter?>"><?=$shelter?></a></h2>
        <?php }
    }
    else if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) { ?>
        <div id="add-collaborator-proposal">
        <?php if (!checkUserBelongsToShelter($user->getUsername())) { 
                $outcome = shelterInvitationIsPending($user->getUsername(), $_SESSION['username']);
                if (!$outcome) { ?>
                    <button onclick="location.href = '<?= PROTOCOL_API_URL ?>/user/<?= $_SESSION['username'] ?>/propose/<?=$user->getUsername()?>'">Propose to collaborate</button>
                <?php }
                else { ?>
                    <button onclick="location.href = '<?= PROTOCOL_SERVER_URL ?>/actions/remove_collaboration_proposal.php?csrf=<?=$_SESSION['csrf']?>&username=<?=$user->getUsername()?>'">Remove collaboration proposal</button>
                <?php }
            ?>            
        <?php } else if ($user->getShelterId() === $_SESSION['username']) { ?>
            <button onclick="location.href = '<?= PROTOCOL_SERVER_URL ?> /actions/remove_collaborator.php?csrf=<?=$_SESSION['csrf']?>&username=<?=$user->getUsername()?>'">Remove this collaborator</button>
            <?php } else { ?> 
                        <h2>This user is already associated with shelter <a href="<?= PROTOCOL_API_URL ?>/user/<?= $user->getShelterId() ?>"><?= $user->getShelterId() ?></a></h2>
            <?php } ?>
        </div>
    <?php } ?>
</section> 