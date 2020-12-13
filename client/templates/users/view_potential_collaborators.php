<section id="potential-collaborators">
    <h2>Potential Collaborators</h2>
    <div class="potential-collaborators-grid">
        <?php
        require_once CLIENT_DIR.'/templates/users/view_collaborator_in_shelter_profile.php';
        if(empty($users)) echo '<p>No users</p>';
        else
            foreach ($users as $user) {
                viewCollaboratorInShelterProfile($user);
            } ?>
    </div>
</section>