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
            <li><a href="add_pet.php">➕ Add pet</a></li>
        </ul>
    </section>
</section>