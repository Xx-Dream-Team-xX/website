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
                        if (($user = DB::getFromID(get_path('database', 'users.json'),$data['owner'])) !== false && $user['rep'] == getUpdatedUser()['id']) {
                            $data['owners'] = array($data['owner']);
                            $data['insurance'] = getUpdatedUser()['assurance'];
                            $contract = new Contract($data);
                            DB::setObject(get_path('database', 'contracts.json'), $contract->getAll());
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
                    $data = validateObject($_POST, $required);
                    if (false == DB::getFromID(get_path('database', 'contracts.json'),$data['id'])) {
                        if (($user = DB::getFromID(get_path('database', 'users.json'),$data['owner'])) !== false && $user['rep'] == getUpdatedUser()['id']) {
                            $data['owners'] = array($data['owner']);
                            $data['insurance'] = getUpdatedUser()['assurance'];
                            $contract = new Contract($data);
                            DB::setObject(get_path('database', 'contracts.json'), $contract->getAll());
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
        case 'delete':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    echo DB::deleteObject(get_path('database', 'contracts.json'), $_POST['id']);

                    break;
                default:
                    echo 'What are you doing wrong ?';

                    break;
                }
            break;

        default:
            notfound();
            break;
    }

?>
