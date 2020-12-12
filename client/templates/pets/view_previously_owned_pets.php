<section id="previously-owned-pets-profile">
    <h2>Previously Owned Pets</h2>
    <div class="previously-owned-pets-profile-grid" class="pet-card-grid">
        <?php
        require_once 'view_pet_in_profile.php';
        if(empty($previouslyOwnedPets)) echo '<p>No pets added by you were adopted</p>';
        else { 
            foreach ($previouslyOwnedPets as $pet) {
                viewPetInProfile($pet);
            } 
        } ?>
    </div>
</section>