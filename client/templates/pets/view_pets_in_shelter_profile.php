<section id="shelter-pets">
    <h2>Shelter Pets</h2>
    <div class="shelter-pets-grid">
        <?php
        include_once 'view_pet_in_profile.php';
        if(empty($shelter_pets)) echo '<p>No pets</p>';
        else
            foreach ($shelter_pets as $pet) {
                viewPetInProfile($pet);
            } ?>
    </div>
</section>