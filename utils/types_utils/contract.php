<?php

    class Contract {
        public static const IDERROR = 1;
        public static const CATERROR = 2;
        public static const ARRAYERROR = 3;

        /**
         * UUID of the contract
         *
         * @var string
         */
        private $id = "";

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
         * Constructor for Contract
         *
         * @param array $rawContract
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
                if (!$this->vehicleID = self::validateVID($rawContract['vID'])) {
                    throw new Exception('Invalid vehicle id', self::IDERROR);
                }
                $this->contractID = $rawContract['contractID'];
                $this->insuranceUUID = $rawContract['insurance'];
                $this->countryCode = $rawContract['countryCode'];
                if (!$this->vehicleCat = self::validateVCat($rawContract['category'])) {
                    throw new Exception('Invalid vehicle category.', self::CATERROR);
                }

                $this->vehicleManufacurer = $rawContract['manufacturer'];
            }
            else {
                throw new Exception("contract given is missing some informations", self::ARRAYERROR);
            }
        }

        private static function validateVID(string $vehicleID) {
            return $vehicleID;
        }

        /**
         * Check that a valide category is entered.
         *
         * @param string $vehicleCat vehicle category to check
         *
         * @return string or false if not valide
         */
        private static function validateVCat(string $vehicleCat) {
            if (in_array($vehicleCat, array('A', 'B', 'C', 'D', 'E', 'F', 'G'))) {
                return $vehicleCat;
            }

            return false;
        }
    }

?>
