<?php

/**
 * PSR-4 Autoloader for project classes
 * Handles Core and Models namespaces
 */
spl_autoload_register(function ($class) {
    // Define namespace to directory mappings
    $namespaces = [
        'Core\\' => __DIR__ . '/Core/',
        'Models\\' => __DIR__ . '/Models/',
    ];

    foreach ($namespaces as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            // Get the relative class name
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});
