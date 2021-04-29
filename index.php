<?php
    session_start();

    define("SERVER_ROOT", __DIR__);
    include_once('./config/settings.php');
    include_once('./utils/router.php');
    include_once('./utils/permissions.php');
    include_once('./utils/logs.php');
    
    $url = $_SERVER["REQUEST_URI"];
    $path = explode("?", $url, 2)[0];
    $path_array = array_slice(explode("/", $path), 1);

    Router::add("", PATH["views"] . "index.php"); // Sans regex ni wildcard

    Router::add("static", PATH["static"], false, 0, $wildcard = true); // Sans regex, avec wildcard

    Router::add('/a/', PATH["views"] . 'coucou.php', true); // Avec regex, sans wildcard

    Router::default(PATH["views"] . "error.php");
    Router::start($path_array);
?>