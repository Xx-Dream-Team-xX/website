<?php
    $db = new DataBase(PATH['database']. "test.json");
    //send_json($db->getFullDBInfo()[]);
    try {
        $userdata = $db->getUserByID('fdsfkjg')->getAll();
        send_json($userdata);
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
    //send_json($db->getUserByID('dfklhjk'));
?>
