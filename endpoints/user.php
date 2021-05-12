<?php
    /**
     * User information, list
     */

    include_once get_path('utils', 'types_utils/users.php');

    switch (get_final_point()) {
        case 'list':
            if (getPermissions() > User::GESTIONNAIRE) {
                $users = DB::getAll(get_path('database', 'users.json'));
                
                if (getPermissions() === User::GESTIONNAIRE) {
                    $users = array_filter($users, function($u) {
                        return (($u["type"] === User::ASSURE) && ($u["rep"] === $_SESSION["user"]["assurance"]));
                    });
                }

                send_json(array_map(function($u) {
                    return array(
                        'id' => $u["id"],
                        'name' => $u["last_name"] . " " . $u["first_name"],
                        'mail' => $u["mail"],
                        'type' => $u["type"],
                        'birth' => $u["birth"]
                    );
                }, $users));
            }
            break;
        default:
            notfound();
            break;
    }
?>