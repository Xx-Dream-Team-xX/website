<?php

    class Sinistre {
        protected $id = '';

        protected $contract = '';

        protected $user = '';

        protected $assurance = '';

        public function __construct($rawUser) {
            if (isset($rawUser['contract'],$rawUser['user'],$rawUser['assurance'])) {
                $this->setPhone($rawUser['phone']);
                $this->address = $rawUser['address'];
                $this->zipCode = $rawUser['zip_code'];
                $this->rep = $rawUser['rep'];
                $this->assurance = $rawUser['assurance'];
                if (isset($rawUser['id'])) {
                    $this->id = $rawUser['id'];
                }
            } else {
                throw new Exception("Array passed doesn't represend a Sinistre", 1);
            }
        }
    }

?>
