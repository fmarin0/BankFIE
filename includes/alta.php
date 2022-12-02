<?php

    require 'db.php';
    $connect = new DB();
    global $connect;

    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['curp']) && isset($_POST['pass'])) {
       try {
           if (validarUsuario($_POST['curp'])) {
               $query2 = $connect -> connect() -> prepare('INSERT INTO clientes (name, NoCuenta, email, curp, pass) VALUES (:name, :NoCuenta, :email, :curp, :pass)');
               $query2 -> execute([
                   'name'       => $_POST['nombre'],
                   'NoCuenta'   => getNumEjecutivo() . '-' . date('Ymdis'),
                   'email'      => $_POST['email'],
                   'curp'       => $_POST['curp'],
                   'pass'       => password_hash($_POST['pass'], PASSWORD_BCRYPT)
                ]);
                
                echo json_encode("El cliente se dio de alta exitosamente");
            }

       } catch (PDOException $e) {
            echo $e;
            return false;
       }
    }


    function validarUsuario($CURP){
        global $connect;

        try {
            $query = $connect -> connect()-> prepare('SELECT curp FROM clientes WHERE curp = :curp');
            $query -> execute(['curp' => $CURP]);
            
            if ($query -> rowCount() == 1) {
                
                return false;
            }
            
            return true;
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