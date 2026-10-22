<!doctype html>
< lang="en">
<head>
    <?php
        include_once('sections/head.inc');
    ?>
    <title>Ingreso al Sitio</title>
</head>
<body class="container-fluid">
    <header class="row">
        <div class="row">
            <?php include_once('sections/header.inc'); ?>
        </div>
    </header>
    <main class="row">
        <div class="panel panel-primary logueo">
            <div class="panel-heading">
                <strong>Autenticación de Usuarios</strong>
            </div>
            <div class="panel-body">
                <form action="<?php echo $Accion_Formulario; ?>" method="post">
                    <fieldset>
                        <label>Usuario:</label><input type="text" name="txtUsua" size="22" maxlength="15" required /><br>
                        <label>Contraseña:</label><input type="password" name="txtContra" size="22" maxlength="15" required />
                    </fieldset>
                    <input type="submit" value="Aceptar" />
                </form>
            </div>
            <br>
            <a href="registrar.php">Registrarse Aquí</a>
        </div>

    </main>
</body>
</html>