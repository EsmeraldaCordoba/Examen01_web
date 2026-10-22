<?php
    class Users extends Controller {
        private $userModel;

        public function __construct() {
            $this->userModel = $this->model('User');
        }

        // pantalla de ingreso
        public function login() {
            $data = [
                'titulo' => 'Ingreso al Sitio',
                'usuario' => '',
                'error' => ''
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $usuario = trim($_POST['txtUsua']);
                $contra = trim($_POST['txtContra']);
                $data['usuario'] = $usuario;

                $fila = $this->userModel->login($usuario, $contra);

                if ($fila) {
                    $this->createUserSession($fila);
                } else {
                    $data['error'] = 'Usuario o contraseña incorrectos';
                }
            }

            $this->view('users/login', $data);
        }

        // pantalla para registrarse
        public function register() {
            $data = [
                'titulo' => 'Registrarse al Sitio',
                'usuario' => '',
                'nombre' => '',
                'email' => '',
                'error' => ''
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $usuario = trim($_POST['txtUsua']);
                $contra = trim($_POST['txtContra']);
                $nombre = trim($_POST['txtNomb']);
                $email = trim($_POST['txtEmail']);

                $data['usuario'] = $usuario;
                $data['nombre'] = $nombre;
                $data['email'] = $email;

                if ($usuario == '' || $contra == '' || $nombre == '' || $email == '') {
                    $data['error'] = 'Debe llenar todos los campos';
                } elseif (strlen($usuario) > 15 || strlen($nombre) > 30 || strlen($email) > 50) {
                    $data['error'] = 'Alguno de los datos es demasiado largo';
                } elseif (strlen($contra) < 4) {
                    $data['error'] = 'La contraseña debe tener al menos 4 caracteres';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $data['error'] = 'El correo no es valido';
                } elseif ($this->userModel->findUserByUsuario($usuario)) {
                    $data['error'] = 'Ese usuario ya existe, escoja otro';
                } else {
                    $nuevo = [
                        'usuario' => $usuario,
                        'contra' => password_hash($contra, PASSWORD_DEFAULT),
                        'nombre' => $nombre,
                        'email' => $email
                    ];

                    if ($this->userModel->register($nuevo)) {
                        // despues de registrarse entra directo al sitio
                        $fila = $this->userModel->findUserByUsuario($usuario);
                        $this->createUserSession($fila);
                    } else {
                        $data['error'] = 'No se pudo registrar, intente de nuevo';
                    }
                }
            }

            $this->view('users/register', $data);
        }

        // guarda los datos del usuario en la sesion y lo manda al inicio
        private function createUserSession($fila) {
            $_SESSION['id_usuario'] = $fila->id;
            $_SESSION['usuario'] = $fila->usuario;
            $_SESSION['nombre'] = $fila->nombre;

            header('location: ' . urlRoot . '/pages/index');
            exit();
        }

        // cerrar sesion
        public function logout() {
            unset($_SESSION['id_usuario']);
            unset($_SESSION['usuario']);
            unset($_SESSION['nombre']);
            session_destroy();

            header('location: ' . urlRoot . '/users/login');
            exit();
        }
    }