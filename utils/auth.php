<?php
/**
 * User authentification.
 */
include_once get_path('utils', 'types_utils/users.php');
include_once get_path('utils', 'forms.php');

class Auth {
    /**
     * Error codes.
     */
    public const INVALID_PHONE = 1;

    public const INVALID_ADDRESS = 2;

    public const INVALID_NAME = 3;

    public const INVALID_EMAIL = 4;

    public const INVALID_LOGIN = 5;

    public const INVALID_PASSWORD = 6;

    public const MISSING_INFORMATION = 7;

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
        if (User::checkEmail($email)) {
            $user = DB::getUserByMail($this->path, $email);
            if ($user && password_verify($password, $user['password_hash'])) {
                $this->assign($user);

                $_SERVER["logger"]->log(2, whois() . "successfully logged in");
                return true;
            }
        }

        $_SERVER["logger"]->log(1, whois() . "Failed login");
        return false;
    }

    /**
     * Registers a new user, generates random password.
     *
     * @param array  $user   user data array
     * @param string $author id of who executed the action
     * @param int    $type   Type of user to create
     *
     * @return array success and random password OR error and error code
     */
    public function register(array $user, string $author, int $type = User::ASSURE) {
        $r = array(
            array(
                'mail' => array(
                    'type' => 'email',
                ),
                'first_name' => array(),
                'last_name' => array(),
                'phone' => array(
                    'type' => 'phone'
                ),
            ),
            array(
                'address' => array(),
                'zip_code' => array(
                    'type' => 'zipcode'
                ),
                'birth' => array(
                    'type' => 'date'
                ),
                'assurance' => array(),
            ),
            array(),
            array(
                'assurance' => array(),
            ),
        );

        try {
            $user = validateObject($user, array_merge($r[0], $r[$type]));
        } catch (\Throwable $th) {
            $user = false;
        }
        
        $error = self::MISSING_INFORMATION;
        if ($user) {
            $user['type'] = $type;

            $error = self::INVALID_EMAIL;
            if ((User::checkEmail($user['mail'])) && (false === DB::getUserByMail($this->path, $user['mail']))) {
                $error = self::INVALID_NAME;
                if ($this->checkNameFormat($user['first_name'] . " " . $user['last_name'])) {
                    if (User::ASSURE === $type) {
                        $user['rep'] = $author;

                        $error = self::INVALID_ADDRESS;
                        if ($this->checkStreetFormat($user['address']) && $this->checkZipFormat($user['zip_code'])) {
                            $error = self::INVALID_PHONE;
                            if (User::checkPhone($user['phone'])) {
                                $password = $this->genPassword();
                                $user['password'] = $password;
                                $user = User::createUserByType($user);
                                DB::setObject($this->path, $user->getAll(), true);

                                $_SERVER["logger"]->log(3, whois() . "successfully created new customer account '" . $user->getID());

                                return array(
                                    'success' => true,
                                    'password' => $password,
                                );
                            }
                        }
                    } else {
                        $password = $this->genPassword();
                        $user['password'] = $password;
                        $user = User::createUserByType($user);
                        DB::setObject($this->path, $user->getAll(), true);

                        $_SERVER["logger"]->log(4, whois() . "successfully created elevated user '" . $user->getID() . "' (type " . $type . ")");

                        return array(
                            'success' => true,
                            'password' => $password,
                        );
                    }
                }
            }
        }

        $_SERVER["logger"]->log(2, whois() . "Failed user creation");

        return array(
            'success' => false,
            'message' => $error,
        );
    }

    /**
     * Changes password and/or email for user with specified id, checks current.
     *
     * @param string $id           id of user
     * @param string $email        new (or old) email
     * @param string $password     current password
     * @param string $new_password new password
     *
     * @return array success or failure and error code
     */
    public function changePassword(string $id, ?string $email, ?string $password, ?string $new_password = null) {
        $user = DB::getFromID($this->path, $id);
        $error = self::INVALID_LOGIN;
        if ($user && password_verify($password, $user['password_hash'])) {
            $error = 0;
            if ($email !== $user['mail']) {
                $error = self::INVALID_EMAIL;
                if (User::checkEmail($email)) {
                    $user['mail'] = $email;
                    $error = 0;
                }
            }
            if (!$error && isset($new_password)) {
                $error = self::INVALID_PASSWORD;
                if ($this->checkPasswordFormat($new_password)) {
                    unset($user['password_hash']);
                    $user['password'] = $new_password;
                    $error = 0;
                }
            }
        }
        if ($error > 0) {

            $_SERVER["logger"]->log(3, whois() . "failed to change account information");

            return array(
                'success' => false,
                'message' => $error,
            );
        }
        DB::setObject($this->path, (User::createUserByType($user))->getAll());

        $_SERVER["logger"]->log(3, whois() . "successfully changed account information");

        return array(
            'success' => true,
        );
    }

    /**
     * Regex check for specific type.
     * From https://regexr.com/
     */
    private function checkPasswordFormat(?string $pass) {
        return preg_match('/^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $pass);
    }

    /**
     * Regex check for specific type.
     * From https://regexr.com/
     */
    private function checkNameFormat(?string $name) {
        return preg_match("/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/", $name);
    }

    /**
     * Regex check for specific type.
     * From https://regexr.com/
     */
    private function checkStreetFormat(?string $street) {
        return preg_match("/^([0-9A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ \-])*/", $street);
    }

    /**
     * Regex check for specific type.
     * From https://regexr.com/
     */
    private function checkZipFormat(?string $zip) {
        return preg_match("/^(?:0[1-9]|[1-9]\d)\d{3}$/", $zip);
    }

    /**
     * Generates a random password.
     *
     * @param int $l length
     */
    private function genPassword($l = 12) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $password = array();

        for ($i = 0; $i < $l; ++$i) {
            $n = rand(0, strlen($alphabet) - 1);
            $password[] = $alphabet[$n];
        }

        return implode($password);
    }

    /**
     * Assigns user session to user account.
     *
     * @param array $user Array of user data
     */
    private function assign(array $user) {
        $_SESSION['user'] = (User::createUserByType($user))->getProtected();
    }
}
?>
