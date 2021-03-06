<?php
function viewCollaboratorInShelterProfile(User $collaborator): void {
    $photoUrl = $collaborator->getPictureUrl(); ?>
    <article class="collaborator-card" onclick="location.href = 'user/<?= $collaborator->getUsername() ?>';">
        <div id="collaborator-card-content">
            <img src="<?= $photoUrl ?>">
            <h2><?= $collaborator->getName() ?></h2>
        </div>
    </article>
<?php } ?>
