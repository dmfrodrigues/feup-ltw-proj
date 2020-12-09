<section id="signup">  
    <header>
      <h2>Sign Up</h2>
      <button id="signup-user-button" class="dark" onclick="switchSignUpForms('user')">User</button>
      <button id="signup-shelter-button" class="dark" onclick="switchSignUpForms('shelter')">Shelters</button> 
    </header>

    <form method="post" onsubmit="return signup_check()" action="<?= PROTOCOL_SERVER_URL ?>/actions/signup.php">
      <label> Name:
      <input type="text" id="name" name="name" placeholder="Name" required></label>
      <label> Username:
      <input type="text" id="username" name="username" placeholder="Username" required pattern="^[a-zA-Z0-9]+$"></label>
      <label> Password:
      <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
      <label> Repeat Password:
      <input type="password" id="rpt_pwd" placeholder="Password" required></label>
      <?php 
            if(isset($_GET['failed']) && isset($_GET['errorCode'])) { ?>
            <p id="simple-fail-msg">Signup Failed! - <?= $errorsArray[$_GET['errorCode']] ?></p>
      <?php } ?>
          
      <input type="submit" class="dark" value="Sign up" id="submit-signup">
    </form>
</section>
