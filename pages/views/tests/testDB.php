<?php
    $db = new DataBase(PATH['database']. "testDB.json");
    //send_json($db->getFullDBInfo()[]);
    try {
        //$userdata = $db->getUserByMail('salut@prout.fr');
        $user1 = $db->getUserByID('608e9e02f064d');
        $user1->setMail('jsp@prout.fr');

        send_json($user1->getAll());
        $db->saveDBtoFile();
    } catch (\Throwable $th) {
        echo $th;
    }
    //send_json($db->getUserByID('dfklhjk'));
?>
