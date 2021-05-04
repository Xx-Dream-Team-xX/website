<?php
/**
 * Logging utils.
 */
    /**
     * Logger class, writes logs to files, has different verbose levels
     */
    class Logger {

        /**
         * Logs directory path
         *
         * @var string
         */
        private static $basepath = '';

        /**
         * Verbose level
         *
         * @var integer
         */
        private static $level = 2;

        /**
         * Access level constants
         */
        public const ACCESS = 1;
        public const BASIC = 2;
        public const ACTIONS = 3;
        public const ADMIN = 4;
        public const ERRORS = 5;

        /**
         * Current hour, minute and second
         *
         * @return string
         */
        private function now() {
            return date('[G:i:s] ');
        }

        /**
         * Logging file path, with today's date in name
         *
         * @return string
         */
        private function today_file() {
            return static::$basepath . date('d-m-y') . "-logs.txt";
        }

        /**
         * Logs content, according to the verbose level
         *
         * @param integer $level Verbose level of current message
         * @param string $content Message
         * @return void
         */
        public function log(int $level, string $content) {
            if ($level >= static::$level) {
                file_put_contents(static::today_file(), "[$level]" . static::now() . $content . "\n", FILE_APPEND);
            }
        }

        /**
         * Logger setup
         *
         * @param string $path Logging folder
         * @param string $level Minimum verbose level
         */
        public function __construct(string $path, string $level) {
            static::$basepath = $path;
            static::$level = $level;

            if (!is_dir($path) || (static::ERRORS < $level) || (static::ACCESS > $level)) {
                throw new Exception("Invalid logger setup", 1);
            }
        }
    }
?>
