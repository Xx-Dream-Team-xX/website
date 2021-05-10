<?php

    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    include_once get_path('utils', 'types_utils/conversation.php');
    include_once get_path('utils', 'types_utils/assurance.php');

    $assurance = new Assurance(array(
        'name' => 'Assu4000',
        'phone' => '+336-84-72-58-39',
    ));

    $gestionnaire = $assurance->newGestionnaire(array(
        'mail' => 'js3p@prout.fr',
        'first_name' => 'Michelle',
        'last_name' => 'Roubin',
        'phone' => '+336-44-72-58-39',
        'password' => 'jsp',
    ));

    $user = $gestionnaire->newUserAssure(array(
        'mail' => 'js2p@prout.fr',
        'first_name' => 'Michelle',
        'last_name' => 'Roubin',
        'phone' => '+336-84-72-58-39',
        'address' => 'salut',
        'zip_code' => '33080',
        'password' => 'jsp',
    ));
    DB::setObject(get_path('database', 'testUsers.json'), $user->getAll(), true);

    $contract = $assurance->newContract(array(
        'id' => '434705435745',
        'owners' => array($user->getID()),
        'start' => time(),
        'end' => time(),
        'vID' => 'AB-123-cd',
        'insurance' => '547596fjk543',
        'countryCode' => 'F6579',
        'category' => 'A',
        'manufacturer' => 'Renault',
    ));

    $contract->generateQr();

    // $contract2 = $assurance->newContract(array(
    //     'id' => '434705435745',
    //     'owners' => array($user->getID()),
    //     'start' => time(),
    //     'end' => time(),
    //     'vID' => 'AB-123-cd',
    //     'insurance' => '547596fjk543',
    //     'countryCode' => 'F6579',
    //     'category' => 'A',
    //     'manufacturer' => 'Ford',
    // ));
    // DB::setObject(get_path('database', 'testAssurances.json'), $assurance->getAll(), true);
    // $user->addContract($contract);
    // $contract2->addOwner($user);

    // $test = new Conversation(array(
    //     'people' => array(
    //         uniqid(),
    //         uniqid(),
    //     ), )
    // );

    // DB::setObject($test->getPath(), (new Message(array(
    //     'content' => 'uwu',
    //     'sender' => $test->getAll()['people'][0],
    // )))->getAll());

    // DB::setObject($test->getPath(), (new Message(array(
    //     'content' => 'owo',
    //     'sender' => $test->getAll()['people'][0],
    // )))->getAll());

    // exit();

    // DB::setObject(get_path('database', 'testContrats.json'), $contract2->getAll()); // fais gaffe je force plus le new
    // DB::setObject(get_path('database', 'testContrats.json'), $contract->getAll());
    // DB::setObject(get_path('database', 'testUsers.json'), $user->getAll());

    // send_json($user->getAll());
    // send_json($contract->getAll());
    // send_json($contract2->getAll());
    // send_json($assurance->getAll());
    //send_json(DB::getUserByMail(PATH['database'] . 'testUsers.json', 'js2p@prout.fr'));
?>
