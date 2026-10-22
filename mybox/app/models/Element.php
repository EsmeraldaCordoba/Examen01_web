<?php
    class Element {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // devuelve lo que hay dentro de una carpeta (null = la raiz del usuario)
        public function getContent($idUsuario, $idPadre) {
            $this->db->query('select e.id, e.nombre, e.comentario, e.es_carpeta, e.tipo, e.peso, e.fecha,
                                     (select count(*) from compartidos c where c.id_elemento = e.id) as compartido
                              from elementos e
                              where e.id_usuario = :usuario and e.id_padre <=> :padre
                              order by e.es_carpeta desc, e.nombre');
            $this->db->bind(':usuario', $idUsuario);
            $this->db->bind(':padre', $idPadre);

            return $this->db->resultSet();
        }

        // busca una carpeta del usuario, si no existe devuelve false
        public function getFolder($idCarpeta, $idUsuario) {
            $this->db->query('select id, id_padre, nombre from elementos
                              where id = :id and id_usuario = :usuario and es_carpeta = 1');
            $this->db->bind(':id', $idCarpeta);
            $this->db->bind(':usuario', $idUsuario);

            return $this->db->single();
        }

        // devuelve la lista de carpetas desde la raiz hasta la carpeta actual
        public function getPath($idCarpeta, $idUsuario) {
            $ruta = [];

            while ($idCarpeta > 0) {
                $carpeta = $this->getFolder($idCarpeta, $idUsuario);

                if (!$carpeta) {
                    break;
                }

                array_unshift($ruta, $carpeta);
                $idCarpeta = (int)$carpeta->id_padre;
            }

            return $ruta;
        }

        // crea una carpeta nueva
        public function createFolder($idUsuario, $idPadre, $nombre) {
            $this->db->query('insert into elementos (id_usuario, id_padre, nombre, es_carpeta)
                              values (:usuario, :padre, :nombre, 1)');
            $this->db->bind(':usuario', $idUsuario);
            $this->db->bind(':padre', $idPadre);
            $this->db->bind(':nombre', $nombre);

            return $this->db->execute();
        }
    }