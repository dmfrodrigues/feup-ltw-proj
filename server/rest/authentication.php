<?php

function checkAuthentication() : bool {
    return isset($_SESSION['username']);
}
