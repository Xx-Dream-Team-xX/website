<?php
    /**
     * Login, registration, account security, logoff
     */
    include_once get_path('utils', 'auth.php');

    $auth = new Auth(get_path('database', 'users.json'));

    switch (get_final_point()) {
        case 'login':
            if (isset($_POST["login"], $_POST["password"]) && $auth->login($_POST["login"], $_POST["password"])) {
                send_json($_SESSION);
            } else {
                echo false;
            }
            break;
        case 'register':
            # code...
            break;
        case 'logoff':
            # code...
            break;
        case 'changepassword':
            # code...
            break;
        default:
            # code...
            break;
    }
?>