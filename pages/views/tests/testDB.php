<?php

    include_once get_path('utils', 'users.php');
    // $user = UserType::createUserByType(array(
    //     'id' => uniqid(),
    //     'type' => UserType::USER,
    //     'mail' => 'js1p@prout.fr',
    //     'first_name' => "Roger",
    //     'last_name' => "Amir"
    // ));
    // DB::writeNewUser(PATH['database'] . 'testDB.json', $user->getAll());

    send_json(DB::getUserByMail(PATH['database'] . "testDB.json","jsp@prout.fr"));
?>
