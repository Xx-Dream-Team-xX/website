<?php

    define('SERVER_ROOT', __DIR__);
    include_once './config/settings.php';
    include_once './utils/router.php';
    include_once './utils/session.php';
    include_once './utils/logs.php';

    include_once './utils/data.php';
    include_once './utils/logs.php';

    $_SERVER['logger'] = new Logger(get_path('logs'), Logger::ACCESS);

    $url = $_SERVER['REQUEST_URI'];
    $path = explode('?', $url, 2)[0];
    $path_array = array_slice(explode('/', $path), 1);

    Router::add('', get_path('views', 'mainpage.html')); // Sans regex ni wildcard
    Router::add('/^[0-9]+:[0-9]+$/', get_path('views', 'show.php'), true);

    Router::add('static', get_path('static'), false, 0, $wildcard = true); // Sans regex, avec wildcard

    Router::add('tests', get_path('views', 'tests/'), false, 0, true);

    Router::add('partials', get_path('partials'), false, 0, true);

    Router::add('users', get_path('api', 'user.php'));
    Router::add('contract', get_path('api', 'contract.php'));
    Router::add('auth', get_path('api', 'auth.php'));
    Router::add('account', get_path('api', 'account.php'));
    Router::add('conversation', get_path('api', 'messages.php'));
    Router::add('ticket', get_path('api', 'tickets.php'));
    Router::add('notifications', get_path('api', 'notifications.php'));
    Router::add('verification', get_path('api', 'verification.php'));

    Router::add('messages', get_path('views', "chat.php"));
    Router::add('login', get_path('views', "testlogin.php"));

    Router::default(get_path('views', 'error.php'));

    // try {
        Router::start($path_array);
    // } catch (\Throwable $th) {
    //     send_json($th);
    //     http_response_code(500);
    //     die();
    // }
?>
