<section id="shelter-pets">
    <h2>Shelter Pets</h2>
    <div class="shelter-pets-grid">
        <?php
        require_once CLIENT_DIR.'/templates/pets/view_pet_in_profile.php';
        if(empty($added_pets)) echo '<p>No pets</p>';
        else
            foreach ($added_pets as $pet) {
                viewPetInProfile($pet);
            } ?>
    </div>
</section>