<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Forever home</title>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/ico" href="resources/favicon.ico">
        <?php
            if(isset($javascript_files)){
                foreach($javascript_files as $js_file){
                    ?>
                    <script src="<?= $js_file ?>"></script>
                    <?php
                }
            }
        ?>
    </head>
    <body>
        <header>
            <h1><a href="index.php">Forever home</a></h1>
            <div id="signup">
            <?php if (!isset($_SESSION['username'])) { ?>
                <a href="signup.php">Sign up</a>
                <a href="login.php">Login</a>
            <?php } else { ?>
                <span><a href="profile.php?username=<?=$_SESSION['username']?>"><?=$_SESSION['username']?></a></span>
                <a href="action_logout.php">Logout</a>
            <?php } ?>
            </div>
        </header>
