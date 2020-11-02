<h1>Pets available for adoption</h1>
<script src="js/filterPets.js"></script>

<article id="searches">
    <input type="text" id="name" onkeyup="filterByAllParameters()" placeholder="Pet name" title="Pet name">
    <input type="text" id="location" onkeyup="filterByAllParameters()" placeholder="Pet location" title="Pet location">
    <!-- <input type="text" id="name" onkeyup="filterByName()" placeholder="Search for names.." title="Pet name"> -->
    

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
            <?php echo $pet['location']; ?>
        </article>
    <?php
    }
    ?>
</section>