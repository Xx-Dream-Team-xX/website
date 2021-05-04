<?php

    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    $user = User::createUserByType(array(
        'type' => User::ASSURE,
        'mail' => 'js2p@prout.fr',
        'first_name' => 'Michelle',
        'last_name' => 'Roubin',
        'phone' => '+336-84-72-58-39',
    ));
    DB::setObject(get_path('database', 'testUsers.json'), $user->getAll(), true);

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

    DB::setObject(get_path('database', 'testContrats.json'), $contract2->getAll(), true);
    DB::setObject(get_path('database', 'testContrats.json'), $contract->getAll(), true);
    DB::setObject(get_path('database', 'testUsers.json'), $user->getAll());
    send_json($user->getAll());
    send_json($contract->getAll());
    send_json($contract2->getAll());
    //send_json(DB::getUserByMail(PATH['database'] . 'testUsers.json', 'js2p@prout.fr'));
?>
