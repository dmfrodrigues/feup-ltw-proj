<?php
$photos = $pet->getPictures();
?>
<article id="edit-pet">
    <form action="<?= PROTOCOL_SERVER_URL ?>/actions/edit_pet.php?id=<?= $pet->getId() ?>" method="post" enctype="multipart/form-data">
        <header>
            <input type="text" name="name" placeholder="Pet name" value="<?=$pet->getName()?>" required>
            <div id="data">
                <span id="location"><img src="<?= PROTOCOL_CLIENT_URL ?>/resources/img/location.png"><input type="text" name="location" placeholder="Location" value="<?=$pet->getLocation()?>" required></span>
            </div>
            <div id="pet-photos">
                <a id="add-photo" onclick="addPetPhoto(this.parentNode)"> ➕ Add photo</a>
                <div id="pet-photos-inputs">
                    <input id="photo-number" name="photo-number" type="hidden" value="<?= count($photos) ?>">
                    <?php for ($i = 0; $i < count($photos); $i++) { ?>
                        <input id="old-<?= $i ?>" name="old-<?= $i ?>" value="<?= $i ?>" type="hidden"/>
                        <input id="new-<?= $i ?>" name="new-<?= $i ?>" value="" type="file" style="display: none" onchange="updatePetPhoto(this)"/>
                    <?php } ?>
                </div>
                <div id=pet-photos-row>
                    <?php for ($i = 0; $i < count($photos); $i++) { ?>
                        <div id="picture-<?= $i ?>">
                            <img id="img-<?= $i ?>" src="<?= $photos[$i] ?>"/>
                            <a onclick="browsePetPhoto(this)">Browse new picture</a>
                            <a onclick="deletePetPhoto(this)">Delete</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </header>
        <section id="description">
            <h2>Description</h2>
            <textarea name="description" required><?=$pet->getDescription()?></textarea>
        </section>
        <section id="about">
            <h2>About</h2>
            <div id="age">
                <span class="name">Age</span>
                <span class="value"><input type="number" name="age" min="0" step="any" value="<?=$pet->getAge()?>" required></span>
            </div>
            <div id="sex">
                <span class="name">Sex </span>
                <span class="value">
                    <select name="sex" value="<?=$pet->getSex()?>">
                        <option value="M">M</option>
                        <option value="F">F</option>
                    </select>
                </span>
            </div>
            <div id="species">
                <span class="name">Species</span>
                <span class="value"><input type="text" name="species" placeholder="eg., cat, dog, ..." value="<?=$pet->getSpecies()?>" required></span>
            </div>
            <div id="size">
                <span class="name">Size </span>
                <span class="value">
                    <select name="size" value="<?=$pet->getSize()?>">
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </span>
            </div>
            <div id="color">
                <span class="name">Color </span>
                <span class="value"><input type="text" name="color" value="<?=$pet->getColor()?>" required></span>
            </div>
        </section>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Submit" id="submit-edit-pet">
    </form>
    <div id="delete-pet">
    <a href="<?= PROTOCOL_SERVER_URL ?>/actions/delete_pet.php?csrf=<?=$_SESSION['csrf']?>&id=<?= $pet->getId() ?>" onclick="return confirm('Do you want to remove this pet?')">Remove Pet</a>
    </div>
</article>