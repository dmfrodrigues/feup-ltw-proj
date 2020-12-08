<section id="adopted-pets-profile">
    <h2>Adopted Pets</h2>
    <div class="adopted-pets-profile-grid" class="pet-card-grid">
        <?php
        include_once 'view_pet_in_profile.php';
        if(empty($adoptedPets)) echo '<p>No adopted pets</p>';
        else { 
            foreach ($adoptedPets as $pet) {
                viewPetInProfile($pet);
            } 
        } ?>
    </div>
</section>