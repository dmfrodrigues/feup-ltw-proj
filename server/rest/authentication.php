<?php

function checkAuthentication(User $user) : bool {
    return isset($_SESSION['username']) && $user->getUsername() == $_SESSION['username'];
}
