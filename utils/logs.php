<?php
/**
 * Logging utils.
 */
    /**
     * Logger class, writes logs to files, has different verbose levels.
     */
    class Logger {
        /**
         * Access level constants.
         */
        public const ACCESS = 1;

        public const BASIC = 2;

        public const ACTIONS = 3;

        public const ADMIN = 4;

        public const ERRORS = 5;

        /**
         * Logs directory path.
         *
         * @var string
         */
        private $basepath = '';

        /**
         * Verbose level.
         *
         * @var int
         */
        private $level = 2;

        /**
         * Logger setup.
         *
         * @param string $path  Logging folder
         * @param string $level Minimum verbose level
         */
        public function __construct(string $path, string $level) {
            $this->basepath = $path;
            $this->level = $level;

            if (!is_dir($path) || (static::ERRORS < $level) || (static::ACCESS > $level)) {
                throw new Exception('Invalid logger setup', 1);
            }
        }

        /**
         * Logs content, according to the verbose level.
         *
         * @param int    $level   Verbose level of current message
         * @param string $content Message
         */
        public function log(int $level, string $content) {
            if ($level >= $this->level) {
                file_put_contents($this->today_file(), "[{$level}]" . self::now() . $content . "\n", FILE_APPEND);
            }
        }

        /**
         * Current hour, minute and second.
         *
         * @return string
         */
        private static function now() {
            return date('[G:i:s] ');
        }

        /**
         * Logging file path, with today's date in name.
         *
         * @return string
         */
        public function today_file() {
            return $this->basepath . date('d-m-y') . '-logs.txt';
        }
    }
?>
