<?php
    // archivo solo para probar la conexion, borrarlo despues
    require_once('app/config/config.php');
    require_once('app/libraries/Database.php');

    $db = new Database();
    $pdo = $db->conectar();

    $consulta = $pdo->query('select usuario, nombre from usuarios');
    $usuarios = $consulta->fetchAll();

    echo '<h3>Conexion exitosa</h3>';
    foreach ($usuarios as $u) {
        echo $u->usuario . ' - ' . $u->nombre . '<br>';
    }