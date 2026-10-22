<?php
    // clase base, todos los controladores heredan de esta
    class Controller {

        // carga un modelo y devuelve el objeto
        public function model($model) {
            require_once appRoot . '/models/' . $model . '.php';
            return new $model();
        }

        // carga una vista y le pasa los datos
        public function view($view, $data = []) {
            if (file_exists(appRoot . '/views/' . $view . '.php')) {
                require appRoot . '/views/' . $view . '.php';
            } else {
                die('La vista no existe: ' . $view);
            }
        }
    }