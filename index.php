<?php

    define('SERVER_ROOT', __DIR__);
    include_once './config/settings.php';
    include_once './utils/router.php';
    include_once './utils/session.php';

    include_once './utils/data.php';
    include_once './utils/logs.php';

    $_SERVER['logger'] = new Logger(get_path('logs'), SETTINGS['logger']);
    error_reporting(E_ERROR | E_PARSE);

    $url = $_SERVER['REQUEST_URI'];
    $path = explode('?', $url, 2)[0];
    $path_array = array_slice(explode('/', $path), 1);

    Router::add('', get_path('views', 'mainpage.php')); // Sans regex ni wildcard

    Router::add('static', get_path('static'), false, true);

    Router::add('useruploadedcontent', get_path('database', 'uploads/'), false, true, true);

    Router::add('tests', get_path('views', 'tests/'), false, true);

    Router::add('users', get_path('api', 'user.php'));
    Router::add('contract', get_path('api', 'contract.php'));
    Router::add('sinistre', get_path('api', 'sinistre.php'));
    Router::add('auth', get_path('api', 'auth.php'));
    Router::add('account', get_path('api', 'account.php'));
    Router::add('conversation', get_path('api', 'messages.php'));
    Router::add('ticket', get_path('api', 'tickets.php'));
    Router::add('notifications', get_path('api', 'notifications.php'));
    Router::add('verification', get_path('api', 'verification.php'));
    Router::add('assurance', get_path('api', 'assurance.php'));

    Router::add('messages', get_path('views', 'chat.php'));

    Router::add('gestionnaire', get_path('views', 'gestionnaire.php'));
    Router::add('inscription', get_path('views', 'addAssure.php'));

    Router::add('user', get_path('views', 'gestionUser.php'));

    Router::add('constater', get_path('views', 'newSinistre.php'));
    Router::add('sinistres', get_path('views', 'viewSinistre.php'));

    Router::add('view', get_path('views', 'viewcontrat.php'));
    Router::add('addcontrat', get_path('views', 'addContrat.php'));
    Router::add('editcontrat', get_path('views', 'editContrat.php'));

    Router::add('me', get_path('views', 'me.php'));
    Router::add('verifications', get_path('views', 'verification.php'));

    Router::add('assurances', get_path('views', 'assurances.php'));
    Router::add('creation', get_path('views', 'addUser.php'));
    Router::add('admin', get_path('views', 'admin.php'));
    Router::add('config', get_path('views', 'configInfo.php'));
    Router::add('tickets', get_path('views', 'ticket.php'));
    Router::add('contact', get_path('views', 'contact.php'));

    Router::default(get_path('views', 'error.php'));

    // try {
        Router::start($path_array);
    // } catch (\Throwable $th) {
    //     send_json($th);
    //     http_response_code(500);
    //     die();
    // }
?>
