<?php
function viewShelterCard($shelter) {
    $shelter_pic = User::fromDatabase($shelter)->getPictureUrl(); ?>
    <article class="shelter-card" onclick="location.href = '<?= PROTOCOL_API_URL ?>/user/<?= $shelter ?>';">
        <div id="shelter-card-content">
            <img src="<?php echo (is_null($shelter_pic) ? "resources/img/no-image.svg" : $shelter_pic)?>">
            <h2><?= $shelter?></h2>
        </div>
    </article>
<?php } ?>