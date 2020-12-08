<section id="owned">
    <h2>Pets owned</h2>
    <div class="pet-card-grid">
        <?php
        include_once 'view_pet_in_profile.php';
        if(empty($added_pets)) echo '<p>No pets</p>';
        else
            foreach ($added_pets as $pet) {
                viewPetInProfile($pet);
            } ?>
    </div>
</section>
<section id="favorites">
    <h2>Favorites</h2>
    <div class="pet-card-grid">
        <?php
        if(empty($favorite_pets)) echo '<p>No favorite pets</p>';
        else
            foreach ($favorite_pets as $pet) {
                viewPetInProfile($pet);
            } ?>
    </div>
</section>