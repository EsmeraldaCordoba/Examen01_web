<?php
    // se inicia la sesion una sola vez para todo el sitio
    session_start();

    // dice si hay un usuario con sesion iniciada
    function isLoggedIn() {
        if (isset($_SESSION['id_usuario'])) {
            return true;
        } else {
            return false;
        }
    }