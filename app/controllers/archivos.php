<?php
    session_start();

    if ($_SESSION["autenticado"] != "SI") {
        header("Location: index.php");
        exit(); //fin del scrip
    }

    $ruta = getenv('HOME_PATH').'/'.$_SESSION["usuario"];

    $Accion_Formulario = $_SERVER['PHP_SELF'];
    if ((isset($_POST["OC_Aceptar"])) && ($_POST["OC_Aceptar"] == "frmArchi")) {
        $Sali = $_FILES['txtArchi']['name'];

        $Sali = str_replace(' ','_',$Sali);

        move_uploaded_file($_FILES['txtArchi']['tmp_name'], $ruta . '/' . $Sali);
        if(chmod($ruta. '/' . $Sali,0644)){
            header("Location: carpetas.php");
            exit(); //fin del scrip
        }else
            echo 'No se pudo cambiar los permisos, consulte a su administrador';
    }
?>
<!doctype html>
<html lang="en">
<head>
    <?php
        include_once('sections/head.inc');
    ?>
    <title>Agregar archivos</title>
</head>
<body class="container-fluid">
    <header class="row">
        <div class="row">
            <?php include_once('sections/header.inc'); ?>
        </div>
    </header>
    <main class="row">
        <div class="panel panel-primary datos1">
            <div class="panel-heading">
                <strong>Agregar archivo</strong>
            </div>
            <div class="panel-body">
                <form action="<?php echo $Accion_Formulario; ?>" method="post" enctype="multipart/form-data" name="frmArchi">
                    <fieldset>
                        <label><strong>Archivo</strong></label>
                        <input name="txtArchi" type="file" id="txtArchi" size="60" />
                        <input type="submit" name="Submit" value="Cargar" />
                    </fieldset>
                    <input type="hidden" name="OC_Aceptar" value="frmArchi" />
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
    $archivo = $_GET['arch'];

    session_start();

    if ($_SESSION["autenticado"] != "SI") {
        header("Location: index.php");
        exit(); //fin del script
    }

    $ruta = getenv('HOME_PATH').'/'.$_SESSION["usuario"].'/'.$archivo;

    $file = fopen($ruta,"r");
    $contenido = fread($file, filesize($ruta));
    $mime = mime_content_type($ruta);

    if($mime == 'application/pdf'){
        header("Content-type: ". $mime);
        echo $contenido;
    }else{
        header("Content-Disposition: attachment; filename=".$archivo);
        header("Content-type: ". $mime);
        header("Content-length: ".filesize($ruta));
        readfile($ruta);
    }
?>

<?php
    $archivo = $_GET['archi'];
    session_start();

    $ruta = getenv('HOME_PATH').'/'.$_SESSION["usuario"].'/'.$archivo;

    // Try to delete file
    if (@unlink($ruta)){
        $Ir_A = $_SERVER["HTTP_REFERER"];
        echo "<script> location.href='".$Ir_A."' </script>";
    }
?>