<?php

    /**
     * Enum of possible user type.
     */
    abstract class UserType {
        public const USER = 'user';

        public const ASSURE = 'assure';

        public const POLICE = 'police';

        public const GESTIONNAIRE = 'gestionnaire';

        public const ADMIN = 'admin';

        /**
         * Check if the type is valide then return it if so.
         *
         * @return string
         */
        public static function isValide(string $type) {
            if (in_array($type, array('user', 'assure', 'police', 'gestionnaire', 'admin'))) {
                return $type;
            }

            throw new Exception('Unknown UserType', 1);
        }

        /**
         * Instanciate the right class depending on the UserType.
         */
        public static function createUserByType(array $rawUser) {
            switch ($rawUser['type']) {
                case UserType::USER:
                    return new User($rawUser);

                    break;
                case UserType::ASSURE:
                    return new UserAssure($rawUser);

                    break;
                default:
                    return new User($rawUser);

                    break;
            }
        }
    }

    /**
     * User class.
     */
    class User {
        /**
         * User id.
         *
         * @var string
         */
        private $id = '';

        /**
         * User's E-mail.
         *
         * @var string
         */
        private $mail = '';

        /**
         * User's Type.
         *
         * @var string
         */
        private $type = '';

        /**
         * User's first name.
         *
         * @var string
         */
        private $first_name = '';

        /**
         * User's last name.
         *
         * @var string
         */
        private $last_name = '';

        /**
         * Constructor for the user.
         *
         * @param array $rawUser Array containing every info needed to build a user
         */
        public function __construct(array $rawUser) {
            if (isset($rawUser['type'],$rawUser['mail'],$rawUser['first_name'],$rawUser['last_name'],$rawUser['phone'])) {
                if (isset($rawUser['id'])) {
                    $this->id = $rawUser['id'];
                } else {
                    $this->id = uniqid();
                }
                $this->type = UserType::isValide($rawUser['type']);
                $this->setMail($rawUser['mail']); // Email validation TODO
                $this->first_name = $rawUser['first_name'];
                $this->last_name = $rawUser['last_name'];
            } else {
                throw new Exception("Array passed doesn't represend a User", 1);
            }
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
         * @return UserType
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
    }

    class UserAssure extends User {
        /**
         * User's phone number.
         *
         * @var string
         */
        private $phone = '';

        private $contracts = array();

        public function __construct($rawUser) {
            parent::__construct($rawUser);
            $this->setPhone($rawUser['phone']);
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
            ));
        }

        public function addContract() {
        }
    }

?>
