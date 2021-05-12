<?php
/**
 * User authentification.
 */

include_once get_path('utils', 'types_utils/users.php');

class Auth {
        /**
         * Error codes.
         */
        public const INVALID_PHONE = 1;

        public const INVALID_ADDRESS = 2;

        public const INVALID_NAME = 3;

        public const INVALID_EMAIL = 4;

        /**
         * Path of the auth database.
         *
         * @var string
         */
        private $path = '';

        /**
         * Initialization, sets auth path.
         *
         * @param string $path DB path
         */
        public function __construct(string $path) {
            if (file_exists($path)) {
                $this->path = $path;
            } else {
                throw new Exception('Specified database does not exist', 1);
            }
        }

        /**
         * Logs in a user.
         *
         * @param string $email    provided email
         * @param string $password provided password (plain text)
         *
         * @return bool if success
         */
        public function login(string $email, string $password) {
            if (User::checkEmail($email) && $this->checkPasswordFormat($password)) {
                $user = DB::getUserByMail($this->path, $email);
                if ($user && password_verify($password, $user['password_hash'])) {
                    $this->assign($user);

                    return true;
                }
            }

            return false;
        }

        /**
         * Registers a new user, generates random password.
         *
         * @param array $user user data array
         *
         * @return array success and random password OR error and error code
         */
        public function register(array $user) {
            $error = 0;
            if (User::checkEmail($user['mail'])) {
                if ($this->checkNameFormat($user['first_name']) && $this->checkNameFormat($user['last_name'])) {
                    if ($this->checkStreetFormat($user['address']) && $this->checkZipFormat($user['zip'])) {
                        if (User::checkPhone($user['phone'])) {
                            $password = $this->genPassword();
                            $user['password'] = $password;
                            $user = User::createUserByType($user);
                            DB::setObject($this->path, $user->getAll(), true);

                            return array(
                                'success' => true,
                                'password' => $password,
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
                'message' => $error,
            );
        }

        /**
         * Regex check for specific type.
         */
        private function checkPasswordFormat(string $pass) {
            return true;
        }

        /**
         * Regex check for specific type.
         */
        private function checkNameFormat(string $name) {
            return true;
        }

        /**
         * Regex check for specific type.
         */
        private function checkStreetFormat(string $street) {
            return true;
        }

        /**
         * Regex check for specific type.
         */
        private function checkZipFormat(string $zip) {
            return true;
        }

        /**
         * Generates a password.
         *
         * @param int $l
         */
        private function genPassword($l = 12) {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < $l; ++$i) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }

            return implode($pass); //turn the array into a string
        }

        /**
         * Assigns user session to user account.
         *
         * @param array $user Array of user data
         */
        private function assign(array $user) {
            $_SESSION['user'] = (new User($user))->getAll();
        }
    }
?>
