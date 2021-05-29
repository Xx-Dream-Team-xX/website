<?php
/**
 * Routing helper.
 */

    /**
     * Router : Allows settings regex rules and wildcards for easy url redirections.
     */
    abstract class Router {
        /**
         * Added routes list.
         *
         * @var array routes
         */
        private static $routes = array();

        /**
         * Default route (404).
         *
         * @var string
         */
        private static $default = __DIR__;

        /**
         * Adds a route to the routing list.
         *
         * @param string $path       URL (or regex)
         * @param string $target     Destination
         * @param bool   $regex      Self explanatory
         * @param bool   $wildcard   Keeps or not the original request path (minus the first endpoint). ex: /a/b/c.d => /new/c.d
         */
        public static function add(string $path, string $target, bool $regex = false, bool $wildcard = false) {
            array_push(self::$routes, array(
                'path' => $regex ? $path : "/^{$path}$/",
                'target' => $target,
                'wildcard' => $wildcard,
            ));
        }

        /**
         * Sets default route (404).
         *
         * @param string $target Destination
         */
        public static function default(string $target) {
            self::$default = $target;
        }

        /**
         * Redirects traffic to the correct endpoint.
         *
         * @param array $path Original URL (array form, split by "/")
         */
        public static function start(array $path) {
            $found = false;
            foreach (self::$routes as $route) {
                if (preg_match($route['path'], $path[0])) {
                    if ($route['wildcard']) {
                        render($route['target'] . implode('/', array_slice($path, 1)));
                    } else {
                        render($route['target']);
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
     * Renders variable as JSON with correct content type then exits.
     *
     * @param [any] $content variable to encode
     */
    function send_json($content) {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
    }

    /**
     * Includes a file if it exists, errors otherwise.
     *
     * @param [type] $path
     */
    function render(string $path) {
        if (is_file($path)) {

            switch (pathinfo($path)["extension"]) {
                case 'css':
                    header("Content-type: text/css");
                    break;
                case 'html':
                case 'php':
                case 'txt':
                case 'js':
                    header('Content-type: text/html');
                    break;
                case 'mp3':
                    header('Content-type: audio/mp3');
                    break;
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'gif':
                    header('Content-type: image/png');
                    break;
                case 'ttf':
                    header('Content-type: font/ttf');
                    break;
                case 'woff':
                    header('Content-type: font/woff');
                    break;
                case 'woff2':
                    header('Content-type: font/woff2');
                    break;
                default:
                    header('Content-Type: application/octet-stream');
                    break;
            }
            session_start();
            include $path;
        } else {
            notfound();
        }
    }

    /**
     * A better way of handling files.
     *
     * @param string $cat  Category
     * @param string $path Target
     *
     * @return string New path
     */
    function get_path($cat, $path = '') {
        if (isset(PATH[$cat])) {
            return PATH[$cat] . $path;
        }

        return PATH['views'] . 'error.php';
    }

    /**
     * Not found function.
     */
    function notfound() {
        include get_path('views', 'error.php');
        exit();
    }

    /**
     * Returns the last endpoint of the accessed url, if $path not defined, will take from current request
     *
     * @param string $path url
     * @return string last endpoint
     */
    function get_final_point($path = null) {
        if (!isset($path)) {
            $path = $_SERVER['REQUEST_URI'];
        }
        $tmp = array_values(explode("/", explode("?", $path)[0]));
        return end($tmp);
    }

?>
