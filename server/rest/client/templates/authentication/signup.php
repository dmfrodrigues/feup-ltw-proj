<section id="signup">  
    <header>
      <h2>Sign Up</h2>
      <button id="signup-user-button" class="dark" onclick="switchSignUpForms('user')">User</button>
      <button id="signup-shelter-button" class="dark" onclick="switchSignUpForms('shelter')">Shelters</button> 
    </header>

    <form method="post" onsubmit="return onSubmit_signup(this)">
      <label> Name:
      <input type="text" id="name" name="name" placeholder="Name" required></label>
      <label> Username:
      <input type="text" id="username" name="username" placeholder="Username" required pattern="^[a-zA-Z0-9]+$"></label>
      <label> Email:
      <input type="email" id="email" name="email" placeholder="example@domain.org" required pattern="^.+@.+\..+$"></label>
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
    <script>
      function onSubmit_signup(el){
        if(!signup_check()) return false;
        if(el.querySelector('#shelterName') !== null) return true;
        let username = el.querySelector('#username').value;
        let password = el.querySelector('#pwd'     ).value;
        let email    = el.querySelector('#email'   ).value;
        let name     = el.querySelector('#name'    ).value;
        if (username === "new") {
          location.href = `<?= PROTOCOL_API_URL ?>/user/new?failed=1&errorCode=6`;
          return false;
        } 
        api.put(
          `user`,
          {
            username: username,
            password: password,
            email   : email,
            name    : name
          }
        )
        .then(function (response) {
          if(response.status == 409)
            location.href = `<?= PROTOCOL_API_URL ?>/user/new?failed=1&errorCode=2`;
          if(response.status == 412)
            location.href = `<?= PROTOCOL_API_URL ?>/user/new?failed=1&errorCode=6`;
          else if(response.status != 400)
            location.href = `<?= PROTOCOL_API_URL ?>/user/${username}`;
          else if(!/[\w]+/.test(username))
            location.href = `<?= PROTOCOL_API_URL ?>/user/new?failed=1&errorCode=4`;
          else
            location.href = `<?= PROTOCOL_API_URL ?>/user/new?failed=1&errorCode=5`;
        })
        .catch(function (error) {
          console.error(error);
        });
        return false;
      }
    </script>
</section>
