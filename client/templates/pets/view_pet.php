<article id="pet">
    <header>
        <h1><?= $pet['name'] ?></h1>
        <div id="data">
            <span id="location"><?= $pet['location'] ?></span>
            <span id="postedBy"><a href="profile.php?id=<?= $pet['postedBy'] ?>"><?= $pet['postedBy'] ?></a></span>
        </div>
        <?php
        $photoUrl = getPetMainPhoto($pet['id']);
        ?>
        <img src="<?= $photoUrl ?>" alt="photo 1 of <?= $pet['name'] ?>" />
    </header>
    <section id="description">
        <h2>Description</h2>
        <?php foreach (explode(PHP_EOL, $pet['description']) as $paragraph) { ?>
            <p><?= $paragraph ?></p>
        <?php } ?>
    </section>
    <section id="about">
        <h2>About</h2>
        <div id="age">
            <span class="name">Age</span><span class="value"><?php
                if ($pet['age'] >= 1) echo $pet['age'] . " years";
                else                 echo ($pet['age'] * 12) . " months";
            ?></span>
        </div>
        <div id="sex"><span class="name">Sex</span><span class="value"><?= $pet['sex'] ?></span></div>
        <div id="species"><span class="name">Species</span><span class="value"><?= $pet['species'] ?></span></div>
        <div id="size"><span class="name">Size</span><span class="value"><?= $pet['size'] ?></span></div>
        <div id="color"><span class="name">Color</span><span class="value"><?= $pet['color'] ?></span></div>
    </section>
    <?php if($_SESSION['username'] == $pet['postedBy']){ ?>
        <section id="actions">
            <ul>
                <li><a href="edit_pet.php?id=<?= $pet['id'] ?>">Edit</a></li>
            </ul>
        </section>
    <?php } ?>
    <section id="comments">
        <h2>Comments</h2>
    </section>
</article>