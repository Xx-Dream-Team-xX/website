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
            'main_courrante' => array(
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
        );

        protected $id = '';

        protected $user = '';

        protected $user_profession = '';

        protected $driver_profession = '';

        protected $driver_relationship = '';

        protected $driver_is_usual = true;

        protected $driver_user_same_residance = true;

        protected $driver_is_employeeof_user = false;

        protected $driver_reason_displacement = '';

        protected $incident_circumstances = '';

        protected $proces_verbal = false;

        protected $police_report = false;

        protected $main_courrante = false;

        protected $police_station = '';

        protected $contract = '';

        protected $usual_parking_location = '';

        protected $garage_name = '';

        protected $garage_phone = '';

        protected $garage_email = '';

        protected $garage_alt_phone = '';

        protected $other_damage = '';

        protected $ingureds = array();

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
                    self::validateInjured($rawSinistre['injureds']);
                }
                send_json($rawSinistre);
            } else {
                throw new Exception("Array passed doesn't represend a Sinistre", 1);
            }
        }

        private static function validateInjured(array &$injured_list) {
            $required = array(
                'firstname' => array(
                    'type' => 'text',
                ),
                'lastname' => array(
                    'type' => 'text',
                ),
                'address' => array(
                    'type' => 'date',
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
                if (!$injured = validateObject($injured, $required)) {
                    return false;
                }
            }

            return $injured_list;
        }
    }

?>
