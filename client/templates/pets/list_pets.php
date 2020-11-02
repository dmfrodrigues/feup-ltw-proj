<h1>Pets available for adoption</h1>
<script src="js/filterPets.js"></script>

<article id="searches">
    <input type="text" id="name" onkeyup="filterByAllParameters()" placeholder="Pet name" title="Pet name">
    <input type="text" id="location" onkeyup="filterByAllParameters()" placeholder="Pet location" title="Pet location">
    <input type="text" id="species" onkeyup="filterByAllParameters()" placeholder="Pet species" title="Pet species">
    <input type="number" id="age" onkeyup="filterByAllParameters()" placeholder="Pet age" title="Pet age">
    <input type="text" id="color" onkeyup="filterByAllParameters()" placeholder="Pet color" title="Pet color">
    <input type="text" id="size" onkeyup="filterByAllParameters()" placeholder="Pet size" title="Pet size">
    <input type="text" id="sex" onkeyup="filterByAllParameters()" placeholder="Pet sex" title="Pet sex">
</article>
    
<section id="pet-list">
    <?php
    foreach ($pets as $pet) {
        $intro = explode(PHP_EOL, $pet['description'])[0];
        $photoUrl = getPetMainPhoto($pet['id']);
    ?>
        <article class="pet">
            <header>
                <h2><a href="pet.php?id=<?= $pet['id'] ?>"><?= $pet['name'] ?></a></h2>
            </header>
            <img src="<?= $photoUrl ?>" alt="photo of <?= $pet['name'] ?>" />
            <p><?= $intro ?></p>
            <p id="hidden_location" style="display: none"><?= $pet['location'] ?></p>
            <p id="hidden_species" style="display: none"><?= $pet['species'] ?></p>
            <p id="hidden_age" style="display: none"><?= $pet['age'] ?></p>
            <p id="hidden_color" style="display: none"><?= $pet['color'] ?></p>
            <p id="hidden_size" style="display: none"><?= $pet['size'] ?></p>
            <p id="hidden_sex" style="display: none"><?= $pet['sex'] ?></p>

        </article>
    <?php
    }
    ?>
</section>