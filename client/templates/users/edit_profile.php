<article id="edit-profile">
    <header>
        <h1>Edit Profile</h1>
    </header>
    <section id="profile-photo">
        <h3>Profile photo</h3>
        <div id="photo">
            <img class="profile-pic" src="<?=$user['pictureUrl']?>">
            <details>
                <summary>
                    <div class="dropdown-main" id="edit">✎ Edit</button>
                </summary>
                <div class="dropdown" id="edit-options">
                    <ul>
                        <li>
                            <form action="action_edit_profile_picture.php?username=<?= $user['username'] ?>" enctype="multipart/form-data" method="POST">
                                <script>
                                    function onFileChange(){
                                        if(document.getElementById('profile_picture').value != ''){
                                            document.getElementById('submit-file').style.display="";
                                        }
                                    }
                                </script>
                                <label>
                                    <span onclick="document.getElementById('profile_picture').click()">Choose new picture</span>
                                    <input type="file" id="profile_picture" name="profile_picture" style="display:none;" onchange="onFileChange()">
                                    <input type="submit" id="submit-file" value="Submit" style="display:none">
                                </label>
                            </form>
                        </li>
                        <li>Erase picture</li>
                    </ul>
                </div>
            </details>
        </div>
    </section>
    <form action="action_edit_profile.php?username=<?=$user['username']?>" method="post">
        <section id="name">
            <h3>Name</h3>
            <input type="text" name="name" placeholder="user's name" value="<?=$user['name']?>">
        </section>
        <section id="password">
            <h3>Change password</h3>
            <a href="change_password.php?username=<?= $user['username']?>"><h1>✎</h1></br></a>
        </section>
        <input type="submit" value="Submit">
    </form>
</article>