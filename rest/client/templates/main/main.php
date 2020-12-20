<section id="index-body">
    <header>
        <h2>A website where users can list rescue pets for adoption and offer them a forever home .</h2>
    </header>
    <section class="pets-main-page">
        <h1><a href="pet">Pets Available for Adoption</a></h1>
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
        <?php
        }
        ?>
        </div>
    </section>

    <section class="pets-main-page">
        <h1><a href="pet/adopted">Recently Adopted Pets</a></h1>
        <?php  
        if(count($petsAdopted) == 0)
            echo '<h3><a href="pet">You can be the first to adopt a pet!</a></h3>';
        else{ ?>
        <div>
        <?php
        $_pets = 0;
        for($idx=count($petsAdopted)-1; $idx >= 0 && $_pets < 3; $idx--) {
            $_pets++;
            $pet = $petsAdopted[$idx];
            $intro = explode(PHP_EOL, $pet->getDescription())[0];
            $photoUrl = getPetMainPhoto($pet);
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
        <?php
        }
        ?>
        <?php
        }
        ?>
        </div>
    </section>
</section>