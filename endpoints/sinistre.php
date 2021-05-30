<?php

    /**
     * List, info, management.
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/sinistre.php');
    include_once get_path('utils', 'forms.php');

    switch (get_final_point()) {
        case 'getList':
            $sinistres = DB::getAll(get_path('database', 'sinistres.json'));
            switch (getPermissions()) {
                case User::ASSURE:
                    $list_sinistres = array();
                    foreach ($sinistres as $key => $sinistre) {
                        if ($sinistre['user'] == getID()) {
                            array_push($list_sinistres, array(
                                'id' => $sinistre['id'],
                                'contract' => $sinistre['contract'],
                                'date' => $sinistre['date'],
                            ));
                        }
                    }
                    send_json($list_sinistres);

                    break;
                case User::GESTIONNAIRE:
                    $list_sinistres = array();
                    foreach ($sinistres as $key => $sinistre) {
                        if (false == $user = DB::getFromID(get_path('database', 'users.json'), $sinistre['user'])) {
                            $_SERVER['logger']->log(Logger::ERRORS, whois() . 'Database error : User ' . $sinistre['user'] . ' don\'t exist');

                            continue;
                        }
                        if ($user['rep'] == getID()) {
                            array_push($list_sinistres, array(
                                'id' => $sinistre['id'],
                                'contract' => $sinistre['contract'],
                                'date' => $sinistre['date'],
                            ));
                        }
                    }
                    send_json($list_sinistres);

                    break;
                default:
                    http_response_code(400);

                    break;
            }

            break;
        case 'get':
            if (!isset($_POST['id'])) {
                http_response_code(400);

                break;
            }

            if (false == $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['id'])) {
                http_response_code(400);

                break;
            }

            if (!in_array(getPermissions(), array(User::ASSURE, User::GESTIONNAIRE, User::ADMIN))) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (User::GESTIONNAIRE == getPermissions() && DB::getFromID(get_path('database', 'users.json'), $sinistre['user'])['rep'] !== getID() && ($sinistre['user'] !== getID())) {
                break;
            }

            send_json($sinistre);

            break;
        case 'add':
            switch (getPermissions()) {
                case User::ASSURE:

                    $rawSinistre = array_merge($_POST, array(
                        'user' => getID(),
                    ));

                    try {
                        $rawSinistre = validateObject($rawSinistre, Sinistre::$required);

                        if (!in_array($rawSinistre['contract'], getUpdatedUser()['contracts'])) {
                            http_response_code(400);
                            send_json(array(
                                'success' => false,
                                'error' => 'This contract doesnot belong to you',
                            ));

                            break;
                        }

                        if (true == $rawSinistre['main_courante'] && !isset($rawSinistre['police_station'])) {
                            http_response_code(400);
                            send_json(array(
                                'success' => false,
                                'error' => 'missing Police station',
                            ));

                            break;
                        }

                        if (isset($rawSinistre['garage_name']) && !isset($rawSinistre['garage_phone'],$rawSinistre['garage_email'])) {
                            http_response_code(400);
                            send_json(array(
                                'success' => false,
                                'error' => 'missing Garage info',
                            ));

                            break;
                        }

                        $sinistre = Sinistre::construct($rawSinistre);

                        if (false !== DB::getFromID(get_path('database', 'sinistres.json'), $sinistre['id'])) {
                            http_response_code(400);
                            send_json(array(
                                'success' => false,
                                'error' => 'Sinistre already exist',
                            ));

                            break;
                        }

                        $sinistre['injureds'] = array();

                        if (in_array($sinistre['id'], getUpdatedUser()['sinisters'])) {
                            http_response_code(400);
                            send_json(array(
                                'success' => false,
                                'error' => 'Something wrong happend',
                            ));

                            break;
                        }

                        send_json($sinistre);
                        $user = getUpdatedUser();
                        array_push($user['sinisters'], $sinistre['id']);
                        DB::setObject(get_path('database', 'sinistres.json'), $sinistre, true);
                        DB::setObject(get_path('database', 'users.json'), $user);

                        $g = DB::getFromID(get_path("database", "users.json"), $user["rep"]);
                        if ($g && ($g = User::createUserByType($g))) {
                            $g->pushNotification("Nouveau sinistre", $user["first_name"] . " vient de déclarer un sinistre.", "/sinistres/" . $sinistre["id"]);
                            DB::setObject(get_path("database", "users.json"), $g->getAll());
                        }
                    } catch (Exception $e) {
                        http_response_code(400);
                        echo $e->getMessage();
                    }

                    break;
                default:
                    break;
            }

            break;
        case 'addInjured':

            if (User::ASSURE !== getPermissions()) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (isset($_POST['id']) && false !== $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['id'])) {
                try {
                    array_push($sinistre['injureds'], Sinistre::validateInjured($_POST));
                    DB::setObject(get_path('database', 'sinistres.json'), $sinistre);
                } catch (Exception $e) {
                    http_response_code(400);
                    echo $e->getMessage();
                }

                break;
            }
            http_response_code(400);
            send_json(array(
                'success' => false,
                'error' => 'Sinistre ID missing or do not exist',
            ));

            break;
        case 'addConstat':

            if (User::ASSURE !== getPermissions()) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (isset($_POST['id']) && false !== $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['id'])) {
                if (isset($sinistre['constat'])) {
                    http_response_code(400);
                    send_json(array(
                        'success' => false,
                        'error' => 'Constat already exist in this sinistre',
                    ));

                    break;
                }

                try {
                    $sinistre['constat'] = Sinistre::validateConstat($_POST);
                    $sinistre['constat']['vehicles'] = array();
                    send_json($sinistre);
                    DB::setObject(get_path('database', 'sinistres.json'), $sinistre);
                } catch (Exception $e) {
                    http_response_code(400);
                    echo $e->getMessage();
                }

                break;
            }
            http_response_code(400);
            send_json(array(
                'success' => false,
                'error' => 'Sinistre ID missing or do not exist',
            ));

            break;
        case 'addVehicle':

            if (User::ASSURE !== getPermissions()) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (isset($_POST['id']) && false !== $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['id'])) {
                if (!isset($sinistre['constat'])) {
                    send_json(array(
                        'success' => false,
                        'error' => 'No constat in the sinistre',
                    ));

                    break;
                }
                $constat = &$sinistre['constat'];

                try {
                    $vehicle = Sinistre::validateConstatVehicle($_POST);

                    if ((false == DB::getFromID(get_path('database', 'users.json'), $vehicle['user'])) || (false == $contract = DB::getFromID(get_path('database', 'contracts.json'), $vehicle['contract']))) {
                        http_response_code(400);
                        send_json(array(
                            'success' => false,
                            'error' => 'User or contract do not exist',
                        ));

                        break;
                    }

                    if (!in_array($vehicle['user'], $contract['owners'])) {
                        http_response_code(400);
                        send_json(array(
                            'success' => false,
                            'error' => 'User not in contract',
                        ));

                        break;
                    }

                    array_push($constat['vehicles'], $vehicle);
                    send_json($sinistre);
                    DB::setObject(get_path('database', 'sinistres.json'), $sinistre);
                } catch (Exception $e) {
                    http_response_code(400);
                    echo $e->getMessage();
                }

                break;
            }
            http_response_code(400);
            send_json(array(
                'success' => false,
                'error' => 'Sinistre ID missing or do not exist',
            ));

            break;
        case 'delete':
            if (!in_array(getPermissions(), array(User::GESTIONNAIRE, User::ADMIN))) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (!isset($_POST['sinistre'])) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'No sinistre specified',
                ));

                break;
            }

            if (false == $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['sinistre'])) {
                http_response_code(400);
                send_json(array(
                    'success' => false,
                    'error' => 'Sinistre do not exist',
                ));

                break;
            }

            $session_user = getUpdatedUser();
            $session_user['contracts'] = array_diff($session_user['contracts'], array($_POST['sinistre']));
            DB::setObject(get_path('database', 'users.json'), $session_user);
            DB::deleteObject(get_path('database', 'sinistres.json'), $_POST['sinistre']);

            break;
        default:
            notfound();

            break;
    }

?>
