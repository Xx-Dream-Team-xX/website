<?php

    include_once './utils/data.php';

    /**
     * Enum of possible user type
     */
    abstract class UserType {
        public const USER = "user";
        public const ASSURE = "assure";
        public const POLICE = "police";
        public const GESTIONNAIRE = "gestionnaire";
        public const ADMIN = "admin";

        /**
         * Check if the type is valide then return it if so
         *
         * @param string $type
         * @return string
         */
        public static function isValide(string $type) {
            if (in_array($type, array("user","assure","police","gestionnaire", "admin"))) {

                return $type;
            } else {
                throw new Exception("Unknown UserType", 1);
            }
        }

        /**
         * Instanciate the right class depending on the UserType
         *
         * @param array $rawUser
         * @return void
         */
        public static function createUserByType(array $rawUser) {
            switch ($rawUser['type']) {
                case UserType::USER:
                    return new User($rawUser['type'], $rawUser['mail'],$rawUser['first_name'], $rawUser['last_name'], $rawUser['id']);
                    break;
                case UserType::ASSURE:
                    return new UserAssure($rawUser['type'], $rawUser['mail'],$rawUser['first_name'], $rawUser['last_name'], $rawUser['id']);
                    break;
                default:
                    return new User($rawUser['type'], $rawUser['mail'],$rawUser['first_name'], $rawUser['last_name'], $rawUser['id']);
                    break;
            }
        }
    }

    /**
     * User class
     */
    class User {
        private $id = "";
        private $mail = "";
        private $type = "";
        private $first_name = "";
        private $last_name = "";

        /**
         * Constructor for the user
         *
         * @param UserType type of user
         * @param string e-mail of the user
         * @param string $first_name
         * @param string $last_name
         */
        public function __construct(string $type,string $mail,string $first_name,string $last_name, string $id)
        {
            $this->id = $id;
            $this->type = UserType::isValide($type);
            $this->setMail($mail); // Email validation TODO
            $this->first_name = $first_name;
            $this->last_name = $last_name;
        }

        /**
         * Get user first name and last name
         *
         * @return array Array containing the user first and last name
         */
        public function getName() {

            return array($this->first_name, $this->last_name);
        }

        /**
         * Get user id
         *
         * @return string
         */
        public function getID() {

            return $this->id;
        }

        /**
         * Get user type
         *
         * @return UserType
         */
        public function getType() {
            return $this->type;
        }

        /**
         * Get user mail
         *
         * @return string
         */
        public function getMail() {

            return $this->mail;
        }

        /**
         * Get every user data in a array map
         *
         * @return array
         */
        public function getAll() {
            return array(
                "id" => $this->id,
                "type" => $this->type,
                "mail" => $this->mail,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name
            );
        }

        /**
         * Validate email and change it if valide
         *
         * @param string $newMail
         * @return void
         */
        public function setMail($newMail) {
            if (filter_var($newMail, FILTER_VALIDATE_EMAIL)) {
                $this->mail = $newMail;
            } else {
                throw new Exception("Invalide email", 1);
            }
        }
    }

    class UserAssure extends User {

        public function __construct(string $password,...$userInfo)
        {
            parent::__construct($password ,...$userInfo);
        }
    }

?>
