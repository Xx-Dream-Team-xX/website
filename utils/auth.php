<?php
/**
 * User authentification.
 */
    class Auth {

        /**
         * Path of the auth database
         *
         * @var string
         */
        private $path = "";

        /**
         * Error codes
         */
        public const INVALID_PHONE = 1;
        public const INVALID_ADDRESS = 2;
        public const INVALID_NAME = 3;
        public const INVALID_EMAIL = 4;

        /**
         * Regex check for specific type
         *
         * @param string $pass
         * @return void
         */
        private function checkPasswordFormat(string $pass) {
            return true;
        }

        /**
         * Regex check for specific type
         *
         * @param string $email
         * @return void
         */
        private function checkEmailFormat(string $email) {
            return true;
        }

        /**
         * Regex check for specific type
         *
         * @param string $phone
         * @return void
         */
        private function checkPhoneFormat(string $phone) {
            return true;
        }

        /**
         * Regex check for specific type
         *
         * @param string $name
         * @return void
         */
        private function checkNameFormat(string $name) {
            return true;
        }

        /**
         * Regex check for specific type
         *
         * @param string $street
         * @return void
         */
        private function checkStreetFormat(string $street) {
            return true;
        }

        /**
         * Regex check for specific type
         *
         * @param string $zip
         * @return void
         */
        private function checkZipFormat(string $zip) {
            return true;
        }

        /**
         * Generates a password
         *
         * @param integer $l
         * @return void
         */
        private function genPassword($l = 12) {
            return random_bytes($l);
        }

        /**
         * Initialization, sets auth path
         *
         * @param string $path DB path
         */
        public function __construct(string $path) {
            if (file_exists($path)) {
                $this->path = $path;
            } else {
                throw new Exception("Specified database does not exist", 1);
            }
        }

        /**
         * Assigns user session to user account
         *
         * @param array $user Array of user data
         * @return void
         */
        private function assign(array $user) {
            $_SESSION["user"] = $user;
        }

        /**
         * Logs in a user
         *
         * @param string $email provided email
         * @param string $password provided password (plain text)
         * @return bool if success
         */
        public function login(string $email, string $password) {
            if ($this->checkEmailFormat($email) && $this->checkPasswordFormat($password)) {
                $user = DB::getUserByMail($this->path, $email);
                if ($user && password_verify($password, $user["password_hash"])) {
                    $this->assign($user);
                    return true;
                }
            }
            return false;
        }

        /**
         * Registers a new user, generates random password
         *
         * @param array $user user data array
         * @return array success and random password OR error and error code
         */
        public function register(array $user) {
            $error = 0;
            if ($this->checkEmailFormat($user["mail"])) {
                if ($this->checkNameFormat($user["first_name"]) && $this->checkNameFormat($user["last_name"])) {
                    if ($this->checkStreetFormat($user["address"]) && $this->checkZipFormat($user["zip"])) {
                        if ($this->checkPhoneFormat($user["phone"])) {
                            $password = $this->genPassword();
                            $user["password"] = $password;
                            $user = User::createUserByType($user);
                            DB::setObject($this->path, $user->getAll(), true);
                            return array(
                                'success' => true,
                                'password' => $password
                            );
                        }
                        $error = self::INVALID_PHONE;
                    }
                    $error = self::INVALID_ADDRESS;
                }
                $error = self::INVALID_NAME;
            }
            $error = self::INVALID_EMAIL;

            return array(
                'success' => false,
                'message' => $error
            );
        }
    }
?>
