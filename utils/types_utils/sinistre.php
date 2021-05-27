<?php

    include_once get_path('utils', 'forms.php');

    class Sinistre {
        public static $required = array(
            'contract' => array(
                'type' => 'text',
            ),
            'user' => array(
                'type' => 'text',
            ),
            'user_profession' => array(
                'type' => 'text',
            ),
            'driver_profession' => array(
                'type' => 'text',
            ),
            'driver_relationship' => array(
                'type' => 'preselection',
                'options' => array(
                    'married',
                    'celib',
                    'other',
                ),
            ),
            'driver_user_same_residance' => array(
                'type' => 'bool',
            ),
            'driver_is_usual' => array(
                'type' => 'bool',
            ),
            'driver_is_employeeof_user' => array(
                'type' => 'bool',
            ),
            'driver_disp_reason' => array(
                'type' => 'text',
            ),
            'circumstances' => array(
                'type' => 'text',
            ),
            'proces_verbal' => array(
                'type' => 'bool',
            ),
            'police_report' => array(
                'type' => 'bool',
            ),
            'main_courante' => array(
                'type' => 'bool',
            ),
            'police_station' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'usual_parking_location' => array(
                'type' => 'text',
            ),
            'garage_name' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'garage_phone' => array(
                'type' => 'phone',
                'optional' => true,
            ),
            'garage_email' => array(
                'type' => 'email',
                'optional' => true,
            ),
            'garage_alt_phone' => array(
                'type' => 'phone',
                'optional' => true,
            ),
            'other_damage' => array(
                'type' => 'text',
                'optional' => true,
            ),
            'injureds' => array(
                'type' => 'array',
                'optional' => true,
            ),
            'constat' => array(
                'type' => 'array',
                'optional' => true,
            ),
        );

        /**
         * Construct and vaidate a sinistre.
         *
         * @param array $rawSinistre Array representing a sinistre. Must contain the entries listed in $this->required
         *                           On top of them those entries can be added :
         *                           'garage_name', 'garage_phone'
         */
        public static function construct(array $rawSinistre) {
            if ($rawSinistre = validateObject($rawSinistre, self::$required)) {
                // if (isset($rawSinistre['injureds'])) {
                //     $rawSinistre['injureds'] = self::validateInjured($rawSinistre['injureds']);
                // }
                // if (isset($rawSinistre['constat'])) {
                //     $rawSinistre['constat'] = self::validateConstat($rawSinistre['constat']);
                // }
                $rawSinistre['id'] = uniqid();

                return $rawSinistre;
            }

            throw new Exception("Array passed doesn't represend a Sinistre", 1);
        }

        /**
         * Validate injured list.
         *
         * @return array|bool false if not valid
         */
        public static function validateInjured(array $injured) {
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

                return validateObject($injured, $required);
            } catch (Exception $e) {
                throw new Exception("Injured list -> {$e->getMessage()}", 1);
            }
        }

        public static function validateConstat(array $constat) {
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
                    // 'vehicles' => array(
                    //     'type' => 'array',
                    // ),
                );

                return validateObject($constat, $required);
                // foreach ($constat['vehicles'] as $key => &$vehicle) {
                //     $vehicle = self::validateConstatVehicle($constat['vehicle_A']);
                // }
            } catch (Exception $e) {
                throw new Exception("Constat -> {$e->getMessage()}", 1);
            }
        }

        public static function validateConstatVehicle(array $Vehcile) {
            try {
                $required = array(
                    'user' => array(
                        'type' => 'text',
                    ),
                    'contract' => array(
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
                        'optional' => true,
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
