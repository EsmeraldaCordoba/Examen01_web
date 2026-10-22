<?php
    // datos para conectarse a la base de datos (xampp)
    const db_Servidor = 'localhost';
    const db_Basedato = 'mybox';
    const db_Usuario  = 'root';
    const db_Contra   = '';

    // ruta absoluta de la carpeta app
    define('appRoot', dirname(__FILE__, 2));

    // direccion del sitio (http o https, host y puerto)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];

    // carpeta del proyecto dentro de htdocs, cambiar si se llama diferente
    $appFolder = '/mybox';

    define('urlRoot', $protocol . $host . $appFolder);

    // nombre del sitio
    const siteName = 'MyBox';

    // 'development' muestra los errores en pantalla, 'production' los esconde
    const ENVIRONMENT = 'development';

    if (ENVIRONMENT === 'production') {
        error_reporting(0);
        ini_set('display_errors', '0');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }