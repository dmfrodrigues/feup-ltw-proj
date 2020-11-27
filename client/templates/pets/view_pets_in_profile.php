<section id="owned">
    <h2>Pets owned</h2>
    <?php
    include_once 'view_pet_in_profile.php';
    if(empty($added_pets)) echo '<p>No pets</p>';
    else
        foreach ($added_pets as $pet) {
            viewPetInProfile($pet);
        } ?>
</section>
<section id="favorites">
    <h2>Favorites</h2>
    <?php
    if(empty($favorite_pets)) echo '<p>No favorite pets</p>';
    else
        foreach ($favorite_pets as $pet) {
            viewPetInProfile($pet);
        } ?>
</section>