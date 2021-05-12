<?php

    class Sinistre {
        protected $id = '';

        /**
         * Id of the contract concerned.
         *
         * @var string
         */
        protected $contract = '';

        /**
         * Id of the User concerned.
         *
         * @var string
         */
        protected $user = '';

        /**
         * Id of the insurance rep concerned.
         *
         * @var string
         */
        protected $user_rep = '';

        /**
         * Location where the incident happend.
         *
         * @var string
         */
        protected $sinistre_location = '';

        /**
         * Current location of the vehicle.
         *
         * @var string
         */
        protected $vehicle_location = '';

        /**
         * List of attached files id.
         *
         * @var array
         */
        protected $joined_documents = array();

        /**
         * Desc of the incident.
         *
         * @var string
         */
        protected $desc = '';

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
