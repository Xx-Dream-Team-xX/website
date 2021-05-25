<?php

include_once get_path('utils', 'types_utils/contract.php');
include_once get_path('utils', 'data.php');

try {
    $contract = new Contract(array(
        'id' => '12432534589',
        'owners' => array(
            '60a2d9a15ffde'
        ),
        'start' => time(),
        'end' => time() +1000,
        'vID' => 'AA-124-BB',
        'insurance' => '60a2d9a15ffde',
        'countryCode' => 'F',
        'category' => 'A',
        'manufacturer' => 'Ford'
    ));
    DB::setObject(get_path('database', 'contracts.json'), $contract->getAll(), true);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
