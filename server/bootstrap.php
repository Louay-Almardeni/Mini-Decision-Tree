<?php

require __DIR__ . "/../vendor/autoload.php";

//------------- display errors -------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


const PLAYER = 'player';
const BUILDER = 'builder';
const XML_FILES_FOLDER_NAME = 'XML_files';


foreach (['services/*.php', 'core/*.php'] as $globList) {
    foreach (glob($globList) as $filename) {
        include_once $filename;
    }
}