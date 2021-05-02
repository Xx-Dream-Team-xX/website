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
         * Path of the database
         *
         * @var string
         */
        private $path = "";

        private $data = array();

        /**
         * Constructor for the database class
         *
         * @param string $path to the database
         */
        public function __construct($path)
        {
            $this->path = $path;
            if ($file = file_get_contents($this->path)) {
                $this->data = json_decode($file, 1);
            }
        }

        /**
         * Querry every data from the database
         *
         * @return array return all database data and its $path
         */
        public function getFullDBInfo()
        {
            return array(
                'data' => $this->data,
                'path' => $this->path,
            );
        }

        /**
         * Querry user data from it's ID
         *
         * @param string $userId
         * @return User Class instance of the user or throw an exception if not found
         */
        public function getUserByID($userId){
            foreach ($this->data as $user) {
                if ($user['id'] == $userId) {

                    $user_object = new User($user['type'], $user['mail'], $user['first_name'], $user['last_name'], $user['id']);

                    return $user_object;

                    break;
                }
            }
            throw new Exception("Unknown user with id : $userId.", 1);
        }


        public function getUserByMail($mail){
            foreach ($this->data as $user) {
                if ($user['mail'] == $mail) {

                    $user_object = new User($user['type'], $user['mail'], $user['first_name'], $user['last_name'],$user['id']);

                    return $user_object;

                    break;
                }
            }
            throw new Exception("Unknown user with e-mail : $mail.", 1);
        }
    }


    function getUser($user) { // placeholder
        return null;
    }

    function getDatabasePath($table) {
        return PATH['database'] . $table . '.json';
    }

    function setData($path, $data, $overwrite = false) {
        if (!$overwrite) {
            $data = array_merge(getDatabase($path)['data'], $data);
        }
        echo var_dump($data);
        $file = fopen($path, 'w');
        if ($file) {
            fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
            fclose($file);
        }
    }

    function getDatabase($path) {
        $json = array();
        if ($file = file_get_contents($path)) {
            $json = json_decode($file, 1);
        }

        return array(
            'data' => $json,
            'path' => $path,
        );
    }

?>
