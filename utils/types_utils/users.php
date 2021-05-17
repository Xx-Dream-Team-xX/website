<?php

    /**
     * User class.
     */
    class User {
        public const NONE = 0;

        public const ASSURE = 1;

        public const POLICE = 2;

        public const GESTIONNAIRE = 3;

        public const ADMIN = 4;

        /**
         * User id.
         *
         * @var string
         */
        protected $id = '';

        /**
         * User's E-mail.
         *
         * @var string
         */
        protected $mail = '';

        /**
         * User's Type.
         *
         * @var string
         */
        protected $type = '';

        /**
         * User's first name.
         *
         * @var string
         */
        protected $first_name = '';

        /**
         * User's last name.
         *
         * @var string
         */
        protected $last_name = '';

        /**
         * Password.
         *
         * @var string
         */
        protected $password = '';

        /**
         * User's phone number.
         *
         * @var string
         */
        protected $phone = '';

        /**
         * Constructor for the user.
         */
        public function __construct(array $rawUser) {
            if (isset($rawUser['type'],$rawUser['mail'],$rawUser['first_name'],$rawUser['last_name'],$rawUser['phone'])) {
                if (isset($rawUser['id'])) {
                    $this->id = $rawUser['id'];
                } else {
                    $this->id = uniqid();
                }
                $this->setPhone($rawUser['phone']);
                $this->type = self::isValidUserType($rawUser['type']);
                $this->mail = $rawUser['mail'];
                $this->first_name = $rawUser['first_name'];
                $this->last_name = $rawUser['last_name'];
                if (isset($rawUser['password_hash'])) {
                    $this->password = $rawUser['password_hash'];
                } else if (isset($rawUser['password'])) {
                    $this->setPassword($rawUser['password']);
                } else {
                    throw new Exception('Please specify a password', 1);
                }
            } else {
                throw new Exception("Array passed doesn't represent an User", 1);
            }
        }

        public function setPassword(string $password) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }

        /**
         * Get user first name and last name.
         *
         * @return array Array containing the user first and last name
         */
        public function getName() {
            return array($this->first_name, $this->last_name);
        }

        /**
         * Get user id.
         *
         * @return string
         */
        public function getID() {
            return $this->id;
        }

        /**
         * Get user type.
         *
         * @return User
         */
        public function getType() {
            return $this->type;
        }

        /**
         * Get user mail.
         *
         * @return string
         */
        public function getMail() {
            return $this->mail;
        }

        public function getPhone() {
            return $this->phone;
        }

        /**
         * Get every user data in a array map.
         *
         * @return array
         */
        public function getAll() {
            return array(
                'id' => $this->id,
                'type' => $this->type,
                'mail' => $this->mail,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'password_hash' => $this->password,
            );
        }

        public function getPublic() {
            $all = $this->getAll();
            unset($all['password_hash']);

            return $all;
        }

        /**
         * Check if email passed is valide.
         *
         * @return bool
         */
        public static function checkEmail(?string $email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        /**
         * Check if phone is valide.
         *
         * @return bool
         */
        public static function checkPhone(?string $phone, int $minDigits = 9, int $maxDigits = 14) {
            if (preg_match('/^[+][0-9]/', $phone)) {
                $count = 1;
                $phone = str_replace(array('+'), '', $phone, $count);
            }
            $phone = str_replace(array(' ', '.', '-', '(', ')'), '', $phone);

            return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $phone);
        }

        /**
         * Validate email and change it if valide.
         *
         * @param string $newMail
         */
        public function setMail($newMail) {
            if (self::checkEmail($newMail)) {
                $this->mail = $newMail;
            } else {
                throw new Exception('Invalid mail', 1);
            }
        }

        /**
         * Validate phone number and set it if correct.
         *
         * @param string $newPhone Phone number to set
         *
         * @return bool false if invalid
         */
        public function setPhone(string $newPhone) {
            if (self::checkPhone($newPhone)) {
                $this->phone = str_replace(array(' ', '.', '-', '(', ')'), '', $newPhone);

                return true;
            }

            return false;
        }

        /**
         * Check if the type is valide then return it if so.
         *
         * @return string
         */
        public static function isValidUserType(string $type) {
            if (in_array($type, array(self::NONE, self::ASSURE, self::POLICE, self::GESTIONNAIRE, self::ADMIN))) {
                return $type;
            }

            throw new Exception('Unknown User Type', 1);
        }

        /**
         * Instanciate the right class depending on the User.
         */
        public static function createUserByType(array $rawUser) {
            if (!isset($rawUser['type'])) {
                $rawUser['type'] = self::NONE;

                return new User($rawUser);
            }
            switch ($rawUser['type']) {
                case self::ASSURE:
                    return new UserAssure($rawUser);

                    break;
                default:
                    return new User($rawUser);

                    break;
            }
        }
    }

    class UserAssure extends User {
        protected $address = '';

        protected $zipCode = '';

        protected $rep = '';

        protected $assurance = '';

        protected $birth = 0;

        protected $contracts = array();

        public function __construct($rawUser) {
            if (isset($rawUser['birth'],$rawUser['address'],$rawUser['zip_code'],$rawUser['rep'],$rawUser['assurance'])) {
                parent::__construct($rawUser);
                $this->type = User::ASSURE;
                $this->address = $rawUser['address'];
                $this->zipCode = $rawUser['zip_code'];
                $this->rep = $rawUser['rep'];
                $this->assurance = $rawUser['assurance'];
                if (isset($rawUser['contracts'])) {
                    $this->contracts = $rawUser['contracts'];
                }
                if (gettype('int' != $rawUser['birth'])) {
                    $this->setBirth($rawUser['birth']);
                } else {
                    $this->birth = $rawUser['birth'];
                }
            } else {
                throw new Exception("Array passed doesn't represend a User Assuré", 1);
            }
        }

        public function getAll() {
            return array_merge(parent::getAll(), array(
                'contracts' => $this->contracts,
                'zip_code' => $this->zipCode,
                'address' => $this->address,
                'birth' => $this->birth,
            ));
        }

        public function getContracts() {
            return $this->contracts;
        }

        public function addContract(Contract $contract) {
            array_push($this->contracts, $contract->getID());
            if (!in_array($this->id, $contract->getOwners())) {
                $contract->addOwner($this);
            }
        }

        public function setBirth(string $date) {
            if ($date = DateTime::createFromFormat('d/m/Y', $date)) {
                $this->birth = $date->getTimestamp;

                return true;
            }

            return false;
        }
    }

    class UserGestionnaire extends User {
        protected $assurance = '';

        public function __construct($rawUser) {
            if (isset($rawUser['assurance'])) {
                parent::__construct($rawUser);
                $this->type = User::GESTIONNAIRE;
                $this->assurance = $rawUser['assurance'];
            } else {
                throw new Exception("Array passed doesn't represend a User Gestionnaire", 1);
            }
        }

        public function getAll() {
            return array_merge(parent::getAll(), array(
                'contracts' => $this->contracts,
                'assurance' => $this->assurance,
            ));
        }

        public function newUserAssure($rawAssure) {
            $rawAssure['rep'] = $this->id;
            $rawAssure['type'] = User::ASSURE;
            $rawAssure['assurance'] = $this->assurance;

            return new UserAssure($rawAssure);
        }
    }

?>
