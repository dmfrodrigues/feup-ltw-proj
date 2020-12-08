<?php
$photos = getPetPhotos($pet['id']);
?>
<article id="pet-album">
    <header>
        <a href='pet.php?id=<?= $pet['id'] ?>'><?= $pet['name'] ?></a><span>'s Album</span>
    </header>
    <section>
        <?php for ($i = 0; $i < count($photos); $i++) { ?>
            <img src="<?= $photos[$i] ?>" alt="photo <?= $i ?> of <?= $pet['name'] ?>" />
        <?php } ?>
    </section>
</article>