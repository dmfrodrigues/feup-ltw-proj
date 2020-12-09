<section id="shelter-profile">
    <header>
        <img class="profile-shelter-pic" id="profile_img" src="<?php echo (is_null($shelter['pictureUrl']) ? "resources/img/no-image.svg": $shelter['pictureUrl']) ?>">
        <span id="name"><?=$shelter['name']?></span>
        <span id="username"><?=$_SESSION['username']?></span>
        <a href="edit_profile.php?username=<?=$_SESSION['username']?>">Edit Shelter Profile</a>
    </header>
    <?php
    include_once 'templates/pets/view_pets_in_shelter_profile.php';
    include_once 'templates/users/view_collaborators_in_shelter_profile.php';
    ?>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><a href="view_potential_collaborators.php">➕ Propose a User to be a Collaborator</a></li>
            <li><a href="view_my_shelter_invitations.php">➕ View Collaboration Invitations</a></li>
        </ul>
    </section>
</section>