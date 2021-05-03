<?php

    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    $user = UserType::createUserByType(array(
        'type' => UserType::ASSURE,
        'mail' => 'js2p@prout.fr',
        'first_name' => 'Michel',
        'last_name' => 'Roubin',
        'phone' => '+336-84-72-58-39',
    ));
    DB::writeNewUser(PATH['database'] . 'testUsers.json', $user->getAll());

    $contract = new Contract(array(
        'owners' => array($user->getID()),
        'start' => time(),
        'end' => time(),
        'vID' => 'AB-123-cd',
        'contractID' => 454705435745,
        'insurance' => '547596fjk543',
        'countryCode' => 'F6579',
        'category' => 'A',
        'manufacturer' => 'Ford',
    ));

    DB::writeObject(PATH['database'] . 'testContract.json', $contract->getAll());
    send_json(DB::getFromID(PATH['database'] . 'testContract.json', $contract->getID()));
    //send_json(DB::getUserByMail(PATH['database'] . 'testUsers.json', 'js2p@prout.fr'));
?>
