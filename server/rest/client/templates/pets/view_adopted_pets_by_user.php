<section id="adopted-pets-profile">
    <h1 class="secondary-title">Adopted Pets</h2>
    <div class="adopted-pets-profile-grid" class="pet-card-grid">
        <?php
        require_once CLIENT_DIR.'/templates/pets/view_pet_in_profile.php';
        if(empty($adoptedPets)) echo '<p>No adopted pets</p>';
        else { 
            foreach ($adoptedPets as $pet) {
                viewPetInProfile($pet);
            } 
        } ?>
    </div>
</section>