<?php

    /**
     * Login, registration, account security, logoff.
     */
    include_once get_path('utils', 'auth.php');

    $auth = new Auth(get_path('database', 'users.json'));

    switch (get_final_point()) {
        case 'login':
            send_json(isset($_POST['login'], $_POST['password']) ? $auth->login($_POST['login'], $_POST['password']) : false);

            break;
        case 'register':
            if (getPermissions() > 2) {
                send_json($auth->register($_POST)); // Utilisateur lambda, à faire par types
            }
            break;
        case 'logoff':
            session_destroy();

            break;
        case 'changepassword':
            if (getPermissions() > 0) {
                send_json(isset($_POST['password']) ? $auth->changePassword($_SESSION['user']['id'], $_SESSION['user']['mail'], $_POST['password'], $_POST['new'] ?? null) : false);
            }

            break;
        default:
            notfound();
            break;
    }
?>