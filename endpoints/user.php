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

                switch (getPermissions()) {
                    case User::GESTIONNAIRE:
                        $filter = function($u) {
                            return (($u["type"] === User::ASSURE) && ($u["assurance"] === $_SESSION["user"]["assurance"]));
                        };
                        $map = function($u) {

                            return array(
                                'id' => $u["id"],
                                'name' => $u["last_name"] . " " . $u["first_name"],
                                'mail' => $u["mail"],
                                'type' => $u["type"],
                                'birth' => $u["birth"],
                                'declarations' => sizeof($u["declarations"]),
                                'contracts' => sizeof($u["contracts"]),
                                'sinisters' => sizeof($u["sinisters"]),
                                'actions' => sizeof($u["actions"])
                            );
                        };
                        break;
                    case User::ADMIN:
                        $filter = function($u) {
                            return ($u["type"] !== User::ADMIN);
                        };
                        $map = function($u) {
                            $u = (User::createUserByType($u))->getPublic();
                            return ;
                        };
                        break;
                    case User::ASSURE:
                        $filter = function($u) {
                            return (($u["type"] === User::GESTIONNAIRE) && ($u["assurance"] === $_SESSION["user"]["assurance"]));
                        };
                        $map = function($u) {
                            return array(
                                'id' => $u['id'],
                                'name' => $u["last_name"] . " " . $u["first_name"],
                                'mail' => ($u["id"]===$_SESSION["user"]["rep"]) ? $u["mail"] : false
                            );
                        };
                        break;
                    default:
                        $users = [];
                        
                        break;
                }
                
                send_json(array_map($map, array_filter($users, $filter)));
            }
            break;
        default:
            notfound();
            break;
    }
?>