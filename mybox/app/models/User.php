<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // busca un usuario por su nombre de usuario, si no existe devuelve false
        public function findUserByUsuario($usuario) {
            $this->db->query('select * from usuarios where usuario = :usuario');
            $this->db->bind(':usuario', $usuario);

            return $this->db->single();
        }

        // guarda un usuario nuevo, la contraseña ya viene encriptada
        public function register($data) {
            $this->db->query('insert into usuarios (usuario, contra, nombre, email)
                              values (:usuario, :contra, :nombre, :email)');
            $this->db->bind(':usuario', $data['usuario']);
            $this->db->bind(':contra', $data['contra']);
            $this->db->bind(':nombre', $data['nombre']);
            $this->db->bind(':email', $data['email']);

            return $this->db->execute();
        }

        // revisa usuario y contraseña, devuelve el usuario o false
        public function login($usuario, $contra) {
            $fila = $this->findUserByUsuario($usuario);

            if ($fila == false) {
                return false;
            }

            if (password_verify($contra, $fila->contra)) {
                return $fila;
            } else {
                return false;
            }
        }
    }