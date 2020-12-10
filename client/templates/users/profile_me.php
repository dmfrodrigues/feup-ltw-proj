<section id="profile">
    <header>
        <img class="profile-pic" id="profile_img" src="<?php echo (is_null($user['pictureUrl']) ? "resources/img/no-image.svg": $user['pictureUrl']) ?>">
        <span id="name"><?=$user['name']?></span>
        <span id="username"><?=$user['username']?></span>
        <a href="edit_profile.php?username=<?=$_SESSION['username']?>">Edit Profile</a>
    </header>
    <?php
    include_once 'templates/pets/view_pets_in_profile.php';
    ?>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><button onclick="location.href = 'add_pet.php'">Add pet</button></li>
            <li><button onclick="location.href = 'view_proposals.php'">Proposals to my pets</button></li>
            <li><button onclick="location.href = 'my_proposals.php'">My proposals</button></li>
            <li><button onclick="location.href = 'view_adopted_pets_by_user.php'">View adopted pets</button></li>
            <li><button onclick="location.href = 'view_previously_owned_pets.php'">View previously owned pets</button></li>
            <?php 
                if(checkUserBelongsToShelter($user['username'])) { 
                    $shelterName = getUserShelter($user['username']); ?>
                    <li><button onclick="location.href = 'profile.php?username=<?=$shelterName?>'">View shelter</button></li>
            <?php } else { ?>
                    <li><button onclick="location.href = 'view_shelter_invitations.php'">View shelter invitations</button></li>
            <?php } ?>
        </ul>
    </section>
</section>