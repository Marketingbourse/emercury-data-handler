<?php

interface DatabaseConnectionInterface {
    public static function getInstance();
}

class DatabaseConnection implements DatabaseConnectionInterface {

    private static $dbInstance = null;

    // Prevent from creating instance
    private function __construct(){

    }

    // Prevent cloning the object
    private function __clone(){

    }

    public static function getInstance() {

        // Check if database is null
        if ( self::$dbInstance == null  ) {

            // Create a new PDO connection
            try {
                self::$dbInstance = new PDO('mysql:host='.$_ENV['HOST'].';dbname='.$_ENV['DB_NAME'].'', $_ENV['USER'], $_ENV['PASSWORD']);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

        }

        return self::$dbInstance;

    }

}