<section id="shelter-collaborators">
    <h2>Shelter Collaborators</h2>
    <div class="shelter-collaborators-grid">
        <?php
        include_once 'view_collaborator_in_shelter_profile.php';
        if(empty($collaborators)) echo '<p>No collaborators</p>';
        else
            foreach ($collaborators as $collaborator) {
                viewCollaboratorInShelterProfile($pet);
            } ?>
    </div>
</section>