<?php

    /**
     * List, info, management.
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/sinistre.php');
    include_once get_path('utils', 'forms.php');

    switch (get_final_point()) {
        case 'get':
            if (!isset($_POST['id'])) {
                break;
            }

            if (false == $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['id'])) {
                break;
            }

            if (!in_array(getPermissions(), array(User::ASSURE, User::GESTIONNAIRE, User::ADMIN))) {
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
                            send_json(array(
                                'success' => false,
                                'error' => 'This contract doesnot belong to you',
                            ));

                            break;
                        }

                        if (true == $rawSinistre['main_courante'] && !isset($rawSinistre['police_station'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'missing Police station',
                            ));

                            break;
                        }

                        if (isset($rawSinistre['garage_name']) && !isset($rawSinistre['garage_phone'],$rawSinistre['garage_email'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'missing Garage info',
                            ));

                            break;
                        }

                        $sinistre = Sinistre::construct($rawSinistre);

                        if (false !== DB::getFromID(get_path('database', 'sinistres.json'), $sinistre['id'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'Sinistre already exist',
                            ));

                            break;
                        }

                        $sinistre['injureds'] = array();

                        if (in_array($sinistre['id'], getUpdatedUser()['sinisters'])) {
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
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    break;
                default:
                    break;
            }

            break;
        case 'addInjured':

            if (User::ASSURE !== getPermissions()) {
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (isset($_POST['sinistreID']) && false !== $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['sinistreID'])) {
                try {
                    array_push($sinistre['injureds'], Sinistre::validateInjured($_POST));
                    DB::setObject(get_path('database', 'sinistres.json'), $sinistre);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                break;
            }

            send_json(array(
                'success' => false,
                'error' => 'Sinistre ID missing or do not exist',
            ));

            break;
        case 'addConstat':

            if (User::ASSURE !== getPermissions()) {
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (isset($_POST['sinistreID']) && false !== $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['sinistreID'])) {
                if (isset($sinistre['constat'])) {
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
                    echo $e->getMessage();
                }

                break;
            }

            send_json(array(
                'success' => false,
                'error' => 'Sinistre ID missing or do not exist',
            ));

            break;
        case 'addVehicle':

            if (User::ASSURE !== getPermissions()) {
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (isset($_POST['sinistreID']) && false !== $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['sinistreID'])) {
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
                        send_json(array(
                            'success' => false,
                            'error' => 'User or contract do not exist',
                        ));

                        break;
                    }

                    if (!in_array($vehicle['user'], $contract['owners'])) {
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
                    echo $e->getMessage();
                }

                break;
            }

            send_json(array(
                'success' => false,
                'error' => 'Sinistre ID missing or do not exist',
            ));

            break;
        case 'delete':
            if (!in_array(getPermissions(), array(User::GESTIONNAIRE, User::ADMIN))) {
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (!isset($_POST['sinistre'])) {
                send_json(array(
                    'success' => false,
                    'error' => 'No sinistre specified',
                ));

                break;
            }

            if (false == $sinistre = DB::getFromID(get_path('database', 'sinistres.json'), $_POST['sinistre'])) {
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
