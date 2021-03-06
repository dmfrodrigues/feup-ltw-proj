<section id="shelter-profile">
    <header>
        <img class="profile-shelter-pic" id="profile_img" src="<?php echo (is_null($shelter->getPictureUrl()) ? "rest/client/resources/img/no-image.svg": $shelter->getPictureUrl()) ?>">
        <span id="name"><?=$shelter->getName()?></span>
        <span id="username"><?=$shelter->getUsername()?></span>
        <?php if (!isset($_SESSION['isShelter']) && isset($_SESSION['username'])) {
            $userShelter = User::fromDatabase($_SESSION['username'])->getShelterId();
            if ($userShelter === $shelter->getUsername()) { ?>
                <a href="user/<?=$userShelter?>/edit">Edit Shelter Profile</a>
                <button onclick="location.href='actions/leave_shelter.php?csrf=<?=$_SESSION['csrf']?>&shelter=<?=$shelter->getUsername()?>'" id="leaveShelter">Leave Shelter</button>
            <?php }
        } ?> 
    </header>
    <?php
    require_once CLIENT_DIR.'/templates/pets/view_pets_in_shelter_profile.php';
    require_once CLIENT_DIR.'/templates/users/view_collaborators_in_shelter_profile.php';
    ?>
</section>