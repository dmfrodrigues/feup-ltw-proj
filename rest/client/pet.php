<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

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
    <script src="rest/client/js/handleFavorites.js" defer></script>
<?php
}

$javascript_files = [
    'rest/client/js/utils_elements.js',
    'rest/client/js/Comment.js',
    'rest/client/js/CommentTree.js',
    'rest/client/js/petPhotos.js',
    'rest/client/js/commentImage.js',
    'rest/client/js/utils_elements.js'
];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/view_pet.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
