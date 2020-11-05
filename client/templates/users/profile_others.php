<?php
$user = getUser($_GET['username']);
?>
<section id="profile-others">
    <header>
        <img class="profile-pic" id="profile_img" src="<?=$user['pictureUrl']?>">
        <span id="name"><?=$user['name']?></span>
        <span id="username"><?=$user['username']?></span>
    </header>
    <?php
    include_once 'templates/pets/view_pets_in_profile.php';
    ?>
</section>