<?php

    class Sinistre {
        protected $id = '';

        protected $user = '';

        protected $user_profession = '';

        protected $driver_profession = '';

        protected $driver_relationship = '';

        protected $driver_is_usual = true;

        protected $driver_user_same_residance = true;

        protected $driver_is_employeeof_user = false;

        protected $driver_reason_displacement = '';

        protected $driver_title = '';

        protected $incident_circumstances = '';

        protected $proces_verbal = false;

        protected $police_report = false;

        protected $main_courte = false;

        protected $police_station = '';

        protected $contract = '';

        protected $usual_parking_location = '';

        protected $garage_name = '';

        protected $garage_phone = '';

        protected $garage_email = '';

        protected $garage_alt_phone = '';

        protected $other_damage = '';

        protected $ingureds = array();

        public function __construct($rawSinistre) {
            if (isset($rawSinistre['contract'],$rawSinistre['user'],$rawSinistre['assurance'], $rawSinistre)) {
                $this->contract = $rawSinistre['contract'];
                $this->user = $rawSinistre['user'];
                $this->assurance = $rawSinistre['assurance'];
                if (isset($rawSinistre['id'])) {
                    $this->id = $rawSinistre['id'];
                } else {
                    $this->id = uniqid();
                }
            } else {
                throw new Exception("Array passed doesn't represend a Sinistre", 1);
            }
        }

        private function validateInjured(array $injured_list) {
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
