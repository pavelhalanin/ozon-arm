<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include "$HOME/config/env.php";
include "$HOME/_class/OzonItemHelper.class.php";

$HOME = $_SERVER['DOCUMENT_ROOT'];

$ozonItemHelper = new OzonItemHelper();
$jsonData = $ozonItemHelper->fetch([
    'limit' => 1000,
]);

header('Content-Type: application/json');
print_r(json_encode($jsonData));
