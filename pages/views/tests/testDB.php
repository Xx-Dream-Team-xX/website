<?php

    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');
    include_once get_path('utils', 'types_utils/conversation.php');

    ConversationManager::setPath(get_path('database') . 'messages/');
    $user = User::createUserByType(array(
        'type' => User::ASSURE,
        'mail' => 'js2p@prout.fr',
        'first_name' => 'Michelle',
        'last_name' => 'Roubin',
        'phone' => '+336-84-72-58-39',
    ));
    DB::setObject(get_path('database', 'testUsers.json'), $user->getAll(), true);

    $contract = new Contract(array(
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

    $contract2 = new Contract(array(
        'id' => '434705435745',
        'owners' => array($user->getID()),
        'start' => time(),
        'end' => time(),
        'vID' => 'AB-123-cd',
        'insurance' => '547596fjk543',
        'countryCode' => 'F6579',
        'category' => 'A',
        'manufacturer' => 'Ford',
    ));

    $user->addContract($contract);
    $contract2->addOwner($user);

    $test = new Conversation(array(
        'people' => [
            uniqid(),
            uniqid()
        ])
    );

    DB::setObject($test->getPath(), (new Message(array(
        'content' => "uwu",
        'sender' => $test->getAll()["people"][0]
    )))->getAll());

    DB::setObject($test->getPath(), (new Message(array(
        'content' => "owo",
        'sender' => $test->getAll()["people"][0]
    )))->getAll());

    exit();

    DB::setObject(get_path('database', 'testContrats.json'), $contract2->getAll()); // fais gaffe je force plus le new
    DB::setObject(get_path('database', 'testContrats.json'), $contract->getAll());
    DB::setObject(get_path('database', 'testUsers.json'), $user->getAll());
    send_json($user->getAll());
    send_json($contract->getAll());
    send_json($contract2->getAll());
    //send_json(DB::getUserByMail(PATH['database'] . 'testUsers.json', 'js2p@prout.fr'));
?>
