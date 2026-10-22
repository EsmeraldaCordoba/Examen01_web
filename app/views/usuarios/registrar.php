<!doctype html>
<html lang="en">
<head>
    <?php
        include_once('sections/head.inc');
    ?>
    <title>Registrarse al Sitio</title>
</head>
<body class="container-fluid">
    <header class="row">
        <div class="row">
            <?php include_once('sections/header.inc'); ?>
        </div>
    </header>
    <main class="row">
        <div class="panel panel-primary datos3">
            <div class="panel-heading">
                <strong>Datos del nuevo usuario</strong>
            </div>
            <div class="panel-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                        <label>Usuario:</label><input type="text" name="txtUsua" size="22" maxlength="15" required /><br>
                        <label>Contraseña:</label><input type="password" name="txtContra" size="22" maxlength="15" required /><br>
                        <label>Nombre Completo:</label><input type="text" name="txtNomb" size="40" maxlength="30" required /><br>
                        <label>Correo Electrónico:</label><input type="text" name="txtEmail" size="50" maxlength="50" required /><br>
                    </fieldset>
                    <input type="submit" value="Aceptar" />
                </form>
            </div>
        </div>
    </main>

    <footer class="row">
        <?php include_once('sections/foot.inc'); ?>
    </footer>
</body>
</html>