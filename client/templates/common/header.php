<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title><?php if(isset($title)) echo ($title . ' | ')?>Forever Home</title>    
        <meta charset="UTF-8">
        <meta name="csrf-token" content="<?=$CSRFtoken?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/main.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/button.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/authenticate.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/profile.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/edit_profile.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/pets.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/add_pet.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/searches.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/comments.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/proposals.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/shelter.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/nav_bar.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/messages.css">
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/responsive.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
        <link rel="shortcut icon" type="image/ico" href="<?= PROTOCOL_CLIENT_URL ?>/resources/favicon.ico">
        <script>
            const API_URL = `<?= PROTOCOL_SERVER_URL ?>/rest/`;
            const PROTOCOL_SERVER_URL = "<?= PROTOCOL_SERVER_URL ?>";
            const PROTOCOL_CLIENT_URL = "<?= PROTOCOL_CLIENT_URL ?>";
        </script>
        <script src="<?= PROTOCOL_CLIENT_URL ?>/js/rest.js"></script>
        <script>
            var api = new RestApi(API_URL);
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
            <h1><a href="<?= PROTOCOL_CLIENT_URL ?>/index.php">Forever home</a></h1>
            <div id="authenticate">
            <?php if (!isset($_SESSION['username'])) { ?>
                <a href="<?= PROTOCOL_CLIENT_URL ?>/signup.php">Sign up</a>
                <a href="<?= PROTOCOL_API_URL ?>/login">Login</a>
            <?php }  else {
                    if (userHasUnreadNotifications($_SESSION['username'])) { ?>
                        <a href="<?= PROTOCOL_CLIENT_URL ?>/notifications.php?username=<?=$_SESSION['username']?>"><img src="resources/img/new_notifications.svg" ></a>
                    <?php } else { ?>
                        <a href="<?= PROTOCOL_CLIENT_URL ?>/notifications.php?username=<?=$_SESSION['username']?>"><img src="resources/img/no_notifications.svg" ></a>
                    <?php } ?> 
                    <span><a href="<?= PROTOCOL_CLIENT_URL ?>/profile.php?username=<?=$_SESSION['username']?>"><?=$_SESSION['username']?></a></span>
                
                <a href="<?= PROTOCOL_SERVER_URL ?>/actions/logout.php">Logout</a>
            <?php } ?>
            </div>
        </header>
        <nav id="nav-bar">
                <input type="checkbox" id="nav-hamburger"> 
                <label class="hamburger" for="nav-hamburger"></label>
                <ul>
                    <li><a href="<?= PROTOCOL_CLIENT_URL ?>/pets.php">Pets Listed for Adoption</a></li>
                    <li><a href="<?= PROTOCOL_CLIENT_URL ?>/adopted_pets.php">Adopted Pets</a></li>
                    <li><a href="<?= PROTOCOL_CLIENT_URL ?>/view_shelters.php">View Shelters</a></li>
                </ul>
        </nav>
        <main>
