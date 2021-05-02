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
        public function __construct(string $type,string $mail,string $first_name,string $last_name, string ...$id)
        {
            if (isset($id)) {
                $this->id = $id[0];
            } else {
                $this->id = uniqid();
            }
            $this->type = UserType::isValide($type);
            $this->mail = $this->setMail($mail); // Email validation TODO
            $this->first_name = $first_name;
            $this->last_name = $last_name;
        }

        public function getName() {

            return array($this->first_name, $this->last_name);
        }

        public function getID() {

            return $this->id;
        }

        public function getType() {
            return $this->type;
        }

        public function getMail() {

            return $this->mail;
        }

        public function getAll() {
            return array(
                "id" => $this->id,
                "type" => $this->type,
                "mail" => $this->mail,
                "firs_name" => $this->first_name,
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
?>
