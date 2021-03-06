<section id="profile">
    <header>
        <img class="profile-pic" id="profile_img" src="<?php echo (is_null($user->getPictureUrl()) ? "rest/client/resources/img/no-image.svg": $user->getPictureUrl()) ?>">
        <span id="name"><?=$user->getName()?></span>
        <span id="username"><?=$user->getUsername()?></span>
        <a href="user/<?=$_SESSION['username']?>/edit">Edit Profile</a>
    </header>
    <?php
    require_once CLIENT_DIR.'/templates/pets/view_pets_in_profile.php';
    ?>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><button onclick="location.href = 'pet/new'">Add pet</button></li>
            <li><button onclick="location.href = 'user/<?=$user->getUsername()?>/proposalstome'">Proposals to my pets</button></li>
            <li><button onclick="location.href = 'user/<?=$user->getUsername()?>/myproposals'">My proposals</button></li>
            <li><button onclick="location.href = 'user/<?=$user->getUsername()?>/adopted'">View adopted pets</button></li>
            <li><button onclick="location.href = 'user/<?=$user->getUsername()?>/previouslyOwned'">View previously owned pets</button></li>
            <?php 
                if(checkUserBelongsToShelter($user->getUsername())) { 
                    $shelterName = User::fromDatabase($user->getUsername())->getShelterId(); ?>
                    <li><button onclick="location.href = 'user/<?=$shelterName?>'">View shelter</button></li>
            <?php } else { ?>
                    <li><button onclick="location.href = 'user/<?=$user->getUsername()?>/invitations'">View shelter invitations</button></li>
            <?php } ?>
        </ul>
    </section>
</section>