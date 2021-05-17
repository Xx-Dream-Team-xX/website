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
            switch (getPermissions()) {
                case 3:
                    send_json($auth->register($_POST, $_SESSION['user']['id']));
                    break;
                case 4:
                    send_json($auth->register($_POST, $_SESSION['user']['id'], ($_POST["type"]) == User::POLICE) ?: User::GESTIONNAIRE);
                    break;
                default:

                    break;
            }
            break;
        case 'logoff':
            session_destroy();

            break;
        case 'changepassword':
            if (getPermissions() > 0) {
                send_json(isset($_POST['password'], $_POST['mail']) ? $auth->changePassword($_SESSION['user']['id'], $_POST['mail'], $_POST['password'], $_POST['new'] ?? null) : false);
            }

            break;
        default:
            notfound();
            break;
    }
?>