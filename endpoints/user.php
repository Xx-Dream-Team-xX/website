<?php
    /**
     * User information, list
     */

    include_once get_path('utils', 'types_utils/users');

    switch (get_final_point()) {
        case 'list':
            if (getPermissions() > User::GESTIONNAIRE) {
                $users = DB::getAll(get_path('database', 'users.json'));
                
                if (getPermissions() === User::GESTIONNAIRE) {
                    $users = array_filter($users, function($u) {
                        return (($u["type"] === User::ASSURE) && ($u["rep"] === $_SESSION["user"]["assurance"]));
                    });
                }
            }
            break;
        default:
            # code...
            break;
    }
?>