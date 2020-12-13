<section id="index-body">
    <header>
        <h2>A website where users can list rescue pets for adoption and offer them a forever home .</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam aliquet vitae risus eget iaculis.
            Curabitur leo urna, porta eu malesuada ac, congue at lorem. Vivamus sed nibh sapien. Maecenas at.</p>
    </header>
    <section class="pets-main-page">
        <h1><a href="pets.php">Pets Available for Adoption</a></h1>
        <div>
        <?php
        if(count($petsForAdoption) < 3)
            $selected = array_keys($petsForAdoption);
        else
            $selected = array_rand($petsForAdoption, 3);
        foreach ($selected as $idx) {
            $pet = $petsForAdoption[$idx];
            $intro = explode(PHP_EOL, $pet->getDescription())[0];
            $photoUrl = getPetMainPhoto($pet);
        ?>
        <article class="pet-card" onclick="location.href = 'pet.php?id=<?= $pet->getId() ?>';">
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
        <?php
        }
        ?>
        </div>
    </section>

    <section class="pets-main-page">
        <h1><a href="adopted_pets.php">Recently Adopted Pets</a></h1>
        <?php  
        if(count($petsAdopted) == 0)
            echo '<h3><a href="pets.php">You can be the first to adopt a pet!</a></h3>';
        else{ ?>
        <div>
        <?php
        for($idx=count($petsAdopted)-1; $idx > (count($petsAdopted) - 3); $idx--) {
            $pet = $petsAdopted[$idx];
            $intro = explode(PHP_EOL, $pet->getDescription())[0];
            $photoUrl = getPetMainPhoto($pet);
        ?>
        <article class="pet-card" onclick="location.href = 'pet.php?id=<?= $pet->getId() ?>';">
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
        <?php
        }
        ?>
        <?php
        }
        ?>
        </div>
    </section>
</section>