<?php
function editProfile($isShelter): void { 
    global $user;
    global $shelter;
    $editUser = null;
    $editUser = ($isShelter ? $shelter : $user);
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
                                <form id="edit-user-photo" enctype="multipart/form-data" method="PUT">
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
                                <a onclick="deleteUserPhoto_submitForm(this)">Erase picture</a>
                            </li>
                        </ul>
                    </div>
                </details>
            </div>
        </section>
        <form action="<?= PROTOCOL_SERVER_URL ?>/actions/edit_profile.php?username=<?=$editUser['username']?>" method="post">
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $editUser['username']) { ?>
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
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $editUser['username']) { ?>
                <section id="password">
                    <label for="password">Password<a href="change_password.php?username=<?= $editUser['username']?>"><img src="resources/img/edit.svg"></a></label>
                </section>
            <?php } ?> 
            <input type="submit" value="Submit" id="edit-profile-submit">
        </form>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $editUser['username']) { ?>
            <section id='delete-user'>
                <a href="<?= PROTOCOL_SERVER_URL ?>/actions/delete_user.php?username=<?= $editUser['username'] ?>" onclick="return confirm('Do you want to delete this account?')">⚠ Delete Account</a>
            </section>
        <?php } ?> 
    </section>
</article>
<script defer>
    api = new RestApi(API_URL);

    function editUserPhoto_submitForm(editUserPhotoForm){
        let files = editUserPhotoForm.querySelector("#profile_picture").files;
        let picture = (files.length <= 0 ? null : files[0]);

        if(picture != null){
            api.put("user/<?= $editUser['username'] ?>/photo", picture)
            .then((response) => response.json())
            .then(function(response){
                window.location.reload(true);
            });
        }
    }

    function editUserPhoto_onSubmit(e){
        e.preventDefault();
        editUserPhotoForm = e.target;
        editUserPhoto_submitForm(editUserPhotoForm);
    }

    document.querySelector('#edit-user-photo').addEventListener('submit', (e) => { editUserPhoto_onSubmit(e); })

    function deleteUserPhoto_submitForm(deleteUserPhotoForm){
        api.delete("user/<?= $editUser['username'] ?>/photo")
        .then(function(){
            window.location.reload(true);
        })
        .catch(function (error){
            console.error(error);
        });
    }
</script>
<?php } ?>
