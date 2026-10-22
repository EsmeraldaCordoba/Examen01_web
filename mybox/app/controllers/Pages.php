<?php
    class Pages extends Controller {

        public function __construct() {
        }

        // pagina de inicio
        public function index() {

            $data = [
                'titulo' => 'Bienvenida a MyBox'
            ];

            $this->view('pages/index', $data);
        }
    }