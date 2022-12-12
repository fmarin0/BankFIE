<?php

    require 'db.php';
    session_start();

    function consultarStatus(){
        $conexion = new DB();
        
        try {
            $consulta = $conexion -> connect() -> prepare('SELECT * FROM clientes WHERE NoCuenta = :NoCuenta');
            $consulta -> execute(['NoCuenta' => $_SESSION['user']]);
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
            header('Location: http://bankfie.com/ejecutivo'); 
        }
    }

?>