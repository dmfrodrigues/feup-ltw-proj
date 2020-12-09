<?php
function editProfile($isShelter) { 
    global $user;
    global $shelter;
    $editUser = null;
    ($isShelter) ? $editUser = $shelter : $editUser = $user;
    ?>
    <article id="edit-profile">
    <header>
        <h1>Edit Profile</h1>
    </header>
    <section id="edit-profile-body">
        <section id="profile-photo">
            <h3>Profile photo</h3>
            <div id="photo">
                <img class="profile-pic" src="<?php echo (is_null($editUser['pictureUrl']) ? "resources/img/no-image.svg": $editUser['pictureUrl']) ?>">
                <details>
                    <summary>
                        <div class="dropdown-main" id="edit">✎ Edit</button>
                    </summary>
                    <div class="dropdown" id="edit-options">
                        <ul>
                            <li>
                                <form action="<?= PROTOCOL_SERVER_URL ?>/actions/edit_profile_picture.php?username=<?= $editUser['username'] ?>" enctype="multipart/form-data" method="POST">
                                    <script>
                                        function onFileChange(){
                                            if(document.getElementById('profile_picture').value != ''){
                                                document.getElementById('submit-file').style.display="";
                                            }
                                        }
                                    </script>
                                    <label>
                                        <span onclick="document.getElementById('profile_picture').click()">Choose new picture</span>
                                        <input type="file" id="profile_picture" name="profile_picture" style="display:none;" onchange="onFileChange()" required>
                                        <input type="submit" id="submit-file" value="Submit" style="display:none">
                                    </label>
                                </form>
                            </li>
                            <li <?php if(is_null($editUser['pictureUrl'])) echo 'class="disabled"';?>>
                                <a href="<?= PROTOCOL_SERVER_URL ?>/actions/erase_profile_picture.php?username=<?= $editUser['username']?>">Erase picture</a>
                            </li>
                        </ul>
                    </div>
                </details>
            </div>
        </section>
        <form action="<?= PROTOCOL_SERVER_URL ?>/actions/edit_profile.php?username=<?=$editUser['username']?>" method="post">
            <?php if ((isset($_SESSION['isShelter']) && isset($_SESSION['username']) && $_SESSION['username'] === $editUser['username']) || ($_SESSION['username'] === $editUser['username'])) { ?>
                <section id="username">
                    <label for="username">Username<input type="text" name="username" placeholder="user's username" value="<?=$editUser['username']?>" required pattern="^[a-zA-Z0-9]+$"></label>
                </section>
            <?php } ?> 
            <section id="name">
                <label for="name">Name<input type="text" name="name" placeholder="user's name" value="<?=$editUser['name']?>" required></label>
            </section>
            <?php if ($isShelter) { ?>
                <section id="description">
                    <label for="description">Description<textarea name="description" placeholder="user's description"><?=$editUser['description']?></textarea></label>
                </section>
                <section id="location">
                    <label for="location">Location<input type="text" name="location" placeholder="user's location" value="<?=$editUser['location']?>" required></label>
                </section>
            <?php } ?>
            <?php if ((isset($_SESSION['isShelter']) && $_SESSION['username'] === $editUser['username']) || ($_SESSION['username'] === $editUser['username'])) { ?>
                <section id="password">
                    <label for="password">Password<a href="change_password.php?username=<?= $editUser['username']?>"><img src="resources/img/edit.svg"></a></label>
                </section>
            <?php } ?> 
            <input type="submit" value="Submit" id="edit-profile-submit">
        </form>
        <section id='delete-user'>
            <a href="<?= PROTOCOL_SERVER_URL ?>/actions/delete_user.php?username=<?= $editUser['username'] ?>" onclick="return confirm('Do you want to delete this account?')">⚠ Delete Account</a>
        </section>
    </section>
</article>
<?php }
