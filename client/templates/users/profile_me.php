<section id="profile">
    <header>
        <img id="profile_img" src="<?=$user['pictureUrl']?>">
        <span id="name"><?=$user['name']?></span>
        <span id="username"><?=$user['username']?></span>
        <a href="edit_profile.php?username=<?=$_SESSION['username']?>">Edit Profile</a>
    </header>
    <section id="owned">
        <h2>Pets owned</h2>
    </section>
    <section id="favorites">
    <h2>Favorites</h2>
    <?php
    foreach ($favorite_pets as $pet_id) {
        $pet = getPet($pet_id);
        $photoUrl = getPetMainPhoto($pet['id']);
        ?>
        <article class="pet">
            <header>
                <h2><a href="pet.php?id=<?= $pet['id']?>"><?= $pet['name'] ?></a></h2>
            </header>
            <img src="<?= $photoUrl ?>" alt="photo of <?= $pet['name'] ?>" />
        </article>
    <?php } ?>
    </section>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><a href="add_pet.php">➕ Add pet</a></li>
        </ul>
    </section>
</section>