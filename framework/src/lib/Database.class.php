<?php

class Database {
    private static ?Database $instance = null;
    private ?PDO $connection = null;

    private function __construct() {
        if(Config::$DB_SETTINGS["DB_USE"]) {
            $this->connection = new PDO("mysql:host=" . Config::$DB_SETTINGS["DB_HOST"] . ";dbname=" . Config::$DB_SETTINGS["DB_NAME"], Config::$DB_SETTINGS["DB_USER"], Config::$DB_SETTINGS["DB_PASS"]);
        }
    }
    
    /**
     * Gets the Database Instance
     * @return Database
     */
    public static function getInstance(): Database {
        if(self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
    
    /**
     * Gets the PDO Database Connection
     * @return PDO|null
     */
    public static function getConnection(): ?PDO {
        return self::getInstance()->connection;
    }
}