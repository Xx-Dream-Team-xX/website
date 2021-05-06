<?php
    include get_path("utils", "auth.php");
    include get_path("utils", "types_utils/users.php");
    $auth = new Auth(get_path('database', 'testUsers.json'));
    echo var_dump($auth->register(array(
        'mail' => "a",
        'first_name' => "b",
        'last_name' => "c",
        'address' => "d",
        "zip" => "e",
        "phone" => "f"
    )));
?>