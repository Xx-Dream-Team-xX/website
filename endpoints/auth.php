<?php
    /**
     * Login, registration, account security, logoff
     */
    include_once get_path('utils', 'auth.php');

    $auth = new Auth(get_path('database', 'users.json'));

    switch (get_final_point()) {
        case 'login':
            send_json(isset($_POST["login"], $_POST["password"]) && $auth->login($_POST["login"], $_POST["password"]));
            break;
        case 'register':
            # code...
            break;
        case 'logoff':
            session_destroy();
            break;
        case 'changepassword':
            if (getPermissions() > 0) {
                
            }
            break;
        default:
            # code...
            break;
    }
?>