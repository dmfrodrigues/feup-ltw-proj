<section id="signup">  
    <header><h2>Sign Up</h2></header>
    <form method="post" action="action_signup.php">
      <label> Name:<br>
      <input type="text" name="name" placeholder="Name" required></label>
      <br>
      <label> User Name:<br>
      <input type="text" name="username" placeholder="Username" required></label>
      <br>
      <label> Password:<br>
      <input type="password" name="pwd" placeholder="Password" required></label>
      <br>
      <label> Repeat Password:<br>
      <input type="password" name="rpt_pwd" placeholder="Password" required></label>
      <br>
      <input type="submit" value="SIGN UP">
    </form>
    <?php
    if(strcmp($_SESSION['messages'][0]['type'], 'error') == 0)
        echo $_SESSION['messages'][0]['content'];
    session_destroy();
    ?>
</section>