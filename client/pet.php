<?php

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

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
    <script src="<?= PROTOCOL_CLIENT_URL ?>/js/handleFavorites.js" defer></script>
<?php
}

$javascript_files = [
    PROTOCOL_CLIENT_URL.'/js/utils_elements.js',
    PROTOCOL_CLIENT_URL.'/js/Comment.js',
    PROTOCOL_CLIENT_URL.'/js/CommentTree.js',
    PROTOCOL_CLIENT_URL.'/js/petPhotos.js',
    PROTOCOL_CLIENT_URL.'/js/commentImage.js',
    PROTOCOL_CLIENT_URL.'/js/utils_elements.js'
];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/view_pet.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
