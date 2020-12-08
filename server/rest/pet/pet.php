<?php
include_once SERVER_DIR . '/pets.php';

function pet($url) : array {
    $parts = explode('/', $url, 2);
    $id = $parts[0];
    switch(count($parts)){
        case 2:
            $subpath = $parts[1];
            switch($subpath){
                case "comments": return pet_id_comments($id); break;
                default: http_response_code(400); die();
            }
        default: http_response_code(400); die();
    }
}

function pet_id_comments($id) : array {
    if($_SERVER['REQUEST_METHOD'] == 'GET') return getPetComments($id);
    else http_response_code(405); die();
}
