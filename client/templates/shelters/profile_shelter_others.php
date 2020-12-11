<section id="shelter-profile">
    <header>
        <img class="profile-shelter-pic" id="profile_img" src="<?php echo (is_null($shelter['pictureUrl']) ? "resources/img/no-image.svg": $shelter['pictureUrl']) ?>">
        <span id="name"><?=$shelter['name']?></span>
        <span id="username"><?=$shelter['username']?></span>
        <?php if (!isset($_SESSION['isShelter']) && isset($_SESSION['username'])) {
            $userShelter = getUserShelter($_SESSION['username']);
            if ($userShelter === $shelter['username']) { ?>
                <a href="edit_profile.php?username=<?=$userShelter?>">Edit Shelter Profile</a>
                <button onclick="location.href='<?= PROTOCOL_SERVER_URL ?>/actions/leave_shelter.php?shelter=<?=$shelter['username']?>'" id="leaveShelter">Leave Shelter</button>
            <?php }
        } ?> 
    </header>
    <?php
    require_once 'templates/pets/view_pets_in_shelter_profile.php';
    require_once 'templates/users/view_collaborators_in_shelter_profile.php';
    ?>
</section>