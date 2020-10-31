<h1>Pets available for adoption</h1>
<?php
foreach ($pets as $pet) {
    $intro = explode(PHP_EOL, $pet['description'])[0];
?>
    <article class="pet">
        <header>
            <h2><a href="pet.php?id=<?= $pet['id'] ?>"><?= $pet['name'] ?></a></h2>
        </header>
        <img src="<?= $pet['photoUrl'] ?>" alt="photo of <?= $pet['name'] ?>" />
        <p><?= $intro ?></p>
    </article>
<?php
}
?>