<?php
    class Elements extends Controller {
        private $elementModel;

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