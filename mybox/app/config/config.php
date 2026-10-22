<?php
    // datos para conectarse a la base de datos (xampp)
    const db_Servidor = 'localhost';
    const db_Basedato = 'mybox';
    const db_Usuario  = 'root';
    const db_Contra   = '';

    // ruta absoluta de la carpeta app
    define('appRoot', dirname(__FILE__, 2));

    // protocolo (http/https) y host con el puerto
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];

    // carpeta del proyecto dentro de htdocs
    $appFolder = '/2026/Examen01_web/mybox';

    // direccion del sitio
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