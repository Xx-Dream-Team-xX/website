<?php
/**
 * User authentification.
 */
    class Auth {
        private $path = "";

        public function checkPasswordFormat(string $pass) {

        }

        public function checkEmailFormat(string $email) {

        }

        public function checkPhoneFormat(string $phone) {

        }

        public function __construct(string $path) {
            if (file_exists($path)) {
                $this->path = $path;
            } else {
                throw new Exception("Specified database does not exist", 1);
            }
        }
    }
?>
