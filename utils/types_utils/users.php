<?php

    /**
     * User class.
     */
    class User {
        public const USER = 'user';

        public const ASSURE = 'assure';

        public const POLICE = 'police';

        public const GESTIONNAIRE = 'gestionnaire';

        public const ADMIN = 'admin';

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
         * Constructor for the user.
         */
        public function __construct(array $rawUser) {
            if (isset($rawUser['type'],$rawUser['mail'],$rawUser['first_name'],$rawUser['last_name'],$rawUser['phone'])) {
                if (isset($rawUser['id'])) {
                    $this->id = $rawUser['id'];
                } else {
                    $this->id = uniqid();
                }
                $this->type = self::isValidUserType($rawUser['type']);
                $this->setMail($rawUser['mail']); // Email validation TODO
                $this->first_name = $rawUser['first_name'];
                $this->last_name = $rawUser['last_name'];
                if (isset($rawUser['password_hash'])) {
                    $this->password = $rawUser['password_hash'];
                } else {
                    $this->setPassword(random_bytes(12));
                }
            } else {
                throw new Exception("Array passed doesn't represend a User", 1);
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
                'password_hash' => $this->password,
            );
        }

        /**
         * Validate email and change it if valide.
         *
         * @param string $newMail
         */
        public function setMail($newMail) {
            if (filter_var($newMail, FILTER_VALIDATE_EMAIL)) {
                $this->mail = $newMail;
            } else {
                throw new Exception('Invalide email', 1);
            }
        }

        /**
         * Check if the type is valide then return it if so.
         *
         * @return string
         */
        public static function isValidUserType(string $type) {
            if (in_array($type, array(self::USER, self::ASSURE, self::POLICE, self::GESTIONNAIRE, self::ADMIN))) {
                return $type;
            }

            throw new Exception('Unknown User', 1);
        }

        /**
         * Instanciate the right class depending on the User.
         */
        public static function createUserByType(array $rawUser) {
            if (!isset($rawUser['type'])) {
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
        /**
         * User's phone number.
         *
         * @var string
         */
        protected $phone = '';

        protected $address = '';

        protected $zipCode = '';

        protected $contracts = array();

        public function __construct($rawUser) {
            if (isset($rawUser['phone'],$rawUser['address'],$rawUser['zip_code'])) {
                parent::__construct($rawUser);
                $this->type = User::ASSURE;
                $this->setPhone($rawUser['phone']);
                $this->address = $rawUser['address'];
                $this->zipCode = $rawUser['zip_code'];
                if (isset($rawUser['contracts'])) {
                    $this->contracts = $rawUser['contracts'];
                }
            } else {
                throw new Exception("Array passed doesn't represend a User Assuré", 1);
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
            $filtered_phone_number = filter_var($newPhone, FILTER_SANITIZE_NUMBER_INT);
            $phone_to_check = str_replace('-', '', $filtered_phone_number);
            if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
                return false;

                throw new Exception('Invald phone number', 1);
            }
            $this->phone = $newPhone;

            return true;
        }

        public function getAll() {
            return array_merge(parent::getAll(), array(
                'phone' => $this->phone,
                'contracts' => $this->contracts,
                'zip_code' => $this->zipCode,
                'address' => $this->address,
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
    }

?>
