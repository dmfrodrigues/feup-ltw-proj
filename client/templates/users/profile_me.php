<section id="profile">
    <header>
        <img src="<?=$user['pictureUrl']?>">
        <span id="name"><?=$user['name']?></span>
        <span id="username"><?=$user['username']?></span>
    </header>
    <section id="owned">
        <h2>Pets owned</h2>
    </section>
    <section id="favorites">
    <h2>Favorites</h2>
    </section>
    <section id="actions">
        <h2>Actions</h2>
        <ul>
            <li><a href="add_pet.php">➕ Add pet</a></li>
        </ul>
    </section>
</section>