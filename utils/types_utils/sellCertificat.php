<?php

    include_once get_path('utils', 'forms.php');

    class SellCert {
        public static $required = array(
            'vID' => array(
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
            'ima_cert_id' => array(
                'type' => 'int',
                'optional' => true,
            ),
            'ima_missing cert' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'old_physical' => array(
                'type' => 'bool',
            ),
            'old_sexe' => array(
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
            'new_sexe' => array(
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
         *
         * @param array $rawSinistre Array representing a sinistre. Must contain the entries listed in $this->required
         *                           On top of them those entries can be added :
         *                           'garage_name', 'garage_phone'
         */
        public function __construct(array $rawSinistre) {
            if ($rawSinistre = validateObject($rawSinistre, self::$required)) {
                if (isset($rawSinistre['injureds'])) {
                    $rawSinistre['injureds'] = self::validateInjured($rawSinistre['injureds']);
                }
                if (isset($rawSinistre['constat'])) {
                    $rawSinistre['constat'] = self::validateConstat($rawSinistre['constat']);
                }
                send_json($rawSinistre);
            } else {
                throw new Exception("Array passed doesn't represend a Sinistre", 1);
            }
        }

        /**
         * Validate injured list.
         *
         * @return array|bool false if not valid
         */
        private static function validateInjured(array $injured_list) {
            try {
                $required = array(
                    'firstname' => array(
                        'type' => 'text',
                    ),
                    'lastname' => array(
                        'type' => 'text',
                    ),
                    'address' => array(
                        'type' => 'text',
                    ),
                    'phone' => array(
                        'type' => 'phone',
                    ),
                    'profession' => array(
                        'type' => 'text',
                    ),
                    'belt' => array(
                        'type' => 'bool',
                    ),
                    'injuries' => array(
                        'type' => 'text',
                    ),

                );
                foreach ($injured_list as &$injured) {
                    $injured = validateObject($injured, $required);
                }

                return $injured_list;
            } catch (Exception $e) {
                throw new Exception("Injured list -> {$e->getMessage()}", 1);
            }
        }

        private static function validateConstat(array $constat) {
            try {
                $required = array(
                    'date' => array(
                        'type' => 'date',
                    ),
                    'location' => array(
                        'type' => 'text',
                    ),
                    'injured' => array(
                        'type' => 'bool',
                    ),
                    'other_vehicle_involved' => array(
                        'type' => 'bool',
                    ),
                    'other_object_involved' => array(
                        'type' => 'bool',
                    ),
                    'wintensses' => array(
                        'type' => 'text',
                    ),
                    'vehicle_A' => array(
                        'type' => 'array',
                    ),
                    'vehicle_B' => array(
                        'type' => 'array',
                    ),
                );
                $constat = validateObject($constat, $required);
                $constat['vehicle_A'] = self::validateConstatVehicle($constat['vehicle_A']);
                $constat['vehicle_B'] = self::validateConstatVehicle($constat['vehicle_B']);

                return $constat;
            } catch (Exception $e) {
                throw new Exception("Constat -> {$e->getMessage()}", 1);
            }
        }

        private static function validateConstatVehicle(array $Vehcile) {
            try {
                $required = array(
                    'user' => array(
                        'type' => 'text',
                    ),
                    'contract' => array(
                        'type' => 'text',
                    ),
                    'assurance' => array(
                        'type' => 'text',
                    ),
                    'driver_firstname' => array(
                        'type' => 'text',
                    ),
                    'driver_lastname' => array(
                        'type' => 'text',
                    ),
                    'driver_birthdate' => array(
                        'type' => 'date',
                    ),
                    'driver_address' => array(
                        'type' => 'text',
                    ),
                    'driver_country' => array(
                        'type' => 'text',
                    ),
                    'driver_phone' => array(
                        'type' => 'phone',
                    ),
                    'dirver_email' => array(
                        'type' => 'email',
                    ),
                    'driver_liscence_id' => array(
                        'type' => 'text',
                    ),
                    'driver_liscence_cat' => array(
                        'type' => 'text',
                    ),
                    'driver_liscence_expire' => array(
                        'type' => 'date',
                    ),
                    'vehicle_initial_impact' => array(
                        'type' => 'text',
                    ),
                    'vehicle_damage' => array(
                        'type' => 'text',
                    ),
                    'observation' => array(
                        'type' => 'text',
                    ),
                    'stationing' => array(
                        'type' => 'bool',
                    ),
                    'leaving_parking_spot' => array(
                        'type' => 'bool',
                    ),
                    'entering_parking_spot' => array(
                        'type' => 'bool',
                    ),
                    'entering_place' => array(
                        'type' => 'bool',
                    ),
                    'leaving_place' => array(
                        'type' => 'bool',
                    ),
                    'round_point' => array(
                        'type' => 'bool',
                    ),
                    'rear_damage_on_road' => array(
                        'type' => 'bool',
                    ),
                    'oposite_road_line' => array(
                        'type' => 'bool',
                    ),
                    'line_change' => array(
                        'type' => 'bool',
                    ),
                    'overtake' => array(
                        'type' => 'bool',
                    ),
                    'right_turn' => array(
                        'type' => 'bool',
                    ),
                    'left_turn' => array(
                        'type' => 'bool',
                    ),
                    'driving_backward' => array(
                        'type' => 'bool',
                    ),
                    'past_line' => array(
                        'type' => 'bool',
                    ),
                    'from_right' => array(
                        'type' => 'bool',
                    ),
                    'skip_priority' => array(
                        'type' => 'bool',
                    ),
                );

                return validateObject($Vehcile, $required);
            } catch (Exception $e) {
                throw new Exception("Vehicle -> {$e->getMessage()}", 1);
            }
        }
    }

?>
