<section id="adopted-pets">
    <h2>Adopted Pets</h2>
    <?php
    if(empty($adoptedPets)) echo '<p>No adopted pets</p>';
    else
        foreach ($adoptedPets as $pet) {
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