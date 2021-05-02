<?php
/**
 * Database utils.
 */

    include_once './utils/users.php';
    /**
     *  Class for accessing and managing the database
     */
    class DataBase {
        /**
         * Path of the database.
         *
         * @var string
         */
        private $path = '';

        private $data = array();

        /**
         * Constructor for the database class.
         *
         * @param string $path to the database
         */
        public function __construct($path) {
            $this->path = $path;
            if ($file = file_get_contents($this->path)) {
                $json = json_decode($file, 1);
                foreach ($json as $userJson) {
                    $user = UserType::createUserByType($userJson);
                    array_push($this->data, $user);
                }
            } else {
                throw new Exception('No such file in the directory', 1);
            }
        }

        /**
         * Check if a user is already present in the DB
         *
         * @param string $id
         * @param string $mail
         * @return bool true if present, false otherwise
         */
        public function checkUserInDB($id, $mail) {
            try {
                $this->getUserByID($id);

                return true;
            } catch (\Throwable $th1) {
                try {
                    $this->getUserByMail($mail);

                    return true;
                } catch (\Throwable $th2) {
                    return false;
                }
            }
        }

        /**
         * Create a new User and store it in the DB
         *
         * @param array Array map containing all nececary data to create a new User depending on its type. See UserType::createUserByType().
         * @return User
         */
        public function newUser($rawUser) {
            if (!$this->checkUserInDB($rawUser['id'], $rawUser['mail'])) {
                $user = UserType::createUserByType($rawUser);
                array_push($this->data, $user);

                return $user;
            }

            throw new Exception('User already exist.', 1);
        }

        /**
         * Querry every data from the database.
         *
         * @return array return all database data and its $path
         */
        public function getFullDBInfo() {
            return array(
                'data' => $this->getAllUsers(),
                'path' => $this->path,
            );
        }

        /**
         * Querry user data from it's ID.
         *
         * @param string $userId
         *
         * @return User Class instance of the user or throw an exception if not found
         */
        public function getUserByID($userId) {
            foreach ($this->data as $user) {
                if ($user->getID() == $userId) {
                    return $user;

                    break;
                }
            }

            throw new Exception("Unknown user with id : {$userId}.", 1);
        }

        /**
         * Querry user data from it's Mail.
         *
         * @param string $userId
         *
         * @return User Class instance of the user or throw an exception if not found
         */
        public function getUserByMail($mail) {
            foreach ($this->data as $user) {
                if ($user->getMail() == $mail) {
                    return $user;

                    break;
                }
            }

            throw new Exception("Unknown user with e-mail : {$mail}.", 1);
        }

        /**
         * Get an array of every rawUser data
         *
         * @return array
         */
        public function getAllUsers() {
            $rawData = array();
            foreach ($this->data as $user) {
                array_push($rawData, $user->getAll());
            }

            return $rawData;
        }

        /**
         * Save DB into file
         *
         * @return void
         */
        public function saveDBtoFile() {
            $file = fopen($this->path, 'w');
            if ($file) {
                fwrite($file, json_encode($this->getAllUsers(), JSON_PRETTY_PRINT));
                fclose($file);
            }
        }
    }

?>
