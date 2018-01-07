<?php
require 'Configuration.php';

class Database
{
    private static $cont = null;

    public function __construct($dbName, $dbHost, $dbUsername, $dbUserPassword)
    {
        die('Init function is not allowed');
    }

    public static function connect($dbName, $dbHost, $dbUsername, $dbUserPassword)
    {
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . $dbHost . ";" . "dbname=" . $dbName, $dbUsername, $dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}

?>