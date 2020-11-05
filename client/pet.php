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
let comments = <?= json_encode($comments) ?>;
</script>
<?php

$javascript_files = ['js/Comment.js', 'js/commentsTree.js'];

include_once 'templates/common/header.php';
include_once 'templates/pets/view_pet.php';
include_once 'templates/common/footer.php';
