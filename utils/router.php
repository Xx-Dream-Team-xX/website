<?php
/**
 * Routing helper
 */

    /**
     * Router : Allows settings regex rules and wildcards for easy url redirections
     */
    class Router {
        /**
         * Added routes list
         *
         * @var array routes
         */
        private static $routes = [];

        /**
         * Default route (404)
         *
         * @var string
         */
        private static $default = "/";

        /**
         * Adds a route to the routing list
         *
         * @param string $path URL (or regex)
         * @param string $target Destination
         * @param boolean $regex Self explanatory
         * @param integer $permission Required permission level 
         * @param boolean $wildcard Keeps or not the original request path (minus the first endpoint). ex: /a/b/c.d => /new/c.d
         */
        public static function add($path, $target, $regex = false, $permission = 0, $wildcard = false) {
            array_push(self::$routes, [
                "path" => $regex ? $path : "/^$path$/",
                "target" => $target,
                "permission" => $permission,
                "wildcard" => $wildcard
            ]);

        }

        /**
         * Sets default route (404)
         *
         * @param string $target Destination
         */
        public static function default($target) {
            self::$default = $target;
        }

        /**
         * Redirects traffic to the correct endpoint
         *
         * @param string $path Original URL (array form, split by "/")
         */
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
    
    /**
     * Renders variable as JSON with correct content type then exits
     *
     * @param [any] $content variable to encode
     */
    function send_json($content) {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);

    }

    /**
     * Includes a file if it exists, errors otherwise
     *
     * @param [type] $path
     */
    function render($path) {

        if (is_file($path)) {
            include($path);
        } else {
            notfound();
        }
    }

    /**
     * Not found function
     * 
     */
    function notfound() {
        include(PATH["views"] . "error.php");
        exit();
    }

?>