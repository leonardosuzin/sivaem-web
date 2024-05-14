<?php

class SessionManager {
    public function __construct() {
        session_start();
    }

    public function checkSessionCliente() {
        if(empty($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['tipo_user'] == 2){
            header('location: /sivaem-web-main/index.php');
            exit(); // Termina o script após redirecionar
        }
    }

    public function checkSessionEmpresa() {
        if(empty($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['tipo_user'] == 1){
            header('location: /sivaem-web-main/index.php');
            exit(); // Termina o script após redirecionar
        }
    }
}

?>