<?php
foreach ($pets as $pet) {
    $intro = explode(PHP_EOL, $pet['description'])[0];
?>
    <article class="pet">
        <header>
            <h1><a href="pet.php?id=<?= $pet['id'] ?>"><?= $pet['name'] ?></a></h1>
        </header>
        <img src="<?= $pet['photoUrl'] ?>" alt="photo of <?= $pet['name'] ?>" />
        <p><?= $intro ?></p>
    </article>
<?php
}
?>