<?php

// This is the Base Service of the Application.
// Includes basic functionality of Database connection and data manipulation.
//  NOTE: Any other class in the Application extends BaseService class

namespace WeatherAPI;

use PDO;
use Configuration\Configuration;

class Base {
    
    private static $pdo;

    public function __construct() {
        
        $this->initializePDO();
    
    }

    protected function getPDO() {

        return self::$pdo;

    }

    protected function initializePDO() {
        
        // Check if PDO ALREADY exists
        if(!empty(self::$pdo)) {
            return;
        }

        // Load Database Configuration
        $config = Configuration::getInstance();
        $databaseConfig = $config->getConfig()['database'];

        // Connect with database
        self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8', $databaseConfig['host'], $databaseConfig['dbname']),
            $databaseConfig['username'], $databaseConfig['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);    
    
    }

    protected function fetch($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {

        // Prepare Statement
        $statement = $this->getPDO()->prepare($sql);

        // Bind Parameters
        foreach ($parameters as $key => &$value) {
            $statement->bindParam($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        // Execute Statement
        $statement->execute();

        // Fetch data
        return $statement->fetch($type);
    }

    protected function fetchALL($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {

        // Prepare Statement
        $statement = $this->getPDO()->prepare($sql);

        // Bind Parameters
        foreach ($parameters as $key => &$value) {
            $statement->bindParam($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);

        }

        // Execute Statement
        $statement->execute();

        // Fetch Data
        return $statement->fetchAll($type);
    }

}
