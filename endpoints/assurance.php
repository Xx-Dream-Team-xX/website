<?php

    /**
     * Assurance creation, list, obtention
     */
    
    include_once get_path('utils', 'types_utils/assurance.php');
    include_once get_path('utils', 'forms.php');
    include_once get_path('utils', 'files.php');

    switch (get_final_point()) {
        case 'get':
            if (isset($_POST['id']) && isLoggedIn()) {
                $a = DB::getFromID(get_path("database", "assurances.json"), $_POST['id']);

                if ($a && ($a = new Assurance($a))) {
                    send_json($a->getAll());
                }
            }
            break;
        case 'list':
            
            if (getPermissions() > User::GESTIONNAIRE) {
                $ass = DB::getAll(get_path("database", "assurances.json"));
                send_json($ass);
            }

            break;
        case 'add':
            
            if (getPermissions() > User::GESTIONNAIRE) {
                $ass = validateObject($_POST, array(
                    "name" => array(),
                    "phone" => array(
                        "type" => "phone"
                    )
                ));
    
                if ($ass && checkUploadedFiles("img", 1)) {
                    $files = saveUploadedFiles();
                } else return send_json(false);
    
                $ass = new Assurance(array_merge($ass, array(
                    'logoPath' => $files[0]
                )));
    
                DB::setObject(get_path("database", "assurances.json"), $ass->getAll(), true);
    
                send_json($ass->getAll());
            }
            
            break;
        
        default:
            # code...
            break;
    }

?>