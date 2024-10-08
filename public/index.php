<?php

require '../config/database.php';
require '../app/Controllers/FontController.php';

$fontController = new FontController($db);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['_method']) && $_GET['_method'] == 'DELETE') {
    $fontId = $_GET['id'];
    $fontController->delete($fontId);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['font'])) {
    $fontController->uploadFont();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] == 'listFonts') {
        $fontController->listFonts();
    }
}



