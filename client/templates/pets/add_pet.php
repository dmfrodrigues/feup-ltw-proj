<article id="add-pet">
    <header>
        <h1>Information about the new pet</h1>
    </header>
    <form action="<?= PROTOCOL_SERVER_URL ?>/actions/add_pet.php" method="post" enctype="multipart/form-data">
        <div class="pets-name">
            <label for="pets-name">Name<input type="text" name="name" placeholder="Pet's name" required></label>
        </div>
        <div class="pets-location">
            <label for="pets-location">Location<input type="text" name="location" placeholder="Pet's location" required></label>
        </div>
        <div class="pets-photos">
            <a id="add-photo" onclick="addPetPhoto(this.parentNode)"><img src="<?= PROTOCOL_CLIENT_URL ?>/resources/img/upload_image.png"></a>
            <div id="pet-photos-inputs">
                <input id="photo-number" name="photo-number" type="hidden" value="0">
            </div>
            <div id=pet-photos-row>
            </div>
        </div>
        <div class="pets-description">
            <label for="pets-description">Description<textarea name="description" placeholder="Pet's description"></textarea></label>
        </div>
        <div id="age">
            <label for="age">Age<span class="value"><input type="number" name="age" step="any" min="0" placeholder="Pet's age" required></span></label>
        </div>
        <div id="sex">
            <label for="sex">Sex
            <span class="value">
                <select name="sex">
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </span></label>
        </div>
        <div id="species">
            <label for="species">Species
            <span class="value"><input type="text" name="species" placeholder="Pet's species" required></span>
        </div></label>
        <div id="size">
            <label for="size">Size
            <span class="value">
                <select name="size">
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </span></label>
        </div>
        <div id="color">
            <label for="color">Color
            <span class="value"><input type="text" name="color" placeholder="Pet's color" required></span>
        </div></label>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Submit" id="add-pet-submit">
    </form>
</article>