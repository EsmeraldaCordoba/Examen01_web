<?php
    // clase para conectarse a la base de datos con PDO
    class Database {
        private $conexion;

        public function conectar() {
            $dsn = 'mysql:host=' . db_Servidor . ';dbname=' . db_Basedato . ';charset=utf8mb4';

            try {
                $this->conexion = new PDO($dsn, db_Usuario, db_Contra);
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                die('Error de conexion: ' . $e->getMessage());
            }

            return $this->conexion;
        }
    }