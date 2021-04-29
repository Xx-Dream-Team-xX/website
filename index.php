<?php
    define("SERVER_ROOT", __DIR__);
    include_once('./config/settings.php');
    include_once('./utils/router.php');
    include_once('./utils/permissions.php');
    include_once('./utils/logs.php');
    
    $url = $_SERVER["REQUEST_URI"];
    $path = explode("?", $url, 2)[0];
    $path_array = array_slice(explode("/", $path), 1);

    switch ($path_array[0]) {
        case '':
        case 'index.php':
        case 'index.html':
            include_once(PATH["pages"] . "index.php");
            break;
        
        default:
            include_once(PATH["pages"] . "error.php");
            break;
    }
?>