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
            if (empty($photos)) $photoSelected = "rest/client/resources/img/no-image.svg";
            else $photoSelected = $photos[0];
            ?>
            <img id="pet-selected-img" src="<?= $photoSelected ?>" alt="selected photo" />
            <div id=pet-photos-row>
                <img class="selected" src="<?= $photoSelected ?>" alt="photo 0 of <?= $pet->getName() ?>" onclick="selectPhoto()" />
                <?php for ($i = 1; ($i < count($photos) && $i<6); $i++) { ?>
                    <img src="<?= $photos[$i] ?>" alt="photo <?= $i ?> of <?= $pet->getName() ?>" onclick="selectPhoto()" />
                <?php } ?>
                <a href="pet/<?= $pet->getId() ?>/photo">All Photos</a>
            </div>
        </div>
        <div id="data">
            <h1><?= $pet->getName() ?></h1>
            <span id="location"><img src="rest/client/resources/img/location.png"><span id="location-text"><?= $pet->getLocation() ?></span></span>
            <span id="postedBy"><a href="user/<?= $pet->getPostedById() ?>"><?= $pet->getPostedById() ?></a></span>
            <?php $shelter = getPetShelter($pet->getId());
                if ($shelter != "") { ?>
                <section id="shelter">
                    <h2>Associated with shelter <a href="user/<?= $shelter?>"><?= $shelter?></a></h2>
                </section>
            <?php } ?>
        </div>
        <div id="actions">
            <?php if(isset($_SESSION['username']) && !isset($_SESSION['isShelter'])) {
                $favorite_pets = User::fromDatabase($_SESSION['username'])->getFavoritePets(); 
                $petLink = "<a href='pet/{$pet->getId()}'>{$pet->getName()}</a>";
                $userLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";
                ?>
                <input type="hidden" name="petOwner" value="<?=$pet->getPostedById()?>"> 
                <input type="hidden" name="petName" value="<?=$petLink?>">
                <input type="hidden" name="userLink" value="<?=$userLink?>">
                <?php
                if (in_array($pet, $favorite_pets)) { ?>
                    <button id="favorite" onclick="handleFavorites(this, '<?= $_SESSION['username'] ?>', <?= $pet->getId() ?>)"><img src="rest/client/resources/img/anti-heart.svg" height="30px">Remove from favorites</button>
                <?php } else { ?>
                    <button id="favorite" onclick="handleFavorites(this, '<?= $_SESSION['username'] ?>', <?= $pet->getId() ?>)"><img src="rest/client/resources/img/heart.svg" height="30px">Add to favorites</button>
                <?php } ?>
                <button id="ask" onclick="location.href = '#comments'"><img src="rest/client/resources/img/question-mark.png" height="42px">Ask question</button>
                <?php  if($_SESSION['username'] != $pet->getPostedById() ) { ?>
                    <div id="adoption-request-button">
                        <?php require_once CLIENT_DIR.'/templates/pets/adoption_request_buttons.php'; ?>
                    </div>
                <?php } 

                    $userWhoAdoptedPet = Pet::fromDatabase($pet->getId())->getAdoptedBy();
                    $petAdopted = false;
                    if ($userWhoAdoptedPet != null)
                        $petAdopted = true;

                    if (!$petAdopted && $pet->getPostedById() === $_SESSION['username']) { ?>
                        <section id="view-pet-proposals">
                            <ul>
                                <li><a href="pet/<?= $pet->getId() ?>/proposals">View Pet Proposals</a></li>
                            </ul>
                        </section>
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
    
    $isAuthorized = Authorization\check(
        Authorization\Resource::PET,
        Authorization\Method::EDIT,
        $auth,
        $pet
    );
    if(isset($_SESSION['username']) && $isAuthorized){ ?>
        <section id="action-edit-pet">
            <ul>
                <li><a href="pet/<?= $pet->getId() ?>/edit"><img src="rest/client/resources/img/edit.svg"></a></li>
            </ul>
        </section>
    <?php }
    require_once CLIENT_DIR.'/templates/pets/comments.php';
    ?>
</article>
