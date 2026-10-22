<?php
    class Pages extends Controller {

        public function __construct() {
        }

        // pagina de inicio
        public function index() {
            echo 'paso 3: entro a Pages<br>';

            $data = [
                'titulo' => 'Bienvenida a MyBox'
            ];

            $this->view('pages/index', $data);
        }
    }