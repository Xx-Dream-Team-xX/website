<?php
/**
 * User authentification.
 */
    class Auth {

        private $path = "";

        public const INVALID_PHONE = 1;
        public const INVALID_ADDRESS = 2;
        public const INVALID_NAME = 3;
        public const INVALID_EMAIL = 4;

        private function checkPasswordFormat(string $pass) {
            return true;
        }

        private function checkEmailFormat(string $email) {
            return true;
        }

        private function checkPhoneFormat(string $phone) {
            return true;
        }

        private function checkNameFormat(string $name) {
            return true;
        }

        private function checkStreetFormat(string $street) {
            return true;
        }

        private function checkZipFormat(string $zip) {
            return true;
        }

        private function genPassword($l = 12) {
            return random_bytes($l);
        }

        public function __construct(string $path) {
            if (file_exists($path)) {
                $this->path = $path;
            } else {
                throw new Exception("Specified database does not exist", 1);
            }
        }

        private function assign(array $user) {
            $_SESSION["user"] = $user;
        }

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
