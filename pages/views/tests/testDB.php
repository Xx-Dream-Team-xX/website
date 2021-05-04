<?php

    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    $user = UserType::createUserByType(array(
        'type' => UserType::ASSURE,
        'mail' => 'js2p@prout.fr',
        'first_name' => 'Michelle',
        'last_name' => 'Roubin',
        'phone' => '+336-84-72-58-39',
    ));
    DB::createObject(PATH['database'] . 'testUsers.json', $user->getAll());

    $contract = new Contract(array(
        'owners' => array($user->getID()),
        'start' => time(),
        'end' => time(),
        'vID' => 'AB-123-cd',
        'contractID' => 434705435745,
        'insurance' => '547596fjk543',
        'countryCode' => 'F6579',
        'category' => 'A',
        'manufacturer' => 'Ford',
    ));

    $contract2 = new Contract(array(
        'owners' => array($user->getID()),
        'start' => time(),
        'end' => time(),
        'vID' => 'AB-123-cd',
        'contractID' => 424705435745,
        'insurance' => '547596fjk543',
        'countryCode' => 'F6579',
        'category' => 'A',
        'manufacturer' => 'Ford',
    ));

    $user->addContract($contract);
    $contract2->addOwner($user);

    DB::createObject(PATH['database'] . 'testContract.json', $contract2->getAll());
    DB::createObject(PATH['database'] . 'testContract.json', $contract->getAll());
    DB::writeObject(get_path('database', 'testUsers.json'), $user->getAll());
    send_json($user->getAll());
    send_json($contract->getAll());
    send_json($contract2->getAll());
    //send_json(DB::getUserByMail(PATH['database'] . 'testUsers.json', 'js2p@prout.fr'));
?>
