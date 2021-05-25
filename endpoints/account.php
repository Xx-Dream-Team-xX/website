<?php
    /**
     * Personal information changing, overview
     */

    include_once(get_path("utils", "files.php"));
    include_once(get_path("utils", "forms.php"));

    if (isLoggedIn()) {
        switch (get_final_point()) {
            case 'get':
                send_json(User::createUserByType(getUpdatedUser())->getPublic());
                break;
            case 'set':
                $r = array(
                    'first_name' => array(),
                    'last_name' => array(),
                    'phone' => array(),
                    'birth' => array(),
                    'address' => array(),
                    'zip_code' => array()
                );
                try {
                    $data = validateObject($_POST, $r);
                    $data = new UserAssure(array_merge(getUpdatedUser(), $data));

                    if (checkUploadedFiles()) {
                        $files = saveUploadedFiles();
                    }

                    // TODO : verify files and submit verification

                } catch (Exception $th) {
                    send_json("a");
                }
                break;
            default:
                # code...
                break;
        }
    }
?>