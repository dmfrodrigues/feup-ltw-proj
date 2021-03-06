<?php
function viewPetInProfile(Pet $pet) : void {
    $photoUrl = getPetMainPhoto($pet);
    $intro = explode(PHP_EOL, $pet->getDescription())[0];
    ?>
    <article class="pet-card" onclick="location.href = 'pet/<?= $pet->getId() ?>';">
        <div class="pet-card-inner">
            <div class="pet-card-front">
                <img src="<?= $photoUrl ?>">
                <div class="pet-card-content-front">
                    <h2><?= $pet->getName() ?></h2>
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
