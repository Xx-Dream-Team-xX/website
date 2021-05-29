<?php
/**
 * Database utils.
 */
require './vendor/autoload.php';
    /**
     * Abstract class to manipulate a DB.
     */
    abstract class DB {
        /**
         * Get every data stored in the Database.
         *
         * Create the database if not found
         *
         * @param string $path Path to the database
         *
         * @return array Array of object containing each element info
         */
        public static function &getAll(string $path) {
            if (!isset($_SERVER['cache'])) {
                $_SERVER['cache'] = array();
            }
            if (file_exists($path)) {
                if (isset($_SERVER['cache'][$path])) {
                    $file = $_SERVER['cache'][$path];
                } else {
                    $file = file_get_contents($path);
                    $_SERVER['cache'][$path] = json_decode($file, 1);
                }

                return $_SERVER['cache'][$path];
            }

            throw new Exception("Failed to open file {$path}", 1);
        }

        /**
         * Get data of the speficied item from its ID in the database.
         *
         * @param string $path Path to the database
         * @param string $id   Id of the element to retreive
         *
         * @return array array map of the element retreived or false if not found
         */
        public static function getFromID(string $path, string $id) {
            $data = &self::getAll($path);
            foreach ($data as $element) {
                if ($element['id'] === $id) {
                    return $element;

                    break;
                }
            }

            return false;
        }

        /**
         * Get data of a user in the database from its mail.
         *
         * @param string $path Path to the database
         * @param string $mail mail of the user to retreive
         *
         * @return array array map of the user retreived or false if user not found
         */
        public static function getUserByMail(string $path, string $mail) {
            $data = &self::getAll($path);
            foreach ($data as $user) {
                if (isset($user['mail']) && ($user['mail'] == $mail)) {
                    return $user;
                }
            }

            return false;
        }

        /**
         * Writes an Object in the DB and check if it already exists. If it does exist and we wanted a new one the function returns false.
         *
         * @param string $path      Path to the DB
         * @param array  $rawObject Object
         *
         * @return bool false if user Already exist
         */
        public static function setObject(string $path, array $rawObject, bool $new = false) {
            $data = &self::getAll($path);
            $element_exist = false;

            if (!$data && file_exists($path)) {
                $data =array();
            }
            if (isset($rawObject['id'])) {
                foreach ($data as &$element) {
                    if ((isset($element['id']) && ($element['id'] == $rawObject['id']))) {
                        $element_exist = true;

                        if (!$new) {
                            $element = $rawObject;

                            break;
                        }

                        throw new Exception('ID already exists', 1);

                        return false;
                    }
                }

                if (!$element_exist) {
                    array_push($data, $rawObject);
                }

                self::writeDB($path, $data);
            } else {
                return false;
            }
        }

        /**
         * Delete an object from the DB.
         */
        public static function deleteObject(string $path, string $id) {
            $data = &self::getAll($path);

            foreach ($data as $i => $e) {
                if ($e['id'] === $id) {
                    $index = $i;
                }
            }

            if ($index) {
                array_splice($data, $index, $index);
            }

            self::writeDB($path, $data);
        }

        /**
         * Overwrite the Database specified by $path by the $data given.
         *
         * @param string $path Path to the DB
         * @param array  $data Data to write
         */
        private static function writeDB(string $path, array $data) {
            $file = fopen($path, 'w');
            if ($file) {
                fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
                fclose($file);

                return true;
            }

            throw new Exception("Failed to open file {$path}", 1);
        }
    }
