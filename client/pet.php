<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
$pet = Pet::fromDatabase($_GET['id']);
$comments = $pet->getComments();

$title = $pet->getName();

?>
<script>
let pet = <?= json_encode($pet) ?>;
let comments = <?= json_encode($comments) ?>;
</script>
<?php

if (isset($_SESSION['username'])) {
    $user = User::fromDatabase($_SESSION['username']);
?>
    <script>
        let user = <?= json_encode($user) ?>;
    </script>
    <script src="js/handleFavorites.js" defer></script>
<?php
}

$javascript_files = ['js/utils_elements.js', 'js/Comment.js', 'js/CommentTree.js', 'js/petPhotos.js', 'js/commentImage.js', 'js/utils_elements.js'];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/view_pet.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
