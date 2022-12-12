<?php

    require 'db.php';
    session_start();

    function consultarStatus(){
        $conexion = new DB();

        try {
            $consulta = $conexion -> connect() -> prepare('SELECT * FROM users WHERE num_client = :num_client');
            $consulta -> execute(['num_client' => $_SESSION['user']]);
            $respueta = $consulta -> fetch(PDO::FETCH_ASSOC);

            $user = null;

            if (is_countable($respueta) && count($respueta) > 0) {$user = $respueta;}

            return $user;
        } catch (PDOException $e){
            return false;
        }
    }



    if (!isset($_SESSION['user'])) { header('Location: http://bankfie.com');}
    else { 

        $user = consultarStatus();

        if ($user == null) {
            header('Location: http://bankfie.com/cliente'); 
        }
    }

?>