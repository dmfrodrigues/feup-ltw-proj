<article id="pet">
    <header>
        <?php
        $photoUrl = getPetMainPhoto($pet['id']);
        if($photoUrl == '') $photoUrl = "resources/img/no-image.svg";
        ?>
        <img id="pet-profile-img" src="<?= $photoUrl ?>" alt="photo 1 of <?= $pet['name'] ?>" />
        <div id="data">
            <h1><?= $pet['name'] ?></h1>
            <span id="location"><?= $pet['location'] ?></span>
            <span id="postedBy"><a href="profile.php?username=<?= $pet['postedBy'] ?>"><?= $pet['postedBy'] ?></a></span>
        </div>
        <div id="actions">
            <div id="favorite"><a href="#"><img src="resources/img/heart.svg" height="30px">Add to favorites</a></div>
            <div id="ask"><a href="#comments">Ask question about pet</a></div>
        </div>
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
                if ($pet['age'] >= 1) echo "{$pet['age']} years";
                else                 echo ($pet['age'] * 12) . ' months';
            ?></span>
        </div>
        <div id="sex"><span class="name">Sex</span><span class="value"><?= $pet['sex'] ?></span></div>
        <div id="species"><span class="name">Species</span><span class="value"><?= $pet['species'] ?></span></div>
        <div id="size"><span class="name">Size</span><span class="value"><?= $pet['size'] ?></span></div>
        <div id="color"><span class="name">Color</span><span class="value"><?= $pet['color'] ?></span></div>
    </section>
    <?php if(isset($_SESSION['username']) && $_SESSION['username'] == $pet['postedBy']){ ?>
        <section id="actions">
            <ul>
                <li><a href="edit_pet.php?id=<?= $pet['id'] ?>">Edit</a></li>
            </ul>
        </section>
    <?php } ?>
    <?php
        include_once 'templates/pets/comments.php';
    ?>
</article>
