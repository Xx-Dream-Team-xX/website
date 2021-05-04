<?php

    class Contract {
        public const IDERROR = 1;

        public const CATERROR = 2;

        public const ARRAYERROR = 3;

        /**
         * UUID of the contract.
         *
         * @var string
         */
        private $id = '';

        /**
         * Array of userID concerned by this contract. The first user in the array will always be the main owner of the contract.
         *
         * @var array
         */
        private $contractOwners = array();

        /**
         * Time stamp of the start of validity of the contracr.
         *
         * @var int
         */
        private $startValidity = 0;

        /**
         * Time stamp of the end of validity of the contracr.
         *
         * @var int
         */
        private $endValidity = 0;

        /**
         * ID plate of the vehicle.
         *
         * @var string
         */
        private $vehicleID = '';

        /**
         * Insurance's contract ID.
         *
         * @var int
         */
        private $contractID = 0;

        /**
         * uwu
         */
        public function isMainOwner(string $id) {
            return ($this->contractOwners[0] === $id);
        }

        /**
         * InsuranceUUID.
         *
         * @var string
         */
        private $insuranceUUID = '';

        /**
         * Country/Insurance indentificator.
         *
         * @var string
         */
        private $countryCode = '';

        /**
         * Vehcle categorie.
         *
         * @var string
         */
        private $vehicleCat = '';

        /**
         * Manufacturer of the vehicle.
         *
         * @var string
         */
        private $vehicleManufacurer = '';

        /**
         * Array containing territorial validity of the contract.
         *
         * @var array
         */
        private $territoryValidity = array('a' => false);

        /**
         * Constructor for Contract.
         */
        public function __construct(array $rawContract) {
            if (isset($rawContract['owners'],$rawContract['start'],$rawContract['end'],$rawContract['vID'],$rawContract['contractID'],$rawContract['insurance'], $rawContract['countryCode'], $rawContract['category'],$rawContract['manufacturer'])) {
                if (isset($rawContract['id'])) {
                    $this->id = $rawContract['id'];
                } else {
                    $this->id = uniqid();
                }
                $this->contractOwners = $rawContract['owners'];
                $this->startValidity = $rawContract['start'];
                $this->endValidity = $rawContract['end'];
                $this->setVehicleID($rawContract['vID']);
                $this->contractID = $rawContract['contractID'];
                $this->insuranceUUID = $rawContract['insurance'];
                $this->countryCode = $rawContract['countryCode'];
                $this->setVCat($rawContract['category']);
                $this->vehicleManufacurer = $rawContract['manufacturer'];
            } else {
                throw new Exception('Contract given is missing some informations', self::ARRAYERROR);
            }
        }

        public function getAll() {
            return array(
                'id' => $this->id,
                'owners' => $this->contractOwners,
                'start' => $this->startValidity,
                'end' => $this->endValidity,
                'vID' => $this->vehicleID,
                'contractID' => $this->contractID,
                'insurance' => $this->insuranceUUID,
                'countryCode' => $this->countryCode,
                'category' => $this->vehicleCat,
                'manufacturer' => $this->vehicleManufacurer,
            );
        }

        public function getID() {
            return $this->id;
        }

        public function getOwners() {
            return $this->contractOwners;
        }

        /**
         * Validate phone number and set it if correct.
         *
         * @return bool false if invalid
         */
        public function setVehicleID(string $vID) {
            $sanitizedVID = str_replace('-', '', $vID);
            $sanitizedVID = strtoupper($sanitizedVID);
            if ((7 == strlen($sanitizedVID)) && !is_numeric(substr($sanitizedVID, 0, 2)) && is_numeric(substr($sanitizedVID, 2, 3)) && !is_numeric(substr($sanitizedVID, 5, 2))) {
                $this->vehicleID = $sanitizedVID;
            } else {
                throw new Exception('Invalid ID plate', self::IDERROR);
            }
        }

        public function addOwner(UserAssure $user) {
            array_push($this->contractOwners, $user->getID());
            if (!in_array($this->id, $user->getContracts())) {
                $user->addContract($this);
            }
        }

        /**
         * Check that a valide category is entered.
         *
         * @param string $cat vehicle category to check
         *
         * @return string or false if not valide
         */
        private function setVCat(string $cat) {
            if (in_array($cat, array('A', 'B', 'C', 'D', 'E', 'F', 'G'))) {
                $this->vehicleCat = $cat;
            } else {
                throw new Exception('Invalid Category', self::CATERROR);
            }
        }
    }

?>
