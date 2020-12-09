<section id="shelter-profile">
    <header>
        <img class="profile-shelter-pic" id="profile_img" src="<?php echo (is_null($shelter['pictureUrl']) ? "resources/img/no-image.svg": $shelter['pictureUrl']) ?>">
        <span id="name"><?=$shelter['name']?></span>
        <span id="username"><?=$shelter['username']?></span>
    </header>
    <?php
    include_once 'templates/pets/view_pets_in_shelter_profile.php';
    include_once 'templates/users/view_collaborators_in_shelter_profile.php';
    ?>
</section>