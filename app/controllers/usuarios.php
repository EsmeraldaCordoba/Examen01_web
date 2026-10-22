<?php
    require_once('codes/conexion.inc');
    if(isset($_POST['txtUsua']) && isset($_POST['txtContra']) && isset($_POST['txtNomb']) && isset($_POST['txtEmail'])){
        //Crea la instrucción para registrar el usuario
        $AuxSql = sprintf("insert into usuarios(usuario,contra,nombre,email) values('%s',md5('%s'),'%s','%s')",
            trim($_POST['txtUsua']),
            trim($_POST['txtContra']),
            trim($_POST['txtNomb']),
            trim($_POST['txtEmail']));
        try{
            $Regis = mysqli_query($conex,$AuxSql,MYSQLI_STORE_RESULT);

            session_start();
            $_SESSION["autenticado"]= "SI";
            $_SESSION["nombre"]  = trim($_POST['txtNomb']);
            $_SESSION["usuario"] = trim($_POST['txtUsua']);
            $_SESSION["ruta"] = getenv('HOME_PATH').'/'.$_SESSION["usuario"];

            header("location: codes/creadir.php");
            exit();
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }finally{
            unset($_POST['txtUsua']);
            unset($_POST['txtContra']);
            unset($_POST['txtNomb']);
            unset($_POST['txtEmail']);
        }
    }//fin del if principal
?>

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

<?php
    require_once('codes/conexion.inc');
    $Accion_Formulario = $_SERVER['PHP_SELF'];
    if((isset($_POST['txtUsua'])) && (isset($_POST['txtContra']))) {

        $auxSql = sprintf("select nombre, usuario from usuarios Where usuario = '%s' and contra = md5('%s')", $_POST['txtUsua'],$_POST['txtContra']);
        $regis = mysqli_query($conex,$auxSql);

        // release inputs objects
        unset($_POST['txtUsua']);
        unset($_POST['txtContra']);

        if(mysqli_num_rows($regis) > 0){
            $tupla = mysqli_fetch_assoc($regis);

            // create session variable
            session_start();
            $_SESSION["autenticado"]= "SI";
            $_SESSION["nombre"]=$tupla['nombre'];
            $_SESSION["usuario"]=$tupla['usuario'];

            header("location: carpetas.php");
        }else {
            header("location: errors/400.php");
            exit();
        }
    }
?>
<!doctype html>
<html lang="en">
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

    <footer class="row">
        <?php include_once('sections/foot.inc'); ?>
    </footer>
</body>
</html>

<?php
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");

    session_start();
        unset($_SESSION['autenticado']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nombre']);
        unset($_SESSION['email']);
    session_destroy();

    header("Location: ../index.php");
    exit();
?>