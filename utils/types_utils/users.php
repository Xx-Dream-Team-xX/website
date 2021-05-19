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
         * Conversations
         *
         * @var array
         */
        protected $conversations = array();

        /**
         * Notifications
         *
         * @var array
         */
        protected $notifications = array();

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

                if (isset($rawUser['conversations'])) {
                    $this->conversations = $rawUser['conversations'];
                }
                if (isset($rawUser['notifications'])) {
                    $this->notifications = $rawUser['notifications'];
                }
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

        /**
         * Get user phone
         *
         * @return void
         */
        public function getPhone() {
            return $this->phone;
        }

        /**
         * Add conversation to conversation list
         *
         * @param string $id conversation id
         * @return void
         */
        public function addConversation(string $id) {
            array_push($this->conversations, $id);
        }

        /**
         * Add notification to the stack
         *
         * @param string $title Title of the notification
         * @param string $content Content of notification
         * @param string $url Redirection of notification
         * @return void
         */
        public function pushNotification(string $title, string $content, string $url) {
            array_push($this->notifications, [
                'id' => uniqid(),
                'title' => htmlspecialchars($title),
                'content' => htmlspecialchars($content),
                'url' => $url,
                'seen' => false
            ]);
        }

        /**
         * Mark one or all notifications as read
         *
         * @param string|null $id Notification id, null for everything
         * @return void
         */
        public function markNotificationsAsRead(?string $id) {

            if (isset($id)) {
                if ($this->notifications[$id]) {
                    $this->notifications[$id]["seen"] = true;
                }
            } else {
                foreach ($this->notifications as $n) {
                    $this->notifications[$n]["seen"] = true;
                }
            }
        }

        /**
         * Removes all notifications from stack
         *
         * @return void
         */
        public function clearNotifications() {
            $this->notifications = array();
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
                'conversations' => $this->conversations,
                'notifications' => $this->notifications,
                'password_hash' => $this->password
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
                return (int) $type;
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
                case self::GESTIONNAIRE:
                    return new UserGestionnaire($rawUser);

                    break;
                
                default:
                    return new User($rawUser);

                    break;
            }
        }

        /**
         * Gets interactionnable users list callbacks for map and filter
         *
         * @return array [filter, map] callbacks
         */
        public static function getInteractions() {
            $filter = null;
            $map = null;

            switch (getPermissions()) {
                case User::GESTIONNAIRE:

                    $filter = function($u) {

                        return (($u["type"] === User::ASSURE) && ($u["assurance"] === $_SESSION["user"]["assurance"]));
                    };

                    $map = function($u) {

                        return array(
                            'id' => $u["id"],
                            'name' => $u["last_name"] . " " . $u["first_name"],
                            'mail' => $u["mail"],
                            'type' => $u["type"],
                            'birth' => $u["birth"],
                            'declarations' => sizeof($u["declarations"]),
                            'contracts' => sizeof($u["contracts"]),
                            'sinisters' => sizeof($u["sinisters"]),
                            'actions' => sizeof($u["actions"])
                        );
                    };
                    break;
                case User::ADMIN:
                    $filter = function($u) {
                        return ($u["type"] !== User::ADMIN);
                    };
                    $map = function($u) {
                        $u = (User::createUserByType($u))->getPublic();
                        return ;
                    };
                    break;
                case User::ASSURE:
                    $filter = function($u) {
                        return (($u["type"] === User::GESTIONNAIRE) && ($u["assurance"] === $_SESSION["user"]["assurance"]));
                    };
                    $map = function($u) {
                        return array(
                            'id' => $u['id'],
                            'name' => $u["last_name"] . " " . $u["first_name"],
                            'mail' => ($u["id"]===$_SESSION["user"]["rep"]) ? $u["mail"] : false
                        );
                    };
                    break;
                default:
                $filter = function($u) {
                    return false;
                };
                    break;
            }

            return [$filter, $map];
        }
    }

    /**
     * Assuré class
     */
    class UserAssure extends User {

        /**
         * Street address
         *
         * @var string
         */
        protected $address = '';

        /**
         * ZIP code
         *
         * @var string
         */
        protected $zipCode = '';

        /**
         * Assigned representant id
         */
        protected $rep = '';

        /**
         * Assigned assurance
         */
        protected $assurance = '';

        /**
         * Date of birth (unix)
         *
         * @var integer
         */
        protected $birth = 0;

        /**
         * Contracts
         *
         * @var array
         */
        protected $contracts = array();

        /**
         * Declarations ids stack
         *
         * @var array
         */
        protected $declarations = array();

        /**
         * Sinisters ids stack
         *
         * @var array
         */
        protected $sinisters = array();

        /**
         * Pending actions stack (verifications)
         *
         * @var array
         */
        protected $actions = array();

        /**
         * Assuré construction, initilaizes the user
         *
         * @param array $rawUser
         */
        public function __construct(array $rawUser) {
            if (isset($rawUser['birth'],$rawUser['address'],$rawUser['zip_code'],$rawUser['rep'],$rawUser['assurance'])) {
                parent::__construct($rawUser);
                $this->type = User::ASSURE;
                $this->address = $rawUser['address'];
                $this->zipCode = $rawUser['zip_code'];
                $this->rep = $rawUser['rep'];
                $this->assurance = $rawUser['assurance'];

                if (isset($rawUser['declarations'])) {
                    $this->declarations = $rawUser['declarations'];
                }
                if (isset($rawUser['sinisters'])) {
                    $this->sinisters = $rawUser['sinisters'];
                }
                if (isset($rawUser['actions'])) {
                    $this->actions = $rawUser['actions'];
                }
                if (isset($rawUser['contracts'])) {
                    $this->contracts = $rawUser['contracts'];
                }
                if (gettype('int' != $rawUser['birth'])) {
                    $this->setBirth($rawUser['birth']);
                } else {
                    $this->birth = $rawUser['birth'];
                }
            } else {
                throw new Exception("Array passed doesn't represent a User Assuré", 1);
            }
        }

        /**
         * Gets all user information
         */
        public function getAll() {
            return array_merge(parent::getAll(), array(
                'contracts' => $this->contracts,
                'declarations' => $this->declarations,
                'sinisters' => $this->sinisters,
                'actions' => $this->actions,
                'zip_code' => $this->zipCode,
                'address' => $this->address,
                'birth' => $this->birth,
                'assurance' => $this->assurance,
                'rep' => $this->rep
            ));
        }

        /**
         * Returns contracts list
         */
        public function getContracts() {
            return $this->contracts;
        }

        /**
         * Adds new contract to stack
         */
        public function addContract(Contract $contract) {
            array_push($this->contracts, $contract->getID());
            if (!in_array($this->id, $contract->getOwners())) {
                $contract->addOwner($this);
            }
        }

        /**
         * Sets birth from unix or from d/m/Y format
         */
        public function setBirth(string $date) {
            if ($date = DateTime::createFromFormat('d/m/Y', $date)) {
                $this->birth = $date->getTimestamp();

                return true;
            }

            return false;
        }
    }

    /**
     * Gestionnaire user type
     */
    class UserGestionnaire extends User {

        /**
         * Assigned assurance company
         *
         * @var string
         */
        protected $assurance = '';

        /**
         * Assigned contracts stack
         *
         * @var array
         */
        protected $contracts = array();

        /**
         * User constructor for gestionnaire
         *
         * @param array $rawUser
         */
        public function __construct(array $rawUser) {
            if (isset($rawUser['assurance'])) {
                parent::__construct($rawUser);
                $this->type = User::GESTIONNAIRE;
                $this->assurance = $rawUser['assurance'];

                if (isset($rawUser["contracts"])) {
                    $this->contracts = $rawUser["contracts"];
                }
            } else {
                throw new Exception("Array passed doesn't represent a User Gestionnaire", 1);
            }
        }

        /**
         * Gets all information
         *
         * @return void
         */
        public function getAll() {
            return array_merge(parent::getAll(), array(
                'contracts' => $this->contracts,
                'assurance' => $this->assurance,
            ));
        }
    }

?>
