<article id="pet">
    <form action="action_add_pet.php" method="post">
        <header>
            <h1><input type="text" name="name" placeholder="Pet name"></h1>
            <div id="data">
                <span id="location"><input type="text" name="location" placeholder="Location"></span>
            </div>
            <img src="resources/img/no-image.svg" alt="" />
        </header>
        <section id="description">
            <h2>Description</h2>
            <textarea name="description"></textarea>
        </section>
        <section id="about">
            <h2>About</h2>
            <div id="age">
                <span class="name">Age</span>
                <span class="value"><input type="number" name="age" step="any"></span>
            </div>
            <div id="sex">
                <span class="name">Sex </span>
                <span class="value">
                    <select name="sex">
                        <option value="M">M</option>
                        <option value="F">F</option>
                    </select>
                </span>
            </div>
            <div id="species">
                <span class="name">Species</span>
                <span class="value"><input type="text" name="species" placeholder="eg., cat, dog, ..."></span>
            </div>
            <div id="size">
                <span class="name">Size </span>
                <span class="value">
                    <select name="size">
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
                <span class="value"><input type="text" name="color"></span>
            </div>
        </section>
        <input type="submit" value="Submit">
    </form>
</article>