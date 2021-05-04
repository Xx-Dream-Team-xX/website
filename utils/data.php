<?php
/**
 * Database utils.
 */

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
        public static function getAll(string $path) {
            try {
                if (file_exists($path)) {
                    $file = file_get_contents($path);
                    if ($file) {
                        return json_decode($file, 1);
                    }
                } else {
                    $parent_dir = dirname($path);
                    if (!file_exists($parent_dir)) {
                        mkdir($parent_dir, 0777, false);
                    }
                    $file = fopen($path, 'w');
                    fwrite($file, '[]');
                    fclose($file);

                    return DB::getAll($path);
                }
            } catch (\Throwable $th) {
                send_json($th);
            }
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
            $data = self::getAll($path);
            foreach ($data as $element) {
                if ($element['id'] == $id) {
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
            $data = self::getAll($path);
            foreach ($data as $user) {
                if (isset($user['mail']) && ($user['mail'] == $mail)) {
                    return $user;

                    break;
                }
            }

            return false;
        }

        /**
         * Write a new Object in the DB and check if it already exist if it do exist the function will retrun false.
         *
         * @param string $path Path to the DB
         *
         * @return bool false if user Already exist
         */
        public static function createObject(string $path, array $rawObject) {
            $data = self::getAll($path);
            $element_exist = false;
            foreach ($data as &$element) {
                if (((isset($element['id'],$rawObject['id'])
                        && ($element['id'] == $rawObject['id'])
                        )
                    || (isset($element['mail'], $rawObject['mail'])
                        && ($element['mail'] == $rawObject['mail'])
                        )
                    || (isset($element['contractID'],$rawObject['contractID'])
                        && ($element['contractID'] == $rawObject['contractID'])
                    )
                    )) {
                    $element_exist = true;

                    break;
                }
            }
            if (!$element_exist) {
                array_push($data, $rawObject);
            } else {
                return false;
            }
            self::writeDB($path, $data);
        }

        /**
         * Write a object in the DB.
         *
         * if an object with the same id exist it will be overwrite
         *
         * @param string $path   Path to the DB
         * @param array  $object Object to write
         */
        public static function writeObject(string $path, array $object) {
            $data = self::getAll($path);
            $element_exist = false;
            foreach ($data as &$element) {
                if (($element['id'] == $object['id'])
                    || (isset($element['mail'], $object['mail'])
                        && ($element['mail'] == $object['mail']))
                    || (isset($element['contractID'],$object['contractID'])
                        && ($element['contractID'] == $object['contractID']))
                ) {
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

        /**
         * Overwrite the Database specified by $path by the $data given.
         *
         * @param string $path Path to the DB
         * @param array  $data Data to write
         */
        private static function writeDB(string $path, array $data) {
            try {
                $file = fopen($path, 'w');
                if ($file) {
                    fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
                    fclose($file);
                }
            } catch (\Throwable $th) {
                send_json("Failed to open/create file {$path}");
            }
        }
    }
