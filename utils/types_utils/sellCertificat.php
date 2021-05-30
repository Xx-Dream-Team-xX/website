<?php

    include_once get_path('utils', 'forms.php');

    class SellCert {
        public static $required = array(
            'contract' => array(
                'type' => 'text',
            ),
            'user' => array(
                'type' => 'text',
            ),
            'vID' => array(
                'type' => 'vID',
            ),
            'vUUID' => array(
                'type' => 'int',
            ),
            'imaDate' => array(
                'type' => 'date',
            ),
            'manufacturer' => array(
                'type' => 'text',
            ),
            'car_var' => array(
                'type' => 'text',
            ),
            'car_country_var' => array(
                'type' => 'text',
            ),
            'car_com_name' => array(
                'type' => 'text',
            ),
            'killometrage' => array(
                'type' => 'int',
            ),
            'ima_cert' => array(
                'type' => 'bool',
            ),
            'ima_cert_id' => array(
                'type' => 'int',
                'optional' => true,
            ),
            'ima_missing_cert_desc' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'old_physical' => array(
                'type' => 'bool',
            ),
            'old_sex' => array(
                'type' => 'bool',
                'optional' => true,
            ),
            'old_lastname' => array(
                'type' => 'text',
            ),
            'old_SIRET' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'old_address' => array(
                'type' => 'text',
            ),
            'old_zip_code' => array(
                'type' => 'zipcode',
            ),
            'for_destruction' => array(
                'type' => 'bool',
            ),
            'cert_date' => array(
                'type' => 'date',
            ),
            'old_agree_1' => array(
                'type' => 'bool',
            ),
            'old_agree_2' => array(
                'type' => 'bool',
            ),
            'old_agree_destruction' => array(
                'type' => 'bool',
            ),
            'VHU_id' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'new_physical' => array(
                'type' => 'bool',
            ),
            'new_sex' => array(
                'type' => 'bool',
                'optional' => true,
            ),
            'new_lastname' => array(
                'type' => 'text',
            ),
            'new_SIRET' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'birthdate' => array(
                'type' => 'date',
            ),
            'birth_place' => array(
                'type' => 'text',
            ),
            'new_address' => array(
                'type' => 'text',
            ),
            'new_zip_code' => array(
                'type' => 'zipcode',
            ),
            'new_agree_date' => array(
                'type' => 'bool',
            ),
            'new_agree_vState' => array(
                'type' => 'bool',
            ),
        );

        protected $id = '';

        /**
         * Construct and vaidate a sinistre.
         */
        public static function construct(array $rawSell) {
            if ($rawSell = validateObject($rawSell, self::$required)) {
                $rawSell['id'] = uniqid();

                return $rawSell;
            }

            throw new Exception("Array passed doesn't represend a Declaration", 1);
        }
    }

?>
