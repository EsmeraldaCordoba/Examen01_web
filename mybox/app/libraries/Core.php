<?php
    // esta clase lee la direccion y decide que controlador y metodo se ejecutan
    // formato de la url: /controlador/metodo/parametro1/parametro2
    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct() {
            $url = $this->getUrl();

            // buscar si existe el controlador que piden
            if (isset($url[0]) && file_exists(appRoot . '/controllers/' . ucwords($url[0]) . '.php')) {
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            require_once appRoot . '/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController;

            // buscar si existe el metodo dentro del controlador
            if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }

            // lo que sobre en la url son los parametros
            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        // el .htaccess manda la ruta en $_GET['page']
        public function getUrl() {
            if (isset($_GET['page'])) {
                $url = rtrim($_GET['page'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                return explode('/', $url);
            }
            return [];
        }
    }