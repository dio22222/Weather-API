<?php

    namespace Configuration;

    // This file contain the configuation data,
    // to connect with mysql database.
    class Configuration {
        private $config;

        private static $instance;

        private function __construct() {

            // Load Configuration File
            $path = __DIR__.'/../../config/db_config.json';
            $connect = \file_get_contents($path);
            $this->config = json_decode($connect, true);
        }

        public static function getInstance() {
            
            self::$instance = self::$instance ?: new Configuration();
            return self::$instance;
        }

        public function getConfig() {
            
            return $this->config;

        }
    }

?>