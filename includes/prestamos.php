<?php

    require 'db.php';
    $connect = new DB();
    global $connect;

    if (isset($_POST['NoCuenta']) && isset($_POST['cant'])) {
       try {
           if (validarUsuario($_POST['NoCuenta'])) {
               $query = $connect -> connect() -> prepare('');
                echo json_encode("El cliente se dio de alta exitosamente");
            }

       } catch (PDOException $e) {
            echo $e;
            return false;
       }
    }


    function validarUsuario($NoCuenta){
        global $connect;

        try {
            $query = $connect -> connect()-> prepare('SELECT NoCuenta FROM clientes WHERE NoCuenta = :NoCuenta');
            $query -> execute(['NoCuenta' => $NoCuenta]);
            
            if ($query -> rowCount() == 1) {
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function getNumEjecutivo(){
        global $connect;
        session_start();
        
        try {
            $query = $connect -> connect() -> prepare('SELECT * FROM users WHERE id = :id');
            $query -> execute(['id' => $_SESSION['user']]);

            if ($query -> rowCount() == 1) {
                $client = $query -> fetch(PDO::FETCH_ASSOC);

                return $client['num_client'][0];
            }

            return NULL;

        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }
?>