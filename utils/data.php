<?php
/**
 * Database utils.
 */

    include_once './utils/users.php';

    /**
     * Abstract class to manipulate a DB
     */
    abstract class DB {

        /**
         * Get every data stored in the Database
         *
         * @param string $path Path to the database
         * @return array Array of object containing each element info
         */
        public static function getAll(string $path) {
            if ($file = file_get_contents($path)) {
                return json_decode($file, 1);
            } else {
                throw new Exception('No such file in the directory', 1);
            }
        }

        /**
         * Get data of the speficied item from its ID in the database
         *
         * @param string $path Path to the database
         * @param string $id Id of the element to retreive
         * @return array array map of the element retreived
         */
        public static function getFromID(string $path, string $id) {
            $data = self::getAll($path);
            foreach ($data as $element) {
                if ($element['id'] == $id) {
                    return $element;

                    break;
                }
            }
            throw new Exception("Element with id $id not found in $path", 1);
        }

        /**
         * Get data of a user in the database from its mail
         *
         * @param string $path Path to the database
         * @param string $mail mail of the user to retreive
         * @return array array map of the user retreived
         */
        public static function getUserByMail(string $path, string $mail) {
            $data = self::getAll($path);
            foreach ($data as $user) {
                if ($user['mail'] == $mail) {
                    return $user;

                    break;
                }
            }
            throw new Exception("Element with id $id not found in $path", 1);
        }

        /**
         * Overwrite the Database specified by $path by the $data given
         *
         * @param string $path Path to the DB
         * @param array $data Data to write
         * @return void
         */
        public static function writeDB(string $path, array $data) {
            $file = fopen($path, 'w');
            if ($file) {
                fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
                fclose($file);
            }
        }

        /**
         * Write a new user in the DB and check if it already exist if it do exist the function will throw an error
         *
         * @param string $path Path to the DB
         * @param array $rawUser Raw data of the user
         * @return void
         */
        public static function writeNewUser(string $path, array $rawUser) {
            $data = self::getAll($path);
            $element_exist = false;
            foreach ($data as &$element) {
                if ($element['id'] == $rawUser['id'] || $element['mail'] == $rawUser['mail']) {
                    $element_exist = true;
                    break;
                }
            }
            if (!$element_exist) {
                array_push($data, $rawUser);
            } else {
                throw new Exception("User with this id or mail already exist", 1);

            }
            $file = fopen($path, 'w');
            if ($file) {
                fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
                fclose($file);
            }
            self::writeDB($path, $data);
        }

        /**
         * Write a object in the DB
         *
         * if an object with the same id exist it will be overwrite
         *
         * @param string $path Path to the DB
         * @param array $object Object to write
         * @return void
         */
        public static function writeObject(string $path, array $object) {
            $data = self::getAll($path);
            $element_exist = false;
            foreach ($data as &$element) {
                if ($element['id'] == $object['id']) {
                    $element = $object;
                    $element_exist = true;
                    break;
                }
            }
            if (!$element_exist) {
                array_push($data, $object);
            }
            self::writeDB($path, $data);
        }
    }

?>
