<?php
/**
 * Database utils
 */

    function getUser($user) { // placeholder
        return null;
    }

    function getDatabasePath($table) {
        return PATH["database"] . $table . ".json";
    }

    function setData($path, $data, $overwrite = false) {

        if (!$overwrite) {
            $data = array_merge(getDatabase($path)["data"], $data);
        }
        echo var_dump($data);
        $file = fopen($path, "w");
        if ($file) {
            fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
            fclose($file);
        }

    }

    function getDatabase($path) {

        $json = [];
        if ($file = file_get_contents($path)) {
            $json = json_decode($file, 1);
        }

        return [
            "data" => $json,
            "path" => $path
        ];
    }

    $a = getDatabase(getDatabasePath("test"));
    
    $b = array("712983" => [
            "name" => "abc"
        ]);

    setData(getDatabasePath("test"), $b);


?>