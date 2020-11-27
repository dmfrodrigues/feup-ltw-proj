<section id="adopted-pets">
    <h2>Adopted Pets</h2>
    <?php
    include_once 'view_pet_in_profile.php';
    if(empty($adoptedPets)) echo '<p>No adopted pets</p>';
    else
        foreach ($adoptedPets as $pet) {
            viewPetInProfile($pet);
        } ?>
</section>