<?php

    class Assurance {
        protected $id = '';

        protected $name = '';

        protected $phone = '';

        protected $logoPath = '';

        protected $contracts = array();

        protected $gestionnaires = array();

        public function __construct($rawAssur) {
            if (isset($rawAssur['name'],$rawAssur['phone'])) {
                if (isset($rawAssur['id'])) {
                    $this->id = $rawAssur['id'];
                } else {
                    $this->id = uniqid();
                }
                $this->phone = $rawAssur['phone'];
                $this->name = $rawAssur['name'];
                if (isset($rawAssur['contracts'])) {
                    $this->contracts = $rawAssur['contracts'];
                }
                if (isset($rawAssur['gestionnaires'])) {
                    $this->gestionnaires = $rawAssur['gestionnaires'];
                }
            } else {
                throw new Exception("Array passed doesn't represend a User Assuré", 1);
            }
        }

        public function newContract(array $rawContract) {
            $rawContract['insurance'] = $this->id;
            $contract = new Contract($rawContract);
            array_push($this->contracts, $contract->getID());

            return $contract;
        }

        public function newGestionnaire(array $rawGestionnaires) {
            $rawGestionnaires['assurance'] = $this->id;
            $rawGestionnaires['type'] = User::GESTIONNAIRE;
            $gestionnaire = new UserGestionnaire($rawGestionnaires);
            array_push($this->gestionnaires, $gestionnaire->getID());

            return $gestionnaire;
        }

        public function getContracts() {
            return $this->contracts;
        }

        public function getGestionnaires() {
            return $this->gestionnaires;
        }

        public function getName() {
            return $this->name;
        }

        public function getPhone() {
            return $this->phone;
        }

        public function getID() {
            return $this->id;
        }

        public function getLogo() {
            return $this->logoPath;
        }

        public function getAll() {
            return array(
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'contracts' => $this->contracts,
                'gestionnaires' => $this->gestionnaires,
                'logoPath' => $this->logoPath,
            );
        }
    }

?>
