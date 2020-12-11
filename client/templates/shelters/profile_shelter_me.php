<section id="shelter-profile">
    <header>
        <img class="profile-shelter-pic" id="profile_img" src="<?php echo (is_null($shelter['pictureUrl']) ? "resources/img/no-image.svg": $shelter['pictureUrl']) ?>">
        <span id="name"><?=$shelter['name']?></span>
        <span id="username"><?=$_SESSION['username']?></span>
        <a href="edit_profile.php?username=<?=$_SESSION['username']?>">Edit Shelter Profile</a>
    </header>
    <?php
    require_once 'templates/pets/view_pets_in_shelter_profile.php';
    require_once 'templates/users/view_collaborators_in_shelter_profile.php';
    ?>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><button onclick="location.href = 'view_potential_collaborators.php'"> Propose a User to be a Collaborator</button></li>
            <li><button onclick="location.href = 'view_my_shelter_invitations.php'"> View Collaboration Invitations</button></li>
        </ul>
    </section>
</section>