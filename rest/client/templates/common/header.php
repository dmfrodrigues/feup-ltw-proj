<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title><?php if(isset($title)) echo ($title . ' | ')?>Forever Home</title>    
        <meta charset="UTF-8">
        <meta name="csrf-token" content="<?=$CSRFtoken?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?= SERVER_URL_PATH ?>/">
        <link rel="stylesheet" href="rest/client/css/docs.css">
        <link rel="stylesheet" href="rest/client/css/main.css">
        <link rel="stylesheet" href="rest/client/css/button.css">
        <link rel="stylesheet" href="rest/client/css/authenticate.css">
        <link rel="stylesheet" href="rest/client/css/profile.css">
        <link rel="stylesheet" href="rest/client/css/edit_profile.css">
        <link rel="stylesheet" href="rest/client/css/pets.css">
        <link rel="stylesheet" href="rest/client/css/add_pet.css">
        <link rel="stylesheet" href="rest/client/css/searches.css">
        <link rel="stylesheet" href="rest/client/css/comments.css">
        <link rel="stylesheet" href="rest/client/css/proposals.css">
        <link rel="stylesheet" href="rest/client/css/shelter.css">
        <link rel="stylesheet" href="rest/client/css/nav_bar.css">
        <link rel="stylesheet" href="rest/client/css/messages.css">
        <link rel="stylesheet" href="rest/client/css/index.css">
        <link rel="stylesheet" href="rest/client/css/responsive.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
        <link rel="shortcut icon" type="image/ico" href="rest/client/resources/favicon.ico">
        <script src="rest/client/js/rest.js"></script>
        <script>
            var api = new RestApi("<?= SERVER_URL_PATH ?>");
        </script>
        <?php
            if(isset($javascript_files)){
                foreach($javascript_files as $js_file){
                    ?>
                    <script src="<?= $js_file ?>" defer></script>
                    <?php
                }
            }
        ?>
    </head>
    <body>
        <header>
            <h1><a href="">Forever home</a></h1>
            <div id="authenticate">
            <?php if (!isset($_SESSION['username'])) { ?>
                <a href="user/new">Sign up</a>
                <a href="login">Login</a>
            <?php }  else {
                    if (userHasUnreadNotifications($_SESSION['username'])) { ?>
                        <a href="user/<?=$_SESSION['username']?>/notifications"><img src="rest/client/resources/img/new_notifications.svg" ></a>
                    <?php } else { ?>
                        <a href="user/<?=$_SESSION['username']?>/notifications"><img src="rest/client/resources/img/no_notifications.svg" ></a>
                    <?php } ?> 
                    <span><a href="user/<?=$_SESSION['username']?>"><?=$_SESSION['username']?></a></span>
                
                <a href="actions/logout.php">Logout</a>
            <?php } ?>
            </div>
        </header>
        <nav id="nav-bar">
                <input type="checkbox" id="nav-hamburger"> 
                <label class="hamburger" for="nav-hamburger"></label>
                <ul>
                    <li><a <?php if(isset($title) && $title=="Pets") echo "class='nav-selected'" ?> href="pet">Pets Listed for Adoption</a></li>
                    <li><a <?php if(isset($title) && $title=="Adopted pets") echo "class='nav-selected'" ?> href="pet/adopted">Adopted Pets</a></li>
                    <li><a <?php if(isset($title) && $title=="Shelters") echo "class='nav-selected'" ?> href="shelter">View Shelters</a></li>
                </ul>
        </nav>
        <main>
