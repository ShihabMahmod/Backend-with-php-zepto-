<?php

require '../config/database.php';
require '../app/Controllers/FontController.php';
require '../app/Controllers/FontGroupController.php';


$fontGroupController = new FontGroupController($db);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'getGroup' && isset($_GET['group_id'])) {
    $groupId = $_GET['group_id'];
    $fontGroupController->getGroup($groupId);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'updateGroup' && isset($_GET['id'])) {
    $groupId = $_GET['id'];
   $fontGroupController->updateGroup($groupId);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['_method']) && $_GET['_method'] == 'DELETE') {
    $fontId = $_GET['id'];
    $fontGroupController->deleteGroup($fontId);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['group_id']) == 0) {
    $fontGroupController->createGroup();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
   
    if ($_GET['action'] == 'listFontGroups') {
        $fontGroupController->listGroups();
    }
}



