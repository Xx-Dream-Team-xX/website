<?php
    /**
     * List, info, management
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    include_once get_path('utils', 'forms.php');

    switch (get_final_point()) {
        case 'get':

            if (!isset($_POST['id'])) return;
            $contract = DB::getFromID(get_path('database', 'contracts.json'),$_POST['id']);
            if ($contract === false) return;

            switch (getPermissions()) {
                case User::ASSURE:
                    if (in_array(getID(), $contract['owners'])) {
                        send_json($contract);
                    } else {
                        send_json(array(
                            'id' => $contract['id'],
                            'start' => $contract['start'],
                            'end' => $contract['end'],
                            'vID' => $contract['vID'],
                        ));
                    }

                    break;
                case User::GESTIONNAIRE:
                    $found = false;
                    foreach ($contract['owners'] as $user) {
                        if (getID() === DB::getFromID(get_path('database','users.json'),$user)['rep']) {
                            send_json($contract);
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        send_json(array(
                            'id' => $contract['id'],
                            'start' => $contract['start'],
                            'end' => $contract['end'],
                            'vID' => $contract['vID'],
                        ));
                    }
                    break;
                case User::POLICE:
                case User::ADMIN:
                    send_json($contract);
                    break;
                default:
                    send_json(array(
                        'id' => $contract['id'],
                        'start' => $contract['start'],
                        'end' => $contract['end'],
                        'vID' => $contract['vID'],
                    ));
                    break;
            }
            break;
        case 'set':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $required = array(
                        'start' => array(
                            'type' => 'date',
                            'optional' => true
                        ),
                        'end' => array(
                            'type' => 'date',
                            'optional' => true
                        )
                    );
                    if (isset($_POST['id']) && false !== $contract = DB::getFromID(get_path('database', 'contracts.json'), $_POST['id'])) {
                        $found = false;
                        $contract = DB::getFromID(get_path('database', 'contracts.json'),$_POST['id']);
                        foreach ($contract['owners'] as $user) {
                            if (getID() == DB::getFromID(get_path('database', 'users.json'), $user)['rep']) {
                                $found = true;
                                try {
                                    $modif = validateObject($_POST, $required);
                                    $contract = array_merge($contract, $modif);
                                    send_json($contract);
                                    DB::setObject(get_path('database', 'contracts.json'), $contract);
                                } catch (Exception $e) {
                                    echo $e->getMessage();
                                }
                            }
                        }
                        if (!$found) {
                            echo 'This contract does not belong to your Insurance';;
                        }
                    } else {
                        echo 'Contract do not exist';
                    }
                    break;
                default:
                    echo 'What are you doing wrong ?';
                    break;
            }

            break;
        case 'setTerVal':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $terVals = array('terVal' => array());
                    foreach ($_POST as $key => $value) {
                        if (in_array($key, array('A', 'B', 'BG', 'CY', 'CZ', 'D', 'DK', 'E', 'EST', 'F', 'FIN', 'GB', 'GR', 'H', 'HR', 'I', 'IRL', 'IS', 'L', 'LT', 'LV', 'M', 'N', 'NL', 'P', 'PL', 'RO', 'S', 'SK', 'SLO', 'CH', 'AL', 'AND', 'AZ', 'BIH', 'BY', 'IL', 'IR', 'MA', 'MD', 'MK', 'MNE', 'RUS', 'SRB', 'TN', 'TR', 'UA'))) {
                            $terVals['terVal'][$key] = boolval($value);
                        }
                    }
                    if (false !== $contract = DB::getFromID(get_path('database', 'contracts.json'), $_POST['id'])) {
                        if (getUpdatedUser()['assurance'] == $contract['insurance']) {
                            try {
                                $contract = array_merge($contract, $terVals);
                                send_json($contract);
                                DB::setObject(get_path('database', 'contracts.json'), $contract);
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }
                        } else {
                            echo 'This contract does not belong to your Insurance';
                        }
                    } else {
                        echo 'Contract do not exist';
                    }
                    break;
                default:
                    echo 'What are you doing wrong ?';
                    break;
            }

            break;
        case 'add':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $required = array(
                        'id' => array(
                            'type' => 'text',
                        ),
                        'owner' => array(
                            'type' => 'text',
                        ),
                        'start' => array(
                            'type' => 'date',
                        ),
                        'end' => array(
                            'type' => 'date',
                        ),
                        'vID' => array(
                            'type' => 'vID',
                        ),
                        'countryCode' => array(
                            'type' => 'text',
                        ),
                        'category' => array(
                            'type' => 'preselection',
                            'options' => array('A', 'B', 'C', 'D', 'E', 'F', 'G'),
                        ),
                        'manufacturer' => array(
                            'type' => 'text',
                        )
                    );
                    $data = validateObject($_POST, $required);
                    if (false == DB::getFromID(get_path('database', 'contracts.json'),$data['id'])) {
                        if (($user = DB::getFromID(get_path('database', 'users.json'),$data['owner'])) !== false && $user['rep'] == getUpdatedUser()['id'] && !in_array($data['id'], $user['contracts'])&& !in_array($data['id'], getUpdatedUser()['contracts'])) {
                            $data['owners'] = array($data['owner']);
                            $data['insurance'] = getUpdatedUser()['assurance'];
                            $contract = new Contract($data);
                            array_push($user['contracts'],$contract->getID());
                            $session_user = getUpdatedUser();
                            array_push($session_user['contracts'],$contract->getID());
                            DB::setObject(get_path('database', 'contracts.json'), $contract->getAll());
                            DB::setObject(get_path('database', 'users.json'), $user);
                            DB::setObject(get_path('database', 'users.json'), $session_user);
                            send_json($contract->getAll());
                        } else {
                            echo 'You are not the rep of the user';
                        }
                    } else {
                        echo 'Contract already exist';
                    }

                    break;
                default:
                    echo 'What are you doing wrong ?';
                    break;
            }

            break;
        case 'addUser':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $required = array(
                        'id' => array(
                            'type' => 'text',
                        ),
                        'user' => array(
                            'type' => 'text',
                        ),
                    );
                    $data = validateObject($_POST, $required);
                    if ((false !== $contract = DB::getFromID(get_path('database', 'contracts.json'),$data['id'])) && (false !== $user = DB::getFromID(get_path('database','users.json'),$data['user']))) { // Contract and user exist in DB
                        if(!in_array($data['user'], $contract['owners']) && !in_array($data['id'], $user['contracts'])) {
                            array_push($contract['owners'], $data['user']);
                            array_push($user['contracts'], $contract['id']);
                            DB::setObject(get_path('database','contracts.json'),$contract);
                            DB::setObject(get_path('database', 'users.json'),$user);
                        } else {
                            echo 'User already in contract or contract already in user';
                        }
                    } else {
                        echo 'how did you end up there ?';
                    }

                    break;
                default:
                    echo 'What are you doing wrong ?';
                    break;
            }
            break;
        case 'end':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $required = array(
                        'id' => array(
                            'type' => 'text',
                        )
                    );
                    $data = validateObject($_POST, $required);

                    if (false == $contract = DB::getFromID(get_path('database', 'contracts.json'),$data['id'])) {
                        if (($user = DB::getFromID(get_path('database', 'users.json'),$contract['owners'][0])) !== false && $user['rep'] == getUpdatedUser()['id']) {
                            $contract['end'] = time();
                            DB::setObject(get_path('database','contracts.json'),$contract);
                            send_json(array(
                                'success' => true
                            ));
                        } else {
                            send_json(array(
                                'success' => false,
                                'error' => 'You are not the rep of the user'
                            ));
                        }
                    } else {
                        send_json(array(
                            'success' => false,
                            'error' => 'Contract already exist'
                        ));
                        
                    }
                    
                    break;
                default:
                    echo 'What are you doing wrong ?';

                    break;
                }
            break;
        case 'delete':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $required = array(
                        'id' => array(
                            'type' => 'text',
                        )
                    );
                    $data = validateObject($_POST, $required);
                    if (false !== ($contract = DB::getFromID(get_path('database', 'contracts.json'),$data['id']))) {
                        $success = false;
                        foreach ($contract['owners'] as $key => $userID) {
                            if (false !== $user = DB::getFromID(get_path('database', 'users.json'),$userID)) {
                                $user['contracts'] = array_diff($user['contracts'],array($contract['id']));
                                DB::setObject(get_path('database','users.json'),$user);
                            } else {
                                $success = true;
                            }
                        }
                        $session_user = getUpdatedUser();
                        $session_user['contracts'] = array_diff($session_user['contracts'],array($contract['id']));
                        DB::setObject(get_path('database','users.json'),$session_user);
                        DB::deleteObject(get_path('database', 'contracts.json'), $_POST['id']);
                        send_json(array(
                            'success' => $success
                        ));
                        
                    } else {
                        send_json(array(
                            'success' => false,
                            'error' => 'Contract do not exist'
                        ));
                        
                    }

                    break;
                default:
                    send_json(array(
                        'success' => false,
                        'error' => 'What are you doing wrong ?'
                    ));

                    break;
                }
            break;

        default:
            notfound();
            break;
    }

?>
