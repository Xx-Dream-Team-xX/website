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
    private $owners = array();

    /**
     * Time stamp of the start of validity of the contracr.
     *
     * @var int
     */
    private $start = 0;

    /**
     * Time stamp of the end of validity of the contracr.
     *
     * @var int
     */
    private $end = 0;

    /**
     * ID plate of the vehicle.
     *
     * @var string
     */
    private $vID = '';

    /**
     * InsuranceUUID.
     *
     * @var string
     */
    private $insuranceID = '';

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
    private $category = '';

    /**
     * Manufacturer of the vehicle.
     *
     * @var string
     */
    private $manufacturer = '';

    /**
     * Array containing territorial validity of the contract.
     *
     * @var array
     */
    private $territoryValidity = array();

    /**
     * Constructor for Contract.
     */
    public function __construct(array $rawContract) {
        if (isset($rawContract['id'],$rawContract['owners'],$rawContract['start'],$rawContract['end'],$rawContract['vID'],$rawContract['insurance'], $rawContract['countryCode'], $rawContract['category'],$rawContract['manufacturer'])) {
            $this->owners = $rawContract['owners'];
            $this->start = $rawContract['start'];
            $this->end = $rawContract['end'];
            $this->vID = $rawContract['vID'];
            $this->id = $rawContract['id'];
            $this->insuranceID = $rawContract['insurance'];
            $this->countryCode = $rawContract['countryCode'];
            $this->setVCat($rawContract['category']);
            $this->manufacturer = $rawContract['manufacturer'];
            if (isset($rawContract['terVal'])) {
                $this->setTerVal($rawContract['terVal']);
            }
        } else {
            throw new Exception('Contract given is missing some informations', self::ARRAYERROR);
        }
    }

    /**
     * Check if user is Main owner of the contract.
     *
     * @param string $id Id of the user to check
     *
     * @return bool
     */
    public function isMainOwner(string $id) {
        return $this->owners[0] === $id;
    }

    public function getAll() {
        return array(
            'id' => $this->id,
            'owners' => $this->owners,
            'start' => $this->start,
            'end' => $this->end,
            'vID' => $this->vID,
            'insurance' => $this->insuranceID,
            'countryCode' => $this->countryCode,
            'category' => $this->category,
            'manufacturer' => $this->manufacturer,
            'terVal' => $this->territoryValidity,
        );
    }

    public function getID() {
        return $this->id;
    }

    public function getOwners() {
        return $this->owners;
    }

    public function getAssurance() {
        return $this->insuranceID;
    }

    /**
     * Add an owner to the contract.
     *
     * @param UserAssure $user User to add
     */
    public function addOwner(UserAssure $user) {
        array_push($this->owners, $user->getID());
        if (!in_array($this->id, $user->getContracts())) {
            $user->addContract($this);
        }
    }

    /**
     * Validate and update territorial validity.
     */
    public function setTerVal(array $terVal) {
        foreach ($terVal as $ter => $validity) {
            $ter = strtoupper($ter);
            if (!in_array($ter, array('A', 'B', 'BG', 'CY', 'CZ', 'D', 'DK', 'E', 'EST', 'F', 'FIN', 'GB', 'GR', 'H', 'HR', 'I', 'IRL', 'IS', 'L', 'LT', 'LV', 'M', 'N', 'NL', 'P', 'PL', 'RO', 'S', 'SK', 'SLO', 'CH', 'AL', 'AND', 'AZ', 'BIH', 'BY', 'IL', 'IR', 'MA', 'MD', 'MK', 'MNE', 'RUS', 'SRB', 'TN', 'TR', 'UA'))) {
                $this->territoryValidity = $terVal;

                return false;
            }
        }
        $this->territoryValidity = array_merge($this->territoryValidity, $terVal);

        return true;
    }

    /**
     * Check that a valide category is entered.
     *
     * @param string $cat vehicle category to check
     *
     * @return string or false if not valide
     */
    private function setVCat(string $cat) {
        $cat = strtoupper($cat);
        if (in_array($cat, array('A', 'B', 'C', 'D', 'E', 'F', 'G'))) {
            $this->category = $cat;
        } else {
            throw new Exception('Invalid Category', self::CATERROR);
        }
    }
}

?>
