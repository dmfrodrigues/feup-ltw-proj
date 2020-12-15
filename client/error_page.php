<?php function error_page(int $code, string $message){ ?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Error</title>
        <link rel="stylesheet" href="<?= PROTOCOL_CLIENT_URL ?>/css/error.css">
        <link rel="shortcut icon" type="image/ico" href="<?= PROTOCOL_CLIENT_URL ?>/resources/favicon.ico">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body> 
        <div id="error"> 
            <h1>😿</h1>
            <h2><?= $code ?></h2>
            <h3><?= $message ?></h3>
            <h4><a href="index.php">Go to home</a></h4>
        </div>
    </body>
</html>
<?php } ?>