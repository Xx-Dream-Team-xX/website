<?php
    /**
     * User information, list
     */

    include_once get_path('utils', 'types_utils/users.php');

    switch (get_final_point()) {
        case 'list':
            if (getPermissions() > User::NONE) {

                $users = DB::getAll(get_path('database', 'users.json'));

                $filter = null;
                $map = null;

                $fcts = getInteractions();

                // THIS
                //        NOT
                //   WORKING
                // PLS
                //  HELP
                
                send_json($users);
                $users = array_filter($users, $fcts[0]);
                send_json($users);
                // send_json(array_map($fcts[1], $users));
            }
            break;
        default:
            notfound();
            break;
    }
?>