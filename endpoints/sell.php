<?php

    /**
     * List, info, management.
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/sellCertificat.php');
    include_once get_path('utils', 'forms.php');

    switch (get_final_point()) {
        case 'get':
            if (!isset($_POST['id'])) {
                break;
            }

            if (false == $sell = DB::getFromID(get_path('database', 'sell.json'), $_POST['id'])) {
                break;
            }

            if (!in_array(getPermissions(), array(User::ASSURE, User::GESTIONNAIRE, User::ADMIN))) {
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (User::GESTIONNAIRE == getPermissions() && DB::getFromID(get_path('database', 'users.json'), $sell['user'])['rep'] !== getID() && ($sell['user'] !== getID())) {
                break;
            }

            send_json($sell);

            break;
        case 'add':
            switch (getPermissions()) {
                case User::ASSURE:

                    if (false == $contract = DB::getFromID(get_path('databse', 'contracts.json'), $rawSell['contract'])) {
                        send_json(array(
                            'success' => false,
                            'error' => 'Contract not found',
                        ));

                        break;
                    }

                    $rawSell = array_merge($_POST, array(
                        'user' => getID(),
                        'vID' => $contract['vID'],
                        'manufacturer' => $contract['manufaturer'],
                    ));

                    try {
                        $rawSell = validateObject($rawSell, Sinistre::$required);

                        if (!in_array($rawSell['contract'], getUpdatedUser()['contracts'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'This contract doesnot belong to you',
                            ));

                            break;
                        }

                        if (($rawSell['old_physical'] && !isset($rawSell['old_sex'])) || (true == $rawSell['new_physical'] && !isset($rawSell['new_sex']))) {
                            send_json(array(
                                'success' => false,
                                'error' => 'missing one of the users sex',
                            ));

                            break;
                        }

                        if (($rawSell['ima_cer'] && !isset($rawSell['ima_cert_id'])) || (!$rawSell['ima_cer'] && !isset($rawSell['ima_missing_cert_desc']))) {
                            send_json(array(
                                'success' => false,
                                'error' => 'missing imat cert',
                            ));

                            break;
                        }

                        if ($rawSell['old_agree_destruction'] && !isset($rawSell['VHU_id'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'missing VHU',
                            ));

                            break;
                        }

                        $sell = SellCert::construct($rawSell);

                        if (false !== DB::getFromID(get_path('database', 'sell.json'), $sell['id'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'Sinistre already exist',
                            ));

                            break;
                        }

                        if (in_array($sell['id'], getUpdatedUser()['declarations'])) {
                            send_json(array(
                                'success' => false,
                                'error' => 'Something wrong happend',
                            ));

                            break;
                        }

                        send_json($sell);
                        $user = getUpdatedUser();
                        array_push($user['declarations'], $sell['id']);
                        DB::setObject(get_path('database', 'sell.json'), $sell, true);
                        DB::setObject(get_path('database', 'users.json'), $user);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    break;
                default:
                    break;
            }

            break;
        case 'delete':
            if (!in_array(getPermissions(), array(User::GESTIONNAIRE, User::ADMIN))) {
                send_json(array(
                    'success' => false,
                    'error' => 'You can\'t do that',
                ));

                break;
            }

            if (!isset($_POST['id'])) {
                send_json(array(
                    'success' => false,
                    'error' => 'No Declaration specified',
                ));

                break;
            }

            if (false == $sell = DB::getFromID(get_path('database', 'sell.json'), $_POST['id'])) {
                send_json(array(
                    'success' => false,
                    'error' => 'Declaration do not exist',
                ));

                break;
            }

            $session_user = getUpdatedUser();
            $session_user['declarations'] = array_diff($session_user['declarations'], array($_POST['id']));
            DB::setObject(get_path('database', 'users.json'), $session_user);
            DB::deleteObject(get_path('database', 'sell.json'), $_POST['id']);

            break;
        default:
            notfound();

            break;
    }

?>