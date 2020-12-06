<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Forever home</title>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/authenticate.css">
        <link rel="stylesheet" href="css/profile.css">
        <link rel="stylesheet" href="css/edit_profile.css">
        <link rel="stylesheet" href="css/pets.css">
        <link rel="stylesheet" href="css/add_pet.css">
        <link rel="stylesheet" href="css/searches.css">
        <link rel="stylesheet" href="css/comments.css">
        <link rel="stylesheet" href="css/proposals.css">
        <link rel="stylesheet" href="css/responsive.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
        <link rel="shortcut icon" type="image/ico" href="resources/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <div id="authenticate">
            <?php if (!isset($_SESSION['username'])) { ?>
                <a href="signup.php">Sign up</a>
                <a href="login.php">Login</a>
            <?php } else { ?>
                <span><a href="profile.php?username=<?=$_SESSION['username']?>"><?=$_SESSION['username']?></a></span>
                <a href="<?= SERVER_URL ?>/actions/logout.php">Logout</a>
            <?php } ?>
            </div>
        </header>
        <div>
