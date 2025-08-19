<?php

class Logger {
    public static int $LOG_NONE = 0;
    public static int $LOG_FATAL = 1;
    public static int $LOG_ERROR = 2;
    public static int $LOG_WARN = 3;
    public static int $LOG_INFO = 4;
    public static int $LOG_DEBUG = 5;
    public static int $LOG_TRACE = 6;

    private static array $instance = [];
    private static array $customLogHandlers = [];
    private string $tag;

    private static string $LOG_DIRECTORY = __APP_DIR__ . "/logs/";

    private function __construct($tag) {
        $this->tag = $tag;
    }

    public static function getLogger($tag = "LOGGER"): Logger {
        if(!isset(self::$instance[$tag])) {
            self::$instance[$tag] = new Logger($tag);
        }

        return self::$instance[$tag];
    }

    public static function addCustomLogHandler(int $logLevel, $handler): void {
        if(!isset(self::$customLogHandlers[$logLevel])) {
            self::$customLogHandlers[$logLevel] = [];
        }

        self::$customLogHandlers[$logLevel][] = $handler;
    }

    private function writeToLogfile(string $message): void {
        if(!(file_exists(self::$LOG_DIRECTORY) && is_dir(self::$LOG_DIRECTORY))) {
            mkdir(self::$LOG_DIRECTORY);
        }

        $logfileName = str_replace("%date%", date("Y-m-d"), "log-%date%.log");
        $logfile = fopen(self::$LOG_DIRECTORY . $logfileName, "a");
        fwrite($logfile, $message . PHP_EOL);
    }

    public function trace($message): void {
        if(Config->getLogLevel() >= self::$LOG_TRACE) {
            if(!is_string($message)) {
                $message = serialize($message);
            }

            $lineNumber = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]["line"] | 0;
            $this->writeToLogfile("[" . date("Y-m-d H:i:s") . "] [TRACE] [{$this->tag}:{$lineNumber}]: " . $message);

            if(!empty(self::$customLogHandlers[self::$LOG_TRACE])) {
                foreach(self::$customLogHandlers[self::$LOG_TRACE] as $handler) {
                    $handler($message);
                }
            }
        }
    }

    public function debug($message): void {
        if(Config->getLogLevel() >= self::$LOG_DEBUG) {
            if(!is_string($message)) {
                $message = serialize($message);
            }

            $lineNumber = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]["line"] | 0;
            $this->writeToLogfile("[" . date("Y-m-d H:i:s") . "] [DEBUG] [{$this->tag}:{$lineNumber}]: " . $message);

            if(!empty(self::$customLogHandlers[self::$LOG_DEBUG])) {
                foreach(self::$customLogHandlers[self::$LOG_DEBUG] as $handler) {
                    $handler($message);
                }
            }
        }
    }

    public function info($message): void {
        if(Config->getLogLevel() >= self::$LOG_INFO) {
            if(!is_string($message)) {
                $message = serialize($message);
            }

            $lineNumber = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]["line"] | 0;
            $this->writeToLogfile("[" . date("Y-m-d H:i:s") . "] [INFO] [{$this->tag}:{$lineNumber}]: " . $message);

            if(!empty(self::$customLogHandlers[self::$LOG_INFO])) {
                foreach(self::$customLogHandlers[self::$LOG_INFO] as $handler) {
                    $handler($message);
                }
            }
        }
    }

    public function warn($message): void {
        if(Config->getLogLevel() >= self::$LOG_WARN) {
            if(!is_string($message)) {
                $message = serialize($message);
            }

            $lineNumber = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]["line"] | 0;
            $this->writeToLogfile("[" . date("Y-m-d H:i:s") . "] [WARN] [{$this->tag}:{$lineNumber}]: " . $message);

            if(!empty(self::$customLogHandlers[self::$LOG_WARN])) {
                foreach(self::$customLogHandlers[self::$LOG_WARN] as $handler) {
                    $handler($message);
                }
            }
        }
    }

    public function error($message): void {
        if(Config->getLogLevel() >= self::$LOG_ERROR) {
            if(!is_string($message)) {
                $message = serialize($message);
            }

            $lineNumber = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]["line"] | 0;
            $this->writeToLogfile("[" . date("Y-m-d H:i:s") . "] [ERROR] [{$this->tag}:{$lineNumber}]: " . $message);

            if(!empty(self::$customLogHandlers[self::$LOG_ERROR])) {
                foreach(self::$customLogHandlers[self::$LOG_ERROR] as $handler) {
                    $handler($message);
                }
            }
        }
    }

    public function fatal($message): void {
        if(Config->getLogLevel() >= self::$LOG_FATAL) {
            if(!is_string($message)) {
                $message = serialize($message);
            }

            $lineNumber = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]["line"] | 0;
            $this->writeToLogfile("[" . date("Y-m-d H:i:s") . "] [FATAL] [{$this->tag}:{$lineNumber}]: " . $message);

            if(!empty(self::$customLogHandlers[self::$LOG_FATAL])) {
                foreach(self::$customLogHandlers[self::$LOG_FATAL] as $handler) {
                    $handler($message);
                }
            }
        }
    }
}
