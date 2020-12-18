<h1 class="default-title">Shelters</h2>
<section id="shelters">
    <div class="shelters-grid">
        <?php
        include_once 'view_shelter_card.php';
        if(empty($shelters)) echo '<p>No shelters</p>';
        else
            foreach ($shelters as $shelter) {
                viewShelterCard($shelter['username']);
            } ?>
    </div>
</section>