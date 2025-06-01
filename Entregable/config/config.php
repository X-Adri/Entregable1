<?php
session_start();

// Configuración general
define('BASE_URL', 'http://localhost/proyecto_tecnosoluciones/');
define('APP_NAME', 'TecnoSoluciones - Sistema de Gestión');

// Configuración de seguridad
define('PASSWORD_SALT', 'tecnosoluciones_2024_salt');

// Autoload de clases
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/',
        __DIR__ . '/../config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});
?>