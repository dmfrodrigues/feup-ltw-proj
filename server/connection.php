<?php

include_once __DIR__.'/server.php';

$db = new PDO('sqlite:'.SERVER_DIR.'/database.db');
$db->exec( 'PRAGMA foreign_keys = ON;' );
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
