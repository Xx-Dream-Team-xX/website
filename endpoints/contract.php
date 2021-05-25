<?php
    /**
     * List, info, management
     */
    include_once get_path('utils', 'types_utils/users.php');
    include_once get_path('utils', 'types_utils/contract.php');

try {
    switch (get_final_point()) {
        case 'get':
            $contract = DB::getFromID(get_path('database', 'contracts.json'),$_POST['id']);
            switch (getPermissions()) {
                case User::NONE:
                    send_json(array(
                        'id' => $contract['id'],
                        'start' => $contract['start'],
                        'end' => $contract['end'],
                        'vID' => $contract['vID'],
                    ));
                    break;
                case User::ASSURE:
                case User::POLICE:
                case User::GESTIONNAIRE:
                case User::ADMIN:
                    send_json($contract);
                    break;
                default:
                    echo 'What are you doing wrong ?';
                    break;
            }
            break;
        case 'set':
            switch (getPermissions()) {
                case User::GESTIONNAIRE:
                    $contract = new Contract(array(
                        'id' => $_POST['id'],
                        'owners' => $_POST['owners'],
                        'start' => $_POST['start'],
                        'end' => $_POST['end'],
                        'vID' => $_POST['vID'],
                        'insurance' => $_POST['insurance'],
                        'countryCode' => $_POST['countryCode'],
                        'category' => $_POST['category'],
                        'manufacturer' => $_POST['manufacturer'],
                    ));
                    DB::setObject(get_path('database', 'contracts.json'),$contract->getAll(), true);

                    send_json($contract->getAll());
                default:
                    echo 'What are you doing wrong ?';
                    break;
            }
        default:
            notfound();
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
