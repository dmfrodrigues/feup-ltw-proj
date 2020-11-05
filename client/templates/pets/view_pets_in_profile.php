<section id="owned">
    <h2>Pets owned</h2>
    <?php
    if(empty($added_pets)) echo '<p>No pets</p>';
    else
        foreach ($added_pets as $pet) {
            $photoUrl = getPetMainPhoto($pet['id']);
            $intro = explode(PHP_EOL, $pet['description'])[0];
            ?>
            <article class="pet-card" onclick="location.href = 'pet.php?id=<?= $pet['id'] ?>';">
                <div class="pet-card-inner">
                    <div class="pet-card-front">
                        <img src="<?= $photoUrl ?>">
                        <div class="pet-card-content-front">
                            <h2><?= $pet['name'] ?></h2>
                        </div>
                    </div>
                    <div class="pet-card-back">
                        <div class="pet-card-content-back">
                            <p><?= $intro ?></p>
                        </div>
                    </div>
                </div>
            </article>
        <?php } ?>
</section>
<section id="favorites">
    <h2>Favorites</h2>
    <?php
    if(empty($favorite_pets)) echo '<p>No favorite pets</p>';
    else
        foreach ($favorite_pets as $pet) {
            $photoUrl = getPetMainPhoto($pet['id']);
            $intro = explode(PHP_EOL, $pet['description'])[0];
            ?>
            <article class="pet-card" onclick="location.href = 'pet.php?id=<?= $pet['id'] ?>';">
                <div class="pet-card-inner">
                    <div class="pet-card-front">
                        <img src="<?= $photoUrl ?>">
                        <div class="pet-card-content-front">
                            <h2><?= $pet['name'] ?></h2>
                        </div>
                    </div>
                    <div class="pet-card-back">
                        <div class="pet-card-content-back">
                            <p><?= $intro ?></p>
                        </div>
                    </div>
                </div>
            </article>
        <?php } ?>
</section>