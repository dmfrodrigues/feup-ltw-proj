<section id="pet-list">
    <h1>Pets available for adoption</h1>
    <script src="js/filterPets.js"></script>

    <article id="searches">
        <input type="text" id="name" onkeyup="filterByName()" placeholder="Search for names.." title="Pet name">
        <input type="text" id="location" onkeyup="filterByName()" placeholder="Search for locations.." title="Pet location">
        <!-- <input type="text" id="name" onkeyup="filterByName()" placeholder="Search for names.." title="Pet name"> -->
        
    
    </article>
    

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
        </article>
    <?php
    }
    ?>
</section>


<!-- <script>
function filterByName() {
    let input, filter, pet_element, pet_names_array, pet_name;
    input = document.getElementById("name");
    filter = input.value.toUpperCase();
    
    pet_elements = document.querySelectorAll('article.pet');
    
    for (let i = 0; i < pet_elements.length; i++) {
        pet_name = pet_elements[i].querySelector('header h2 a').innerHTML;

        if (pet_name.toUpperCase().indexOf(filter) > -1) {
            pet_elements[i].style.display = "";
        } 
        else {
            pet_elements[i].style.display = "none";
        }
    }
}
</script> -->