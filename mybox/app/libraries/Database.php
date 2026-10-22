<?php
    // clase para conectarse y hacer consultas con PDO
    class Database {
        private $host = db_Servidor;
        private $dbname = db_Basedato;
        private $user = db_Usuario;
        private $pass = db_Contra;

        private $dbh;
        private $stmt;

        public function __construct() {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ];

            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (PDOException $e) {
                die('Error de conexion: ' . $e->getMessage());
            }
        }

        // prepara la consulta
        public function query($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        // le pone el valor a cada parametro de la consulta (:nombre)
        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute() {
            return $this->stmt->execute();
        }

        // devuelve todas las filas
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll();
        }

        // devuelve una sola fila
        public function single() {
            $this->execute();
            return $this->stmt->fetch();
        }

        public function rowCount() {
            return $this->stmt->rowCount();
        }

        // id del ultimo registro insertado
        public function lastInsertId() {
            return $this->dbh->lastInsertId();
        }
    }