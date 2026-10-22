<?php
    class Elements extends Controller {
        private $elementModel;

        // limite de tamaño de un archivo: 20 MB
        private $maxPeso = 20971520;

        public function __construct() {
            // solo entra quien tiene la sesion iniciada
            if (!isLoggedIn()) {
                header('location: ' . urlRoot . '/users/login');
                exit();
            }

            $this->elementModel = $this->model('Element');
        }

        // muestra el contenido de una carpeta, si no le pasan numero muestra la raiz
        public function index($idCarpeta = 0) {
            $this->mostrar((int)$idCarpeta, '');
        }

        // crea una carpeta nueva dentro de la carpeta actual
        public function createFolder($idPadre = 0) {
            $idPadre = (int)$idPadre;

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                header('location: ' . urlRoot . '/elements/index/' . $idPadre);
                exit();
            }

            $idUsuario = $_SESSION['id_usuario'];
            $nombre = trim($_POST['txtNombre']);

            if ($nombre == '') {
                $this->mostrar($idPadre, 'Debe escribir un nombre para la carpeta');
                return;
            }

            if (strlen($nombre) > 100) {
                $this->mostrar($idPadre, 'El nombre es demasiado largo');
                return;
            }

            // si va dentro de otra carpeta, esa carpeta tiene que ser del usuario
            if ($idPadre > 0 && !$this->elementModel->getFolder($idPadre, $idUsuario)) {
                header('location: ' . urlRoot . '/elements/index');
                exit();
            }

            if ($idPadre == 0) {
                $padre = null;
            } else {
                $padre = $idPadre;
            }

            $this->elementModel->createFolder($idUsuario, $padre, $nombre);

            header('location: ' . urlRoot . '/elements/index/' . $idPadre);
            exit();
        }

        // sube un archivo a la base de datos dentro de la carpeta actual
        public function upload($idPadre = 0) {
            $idPadre = (int)$idPadre;

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                header('location: ' . urlRoot . '/elements/index/' . $idPadre);
                exit();
            }

            $idUsuario = $_SESSION['id_usuario'];

            // si el archivo pesa mas que post_max_size, php no manda nada
            if (!isset($_FILES['archivo'])) {
                $this->mostrar($idPadre, 'El archivo es demasiado grande, el limite es de 20 MB');
                return;
            }

            $archivo = $_FILES['archivo'];
            $comentario = trim($_POST['txtComentario']);

            if ($archivo['error'] == UPLOAD_ERR_NO_FILE) {
                $this->mostrar($idPadre, 'Debe escoger un archivo');
                return;
            }

            if ($archivo['error'] == UPLOAD_ERR_INI_SIZE || $archivo['error'] == UPLOAD_ERR_FORM_SIZE) {
                $this->mostrar($idPadre, 'El archivo es demasiado grande, el limite es de 20 MB');
                return;
            }

            if ($archivo['error'] != UPLOAD_ERR_OK) {
                $this->mostrar($idPadre, 'Hubo un error al subir el archivo');
                return;
            }

            if ($archivo['size'] > $this->maxPeso) {
                $this->mostrar($idPadre, 'El archivo es demasiado grande, el limite es de 20 MB');
                return;
            }

            if (strlen($comentario) > 50) {
                $this->mostrar($idPadre, 'El comentario puede tener maximo 50 caracteres');
                return;
            }

            $nombre = basename($archivo['name']);

            if (strlen($nombre) > 150) {
                $this->mostrar($idPadre, 'El nombre del archivo es demasiado largo');
                return;
            }

            // si va dentro de una carpeta, esa carpeta tiene que ser del usuario
            if ($idPadre > 0 && !$this->elementModel->getFolder($idPadre, $idUsuario)) {
                header('location: ' . urlRoot . '/elements/index');
                exit();
            }

            if ($idPadre == 0) {
                $padre = null;
            } else {
                $padre = $idPadre;
            }

            // datos del archivo
            $tipo = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

            if (function_exists('mime_content_type')) {
                $mime = mime_content_type($archivo['tmp_name']);
            } else {
                $mime = $archivo['type'];
            }

            $contenido = file_get_contents($archivo['tmp_name']);

            try {
                $this->elementModel->createFile($idUsuario, $padre, $nombre, $comentario, $tipo, $mime, $archivo['size'], $contenido);
            } catch (PDOException $e) {
                $this->mostrar($idPadre, 'No se pudo guardar el archivo en la base de datos');
                return;
            }

            header('location: ' . urlRoot . '/elements/index/' . $idPadre);
            exit();
        }

        // abre un archivo: pdf e imagenes se ven en pantalla, lo demas se descarga
        public function open($id = 0) {
            $id = (int)$id;
            $archivo = $this->elementModel->getFile($id, $_SESSION['id_usuario']);

            // tiene que existir y ser del usuario
            if (!$archivo) {
                header('location: ' . urlRoot . '/elements/index');
                exit();
            }

            $nombre = str_replace('"', '', $archivo->nombre);
            $mimeVer = mimePantalla($archivo->tipo);

            if ($mimeVer != '') {
                // se muestra en el navegador
                header('Content-Type: ' . $mimeVer);
                header('Content-Disposition: inline; filename="' . $nombre . '"');
            } else {
                // se descarga
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $nombre . '"');
            }

            header('X-Content-Type-Options: nosniff');
            header('Content-Length: ' . strlen($archivo->contenido));

            echo $archivo->contenido;
            exit();
        }

        // borra un archivo o una carpeta (con todo lo que tenga adentro)
        public function delete($id = 0) {
            $id = (int)$id;

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                header('location: ' . urlRoot . '/elements/index');
                exit();
            }

            $idUsuario = $_SESSION['id_usuario'];
            $elemento = $this->elementModel->getElement($id, $idUsuario);

            // tiene que existir y ser del usuario
            if (!$elemento) {
                header('location: ' . urlRoot . '/elements/index');
                exit();
            }

            $this->elementModel->deleteElement($id, $idUsuario);

            // vuelve a la carpeta donde estaba
            header('location: ' . urlRoot . '/elements/index/' . (int)$elemento->id_padre);
            exit();
        }

        // arma los datos y muestra la vista
        private function mostrar($idCarpeta, $error) {
            $idUsuario = $_SESSION['id_usuario'];

            if ($idCarpeta > 0) {
                // la carpeta tiene que existir y ser del usuario
                if (!$this->elementModel->getFolder($idCarpeta, $idUsuario)) {
                    header('location: ' . urlRoot . '/elements/index');
                    exit();
                }
                $padre = $idCarpeta;
            } else {
                $padre = null;
            }

            $data = [
                'titulo' => 'Mis carpetas',
                'idCarpeta' => $idCarpeta,
                'ruta' => $this->elementModel->getPath($idCarpeta, $idUsuario),
                'elementos' => $this->elementModel->getContent($idUsuario, $padre),
                'error' => $error
            ];

            $this->view('elements/index', $data);
        }
    }