<div id="templates">
    <?php
    require_once CLIENT_DIR.'/templates/pets/comment.php';
    if(isset($user)){
        require_once CLIENT_DIR.'/templates/pets/new_comment.php';
        require_once CLIENT_DIR.'/templates/pets/edit_comment.php';
    }
    ?>
</div>
<article id="pet">
    <header>
        <div id="pet-photos">
            <?php
            $photos = $pet->getPictures();
            if (empty($photos)) $photoSelected = "resources/img/no-image.svg";
            else $photoSelected = $photos[0];
            ?>
            <img id="pet-selected-img" src="<?= $photoSelected ?>" alt="selected photo" />
            <div id=pet-photos-row>
                <img class="selected" src="<?= $photoSelected ?>" alt="photo 0 of <?= $pet->getName() ?>" onclick="selectPhoto()" />
                <?php for ($i = 1; ($i < count($photos) && $i<6); $i++) { ?>
                    <img src="<?= $photos[$i] ?>" alt="photo <?= $i ?> of <?= $pet->getName() ?>" onclick="selectPhoto()" />
                <?php } ?>
                <a href="pet_album.php?id=<?= $pet->getId() ?>">All Photos</a>
            </div>
        </div>
        <div id="data">
            <h1><?= $pet->getName() ?></h1>
            <span id="location"><img src="resources/img/location.png"><span id="location-text"><?= $pet->getLocation() ?></span></span>
            <span id="postedBy"><a href="<?= PROTOCOL_CLIENT_URL ?>/profile.php?username=<?= $pet->getPostedById() ?>"><?= $pet->getPostedById() ?></a></span>
            <?php $shelter = getPetShelter($_GET['id']);
                if (!is_null($shelter)) { ?>
                <section id="shelter">
                    <h2>Associated with shelter <a href="<?= PROTOCOL_CLIENT_URL ?>/profile.php?username=<?= $shelter?>"><?= $shelter?></a></h2>
                </section>
            <?php } ?>
        </div>
        <div id="actions">
            <?php if(isset($_SESSION['username']) && !isset($_SESSION['isShelter'])) {
                $favorite_pets = User::fromDatabase($_SESSION['username'])->getFavoritePets();
                if (in_array($pet, $favorite_pets)) { ?>
                    <button id="favorite" onclick="handleFavorites(this, '<?= $_SESSION['username'] ?>', <?= $_GET['id'] ?>)"><img src="resources/img/anti-heart.svg" height="30px">Remove from favorites</button>
                <?php } else { ?>
                    <button id="favorite" onclick="handleFavorites(this, '<?= $_SESSION['username'] ?>', <?= $_GET['id'] ?>)"><img src="resources/img/heart.svg" height="30px">Add to favorites</button>
                <?php } ?>
                <button id="ask" onclick="location.href = '#comments'"><img src="resources/img/question-mark.png" height="42px">Ask question</button>
                <?php  if($_SESSION['username'] != $pet->getPostedById() ) { ?>
                    <div id="adoption-request-button">
                        <?php require_once CLIENT_DIR.'/templates/pets/adoption_request_buttons.php'; ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </header>
    <section id="description">
        <h2>Description</h2>
        <?php foreach (explode(PHP_EOL, $pet->getDescription()) as $paragraph) { ?>
            <p><?= $paragraph ?></p>
        <?php } ?>
    </section>
    <section id="about">
        <h2>About</h2>
        <div id="age">
            <span class="name">Age</span><span class="value"><?php
                if ($pet->getAge() >= 1) echo "{$pet->getAge()} years";
                else                  echo ($pet->getAge() * 12) . ' months';
                ?></span>
        </div>
        <div id="sex"><span class="name">Sex</span><span class="value"><?= $pet->getSex() ?></span></div>
        <div id="species"><span class="name">Species</span><span class="value"><?= $pet->getSpecies() ?></span></div>
        <div id="size"><span class="name">Size</span><span class="value"><?= $pet->getSize() ?></span></div>
        <div id="color"><span class="name">Color</span><span class="value"><?= $pet->getColor() ?></span></div>
    </section>
    <?php 
    $userWhoAdoptedPet = Pet::fromDatabase($pet->getId())->getAdoptedBy();
    $petAdopted = false;
    if ($userWhoAdoptedPet != null)
        $petAdopted = true;

    $shelter = getPetShelter($_GET['id']);
        
    if(isset($_SESSION['username']) && userCanEditPet($_SESSION['username'],$pet->getId())){ ?>
        <section id="action-edit-pet">
            <ul>
                <li><a href="edit_pet.php?id=<?= $pet->getId() ?>"><img src="resources/img/edit.svg"></a></li>
            </ul>
        </section>
    <?php } ?>
    <?php
    require_once CLIENT_DIR.'/templates/pets/comments.php';
    ?>
</article>
