<?php
function viewCollaboratorInShelterProfile($collaborator) {
    $photoUrl = $collaborator['pictureUrl']; ?>
    <article class="collaborator-card" onclick="location.href = 'profile.php?username=<?= $collaborator['user'] ?>';">
        <img src="<?= $photoUrl?>">
        <h2><?= $collaborator['name']?></h2>
    </article>
<?php } ?>
