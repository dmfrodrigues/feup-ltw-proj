<h1>Pets available for adoption</h1>
<article id="searches">
    <input type="text" id="name" onkeyup="filterByAllParameters()" placeholder="Pet name" title="Pet name">
    <input type="text" id="location" onkeyup="filterByAllParameters()" placeholder="Pet location" title="Pet location">
    <input type="text" id="species" onkeyup="filterByAllParameters()" placeholder="Pet species" title="Pet species">
    <input type="number" id="age" onkeyup="filterByAllParameters()" placeholder="Pet age" title="Pet age">
    <input type="text" id="color" onkeyup="filterByAllParameters()" placeholder="Pet color" title="Pet color">
    
    <p id="size">Size</p>
    <input type="checkbox" id="size_XS" name="size_XS" value="XS" onClick="filterByAllParameters()">
    <label for="size_XS">XS</label>
    <input type="checkbox" id="size_S" name="size_S" value="S" onClick="filterByAllParameters()">
    <label for="size_S">S</label>
    <input type="checkbox" id="size_M" name="size_M" value="M" onClick="filterByAllParameters()">
    <label for="size_M">M</label>
    <input type="checkbox" id="size_L" name="size_L" value="L" onClick="filterByAllParameters()">
    <label for="size_L">L</label>
    <input type="checkbox" id="size_XL" name="size_XL" value="XL" onClick="filterByAllParameters()">
    <label for="size_XL">XL</label>

    <p id="sex">Sex</p>
    <input type="checkbox" id="male" name="male" value="M" onClick="filterByAllParameters()">
    <label for="male">Male</label> 
    <input type="checkbox" id="female" name="female" value="F" onClick="filterByAllParameters()">
    <label for="female">Female</label>
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