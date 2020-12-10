<?php
function viewShelterCard($shelter) {
    $shelter_pic = getUserPicture($shelter); ?>
    <article class="shelter-card" onclick="location.href = 'profile.php?username=<?= $shelter ?>';">
        <div id="shelter-card-content">
            <img src="<?php echo (is_null($shelter_pic) ? "resources/img/no-image.svg" : $shelter_pic)?>">
            <h2><?= $shelter?></h2>
        </div>
    </article>
<?php } ?>