<section id="shelter-collaborators">
    <h2>Shelter Collaborators</h2>
    <div class="shelter-collaborators-grid">
        <?php
        require_once CLIENT_DIR.'/templates/users/view_collaborator_in_shelter_profile.php';
        if(empty($collaborators)) echo '<p class="default-info-text">No collaborators</p>';
        else
            foreach ($collaborators as $collaborator) {
                viewCollaboratorInShelterProfile($collaborator);
            } ?>
    </div>
</section>