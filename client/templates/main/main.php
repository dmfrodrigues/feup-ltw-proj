<section id="index-body">
    <header>
        <h3>Cat Adoption Checklist Thinking about adopting a cat? Learn what to consider to ensure a peaceful and happy household.</h3>
    </header>
    <section>
        <h3><a href="pets.php">View Pets Listed For Adoption</a></h3>
        <h3><a href="adopted_pets.php">View Adopted Pets</a></h3>
    </section>
    <section>
        <h1>Pets Available for Adoption</h1>
        <section id="pet-list">
        <div class="pet-card-grid">
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

    <section>
        <h1>Recently adopted pets</h1>
        <?php
        if(count($petsAdopted) == 0)
            echo '<h3>You can be the first to adopt a pet!</h3>';
        else
        for($idx=count($petsAdopted); $idx > (count($petsAdopted) - 3); $idx--) {
            $pet = $petsAdopted[$idx-1];
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
    </section>
</section>