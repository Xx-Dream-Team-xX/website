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

                $users = array_values(array_filter($users, $fcts[0]));
                send_json(array_map($fcts[1], $users));
            }
            break;
        
        case 'get':
            if (isset($_POST["id"]) && (strlen($_POST["id"]) === 13)) {

                $t = DB::getFromID(get_path("database", "users.json"), $_POST["id"]);

                if ($t && ($t = User::createUserByType($t))) {
                    switch (getPermissions()) {
                        case User::ASSURE:
                            if (getID() === $t->getID()) {
                                $all = $t->getPublic();
                                unset($all['address']);
                                unset($all['zip_code']);
                                unset($all['birth']);
                                unset($all['phone']);
                                unset($all['mail']);
                                send_json($all);
                            }
                            break;
                        case User::ADMIN:
                        case User::POLICE:
                            send_json($t->getPublic());
                            break;
                        case User::GESTIONNAIRE:
                            if (($t->getType() === User::ASSURE) && ($t->getAssurance() === getUpdatedUser()['assurance'])) {
                                send_json($t->getPublic());
                            } else {
                                send_json(array(
                                    'name' => $t->getMergedName(),
                                    'type' => $t->getType()
                                ));
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
            break;
            
        default:
            notfound();
            break;
    }
?>
