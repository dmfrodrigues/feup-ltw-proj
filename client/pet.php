<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
$pet = getPet($_GET['id']);
$comments = getPetComments($_GET['id']);

?>
<script>
let pet = <?= json_encode($pet) ?>;
let comments = <?= json_encode($comments) ?>;
</script>
<?php

if (isset($_SESSION['username'])) {
    $user = getUser($_SESSION['username']);
?>
    <script>
        let user = <?= json_encode($user) ?>;
    </script>
    <script src="js/handleFavorites.js" defer></script>
<?php
}

$javascript_files = ['js/utils_elements.js', 'js/Comment.js', 'js/CommentTree.js', 'js/petPhotos.js', 'js/commentImage.js'];

include_once 'templates/common/header.php';
include_once 'templates/pets/view_pet.php';
include_once 'templates/common/footer.php';
