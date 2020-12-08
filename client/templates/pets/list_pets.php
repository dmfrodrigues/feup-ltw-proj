
<article id="pets-page">
    <article id="searches">
        <h2>Filter by</h2>
        <section id="body-search" class="body">
            <label>Name<input type="text" id="name" onkeyup="filterByAllParameters()" placeholder="Pet's name" title="Pet name"></label>
            <label>Location<input type="text" id="location" onkeyup="filterByAllParameters()" placeholder="Pet's location" title="Pet location"></label>
            <label>Species<input type="text" id="species" onkeyup="filterByAllParameters()" placeholder="Pet's species" title="Pet species"></label>
            <label>Age<input type="number" id="age" onkeyup="filterByAllParameters()" placeholder="Pet's age" title="Pet age"></label>
            <label>Color<input type="text" id="color" onkeyup="filterByAllParameters()" placeholder="Pet's color" title="Pet color"></label>
            
            <article id="size-area">
                <h3 id="size">Size</h3>
                <section id="body-size-area" class="body">
                    <label class="container"><input type="checkbox" id="size_XS" name="size_XS" value="XS" onClick="filterByAllParameters()">XS</label>
                    <label class="container"><input type="checkbox" id="size_S"  name="size_S"  value="S"  onClick="filterByAllParameters()">S </label>
                    <label class="container"><input type="checkbox" id="size_M"  name="size_M"  value="M"  onClick="filterByAllParameters()">M </label>
                    <label class="container"><input type="checkbox" id="size_L"  name="size_L"  value="L"  onClick="filterByAllParameters()">L </label>
                    <label class="container"><input type="checkbox" id="size_XL" name="size_XL" value="XL" onClick="filterByAllParameters()">XL</label>
                </section>
            </article>

            <article id="sex-area">
                <h3 id="sex">Sex</h3>
                <section id="body-sex-area" class="body">
                    <label class="container"><input type="checkbox" id="male"   name="male"   value="M" onClick="filterByAllParameters()">Male  </label> 
                    <label class="container"><input type="checkbox" id="female" name="female" value="F" onClick="filterByAllParameters()">Female</label>
                </section>
            </article>
        </section>
    </article>
        
    <section id="pet-list">
        <div class="pet-card-grid">
        <?php
        foreach ($pets as $pet) {
            $intro = explode(PHP_EOL, $pet['description'])[0];
            $photoUrl = getPetMainPhoto($pet['id']);
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
        </div>
    </section>
</article>