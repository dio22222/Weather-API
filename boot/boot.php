<?php

    // Error reporting
    error_reporting(E_ALL);

    // Register Autoload Function
    spl_autoload_register(function ($class) {
        $class = str_replace("\\", "/", $class);
        require_once sprintf(__DIR__.'/../app/%s.php', $class);
    });

?>