<section id="signup">  
    <header><h2>Sign Up</h2></header>
    <form method="post" onsubmit="return signup_check()" action="action_signup.php">
      <label> Name:<br>
      <input type="text" id="name" name="name" placeholder="Name" required></label>
      <br>
      <label> Username:<br>
      <input type="text" id="username" name="username" placeholder="Username" required pattern="^[a-zA-Z0-9]+$"></label>
      <br>
      <label> Password:<br>
      <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
      <br>
      <label> Repeat Password:<br>
      <input type="password" id="rpt_pwd" placeholder="Password" required></label>
      <br>
      <input type="submit" value="Sign up">
    </form>
    <?php
    if(strcmp($_SESSION['messages'][0]['type'], 'error') == 0)
        echo $_SESSION['messages'][0]['content'];
    session_destroy();
    ?>
</section>