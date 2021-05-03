<?php

    include_once get_path('utils', 'types_utils/users.php');
    $user = UserType::createUserByType(array(
        'type' => UserType::USER,
        'mail' => 'js2p@prout.fr',
        'first_name' => 'Michel',
        'last_name' => 'Roubin',
        'phone' => '+336-84-72-58-39',
    ));
    DB::writeNewUser(PATH['database'] . 'testDB.json', $user->getAll());

    send_json(DB::getUserByMail(PATH['database'] . 'testDB.json', 'jsp2@prout.fr'));
?>
