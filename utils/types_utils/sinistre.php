<?php

    class Ingured {
        public const CONDUCTEUR = 0;

        public const PASSAGER = 1;

        public const CYCLISTE = 2;

        public const PIETON = 3;

        protected $lastname = '';

        protected $firstname = '';

        protected $address = '';

        protected $phone = '';

        protected $profession = '';

        protected $incident_situation = '';

        protected $belt = true;

        protected $injuries = '';

        private $required = array(
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
                'type' => 'text',
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

        public function __construct($rawInjured) {
            if (isset($rawInjured['lastname'],$rawInjured['firstname'], $rawInjured['address'], $rawInjured['phone'],$rawInjured['profession'],$rawInjured['belt'],$rawInjured['injuries'])) {
            } else {
                throw new Exception("Array passed doesn't represend a Sinistre", 1);
            }
        }
    }

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
    }

?>
