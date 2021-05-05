<?php

    session_start();

    define('SERVER_ROOT', __DIR__);
    include_once './config/settings.php';
    include_once './utils/router.php';
    include_once './utils/permissions.php';
    include_once './utils/logs.php';

    include_once './utils/data.php';
    include_once './utils/logs.php';

    $_SERVER["logger"] = new Logger(get_path("logs"), Logger::ADMIN);
    
    $_SERVER["logger"]->log(5, "coucou");

    $url = $_SERVER['REQUEST_URI'];
    $path = explode('?', $url, 2)[0];
    $path_array = array_slice(explode('/', $path), 1);

    Router::add('', get_path('views', 'index.php')); // Sans regex ni wildcard
    Router::add('/^[0-9]+:[0-9]+$/', get_path('views', 'show.php'), true);

    Router::add('static', PATH['static'], false, 0, $wildcard = true); // Sans regex, avec wildcard

    Router::add('testDB', get_path('views', 'tests/testDB.php'));
    Router::add('testLogs', get_path('views', 'tests/testLogs.php'));

    Router::default(get_path('views', 'error.php'));
    Router::start($path_array);
?>
