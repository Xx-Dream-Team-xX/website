<?php
/**
 * Routing helper
 */
    class Router {
        private static $routes = [];
        private static $default = "/";

        public static function add($path, $target, $regex = false, $permission = 0, $wildcard = false) {
            array_push(self::$routes, [
                "path" => $regex ? $path : "/^$path$/",
                "target" => $target,
                "permission" => $permission,
                "wildcard" => $wildcard
            ]);

        }

        public static function default($target) {
            self::$default = $target;
        }

        public static function start($path) {
            $found = false;
            foreach (self::$routes as $route) {
                
                if (preg_match($route["path"], $path[0])) {

                    if ($route["wildcard"]) {
                        render($route["target"] . implode("/", array_slice($path, 1)));
                    } else {
                        render($route["target"]);
                    }
                    $found = true;
                }
            }

            if (!$found) {
                render(self::$default);
            } 
        }

    }
    function send_json($content) {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);

    }

    function render($page) {
        if (file_exists($page)) {
            include($page);
        } else {
            notfound();
        }
    }

    function notfound() {
        include(PATH["views"] . "error.php");
        exit();
    }

?>