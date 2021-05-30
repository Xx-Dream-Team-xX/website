<?php

    /**
     * Personal information changing, overview.
     */
    include_once get_path('utils', 'files.php');
    include_once get_path('utils', 'forms.php');
    include_once get_path('utils', 'types_utils/verification.php');

    if (isLoggedIn()) {
        switch (get_final_point()) {
            case 'get':
                send_json(User::createUserByType(getUpdatedUser())->getPublic());
                $_SERVER['logger']->log(1, whois() . 'querry user');

                break;
            case 'set':

                if (User::ASSURE !== getPermissions()) {
                    $_SERVER['logger']->log(3, whois() . "Echec de la modification de l'utilisateur");

                    return;
                }

                $r = array(
                    'first_name' => array(),
                    'last_name' => array(),
                    'phone' => array(
                        'type' => 'phone',
                    ),
                    'birth' => array(
                        'type' => 'date',
                    ),
                    'address' => array(),
                    'zip_code' => array(
                        'type' => 'zipcode',
                    ),
                );

                try {
                    $data = validateObject($_POST, $r);

                    if (checkUploadedFiles()) {
                        $files = saveUploadedFiles();
                    } else {
                        return send_json(false);
                    }

                    $user = new UserAssure(getUpdatedUser());

                    $v = new Verification(array(
                        'owner' => getID(),
                        'assurance' => $user->getAssurance(),
                        'content' => array(
                            'raw' => $data,
                            'justification' => isset($_POST['justification']) ? $_POST['justification'] : null,
                            'files' => $files,
                        ),
                    ));

                    DB::setObject(get_path('database', 'verifications.json'), $v->getAll(), true);
                    $_SERVER['logger']->log(3, whois() . "Modification de l'utilisateur");
                    $rep = DB::getFromID(get_path('database', 'users.json'), $user->getRep());
                    if ($rep) {
                        $rep = User::createUserByType($rep);

                        $rep->pushNotification('Nouvelle demande de vérification', 'De nouveaux documents requièrent votre attention', '/verifications/' . $v->getID());

                        DB::setObject(get_path('database', 'users.json'), $rep->getAll());
                    }

                    send_json($v->getID());
                } catch (Exception $th) {
                    send_json(false);
                }

                break;
            default:
                // code...
                break;
        }
    }
?>
