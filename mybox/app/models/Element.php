<?php
    class Element {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // devuelve lo que hay dentro de una carpeta (null = la raiz del usuario)
        public function getContent($idUsuario, $idPadre) {
            $this->db->query('select e.id, e.nombre, e.comentario, e.es_carpeta, e.tipo, e.peso, e.fecha,
                                     (select count(*) from compartidos c where c.id_elemento = e.id) as compartido,
                                     (select group_concat(u.usuario separator ", ")
                                      from compartidos c join usuarios u on u.id = c.id_usuario_destino
                                      where c.id_elemento = e.id) as compartido_con
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

        // busca un archivo o carpeta del usuario (sin el contenido), si no existe devuelve false
        public function getElement($id, $idUsuario) {
            $this->db->query('select id, id_padre, nombre, es_carpeta from elementos
                              where id = :id and id_usuario = :usuario');
            $this->db->bind(':id', $id);
            $this->db->bind(':usuario', $idUsuario);

            return $this->db->single();
        }

        // busca un archivo o carpeta de cualquier usuario (sin el contenido)
        public function getElementById($id) {
            $this->db->query('select id, id_padre, id_usuario, nombre, es_carpeta from elementos
                              where id = :id');
            $this->db->bind(':id', $id);

            return $this->db->single();
        }

        // busca un archivo con todo y su contenido
        public function getFile($id) {
            $this->db->query('select id, nombre, tipo, mime, peso, contenido from elementos
                              where id = :id and es_carpeta = 0');
            $this->db->bind(':id', $id);

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

        // guarda un archivo dentro de la base de datos
        public function createFile($idUsuario, $idPadre, $nombre, $comentario, $tipo, $mime, $peso, $contenido) {
            $this->db->query('insert into elementos (id_usuario, id_padre, nombre, comentario, es_carpeta, tipo, mime, peso, contenido)
                              values (:usuario, :padre, :nombre, :comentario, 0, :tipo, :mime, :peso, :contenido)');
            $this->db->bind(':usuario', $idUsuario);
            $this->db->bind(':padre', $idPadre);
            $this->db->bind(':nombre', $nombre);
            $this->db->bind(':comentario', $comentario);
            $this->db->bind(':tipo', $tipo);
            $this->db->bind(':mime', $mime);
            $this->db->bind(':peso', $peso);
            $this->db->bind(':contenido', $contenido, PDO::PARAM_LOB);

            return $this->db->execute();
        }

        // borra un archivo o carpeta del usuario
        // si es una carpeta, lo que tiene adentro se borra solo por el on delete cascade
        public function deleteElement($id, $idUsuario) {
            $this->db->query('delete from elementos where id = :id and id_usuario = :usuario');
            $this->db->bind(':id', $id);
            $this->db->bind(':usuario', $idUsuario);

            return $this->db->execute();
        }

        // ---------- compartir ----------

        // dice si el elemento esta compartido directamente con ese usuario
        public function isShared($idElemento, $idDestino) {
            $this->db->query('select count(*) as total from compartidos
                              where id_elemento = :elemento and id_usuario_destino = :destino');
            $this->db->bind(':elemento', $idElemento);
            $this->db->bind(':destino', $idDestino);
            $fila = $this->db->single();

            return $fila->total > 0;
        }

        // comparte un archivo o carpeta con otro usuario
        public function shareElement($idElemento, $idDestino) {
            $this->db->query('insert into compartidos (id_elemento, id_usuario_destino)
                              values (:elemento, :destino)');
            $this->db->bind(':elemento', $idElemento);
            $this->db->bind(':destino', $idDestino);

            return $this->db->execute();
        }

        // lo que otros usuarios compartieron conmigo
        public function getSharedWithMe($idUsuario) {
            $this->db->query('select e.id, e.nombre, e.comentario, e.es_carpeta, e.tipo, e.peso, e.fecha,
                                     u.usuario as propietario
                              from compartidos c
                              join elementos e on e.id = c.id_elemento
                              join usuarios u on u.id = e.id_usuario
                              where c.id_usuario_destino = :usuario
                              order by e.es_carpeta desc, e.nombre');
            $this->db->bind(':usuario', $idUsuario);

            return $this->db->resultSet();
        }

        // lo que hay dentro de una carpeta que me compartieron
        public function getSharedContent($idPadre) {
            $this->db->query('select e.id, e.nombre, e.comentario, e.es_carpeta, e.tipo, e.peso, e.fecha,
                                     u.usuario as propietario
                              from elementos e
                              join usuarios u on u.id = e.id_usuario
                              where e.id_padre = :padre
                              order by e.es_carpeta desc, e.nombre');
            $this->db->bind(':padre', $idPadre);

            return $this->db->resultSet();
        }

        // dice si el usuario puede ver un elemento: porque es suyo,
        // porque se lo compartieron o porque esta dentro de una carpeta compartida
        public function canAccess($id, $idUsuario) {
            while ($id > 0) {
                $elemento = $this->getElementById($id);

                if (!$elemento) {
                    return false;
                }

                if ($elemento->id_usuario == $idUsuario) {
                    return true;
                }

                if ($this->isShared($id, $idUsuario)) {
                    return true;
                }

                // si no, se revisa la carpeta que lo contiene
                $id = (int)$elemento->id_padre;
            }

            return false;
        }

        // ruta dentro de una carpeta compartida, desde la carpeta que me compartieron
        public function getSharedPath($idCarpeta, $idUsuario) {
            $ruta = [];

            while ($idCarpeta > 0) {
                $elemento = $this->getElementById($idCarpeta);

                if (!$elemento) {
                    break;
                }

                array_unshift($ruta, $elemento);

                // si llego a la carpeta que me compartieron, ahi termina la ruta
                if ($this->isShared($idCarpeta, $idUsuario)) {
                    break;
                }

                $idCarpeta = (int)$elemento->id_padre;
            }

            return $ruta;
        }
    }