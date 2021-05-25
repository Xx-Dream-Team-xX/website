<?php
    /**
     * List, info, management
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    include_once get_path('utils', 'forms.php');

    switch (get_final_point()) {
        case 'get':
            $contract = DB::getFromID(get_path('database', 'contracts.json'),$_POST['id']);
            switch (getPermissions()) {
                case User::NONE:
                    send_json(array(
                        'id' => $contract['id'],
                        'start' => $contract['start'],
                        'end' => $contract['end'],
                        'vID' => $contract['vID'],
                    ));
                    break;
                case User::ASSURE:
                case User::POLICE:
                case User::GESTIONNAIRE:
                case User::ADMIN:
                    send_json($contract);
                    break;
                default:
                    echo 'What are you doing wrong ?';
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
                    if (false !== $contract = DB::getFromID(get_path('database', 'contracts.json'), $_POST['id'])) {
                        try {
                            $modif = validateObject($_POST, $required);
                            send_json($modif);
                            $contract = array_merge($contract,$modif);
                            send_json($contract);
                            DB::setObject(get_path('database', 'contracts.json'), $contract);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
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
                        'insurance' => array(
                            'type' => 'text',
                        ),
                        'countryCode' => array(
                            'type' => 'preselection',
                            'options' => array('A', 'B', 'BG', 'CY', 'CZ', 'D', 'DK', 'E', 'EST', 'F', 'FIN', 'GB', 'GR', 'H', 'HR', 'I', 'IRL', 'IS', 'L', 'LT', 'LV', 'M', 'N', 'NL', 'P', 'PL', 'RO', 'S', 'SK', 'SLO', 'CH', 'AL', 'AND', 'AZ', 'BIH', 'BY', 'IL', 'IR', 'MA', 'MD', 'MK', 'MNE', 'RUS', 'SRB', 'TN', 'TR', 'UA'),
                        ),
                        'category' => array(
                            'type' => 'preselection',
                            'options' => array('A', 'B', 'C', 'D', 'E', 'F', 'G'),
                        ),
                        'manufacturer' => array(
                            'type' => 'text',
                        ),
                    );
                    $data = validateObject($_POST, $required);

                    if (false == DB::getFromID(get_path('database', 'contracts.json'),$data['id'])) {
                        if (($user = DB::getFromID(get_path('database', 'users.json'),$data['owner'])) !== false && $user['rep'] == getUpdatedUser()['id']) {
                            $data['owners'] = array($data['owner']);
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
