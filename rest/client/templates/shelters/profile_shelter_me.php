<section id="shelter-profile">
    <header>
        <img class="profile-shelter-pic" id="profile_img" src="<?php echo (is_null($shelter->getPictureUrl()) ? "rest/client/resources/img/no-image.svg": $shelter->getPictureUrl()) ?>">
        <span id="name"><?=$shelter->getName()?></span>
        <span id="username"><?=$_SESSION['username']?></span>
        <a href="user/<?=$_SESSION['username']?>/edit">Edit Shelter Profile</a>
    </header>
    <?php
    require_once CLIENT_DIR.'/templates/pets/view_pets_in_shelter_profile.php';
    require_once CLIENT_DIR.'/templates/users/view_collaborators_in_shelter_profile.php';
    ?>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><button onclick="location.href = 'shelter/<?= $_SESSION['username'] ?>/potential'"> Propose a User to be a Collaborator</button></li>
            <li><button onclick="location.href = 'shelter/<?=$shelter->getUsername()?>/invitations'"> View Collaboration Invitations</button></li>
        </ul>
    </section>
</section>