<?php

    require 'validaciones.php';    
    $array = array();
    
    function auntheticateEjecutivo($email, $password){
        try {
           $query = prepararConsulta('SELECT * FROM users WHERE email = :email');
           $query -> execute(['email' => $email]);

           if ($query -> rowCount() == 1) {
               $client = $query -> fetch(PDO::FETCH_ASSOC);
               
               if (password_verify($password, $client['pass'])) {
                    session_start();
                    $_SESSION['user'] = $client['num_client'];
                    return $client['role'];
                }

               return NULL;
           }
           return NULL;
        } catch (PDOException $e) {
           echo $e;
           return NULL;
        }    
    }

    function auntheticateCliente($email, $password){
        try {
           $query = prepararConsulta('SELECT * FROM clientes WHERE email = :email');
           $query -> execute(['email' => $email]);

           if ($query -> rowCount() == 1) {
               $client = $query -> fetch(PDO::FETCH_ASSOC);
               
               if (password_verify($password, $client['pass'])) {
                    session_start();
                    $_SESSION['user'] = $client['NoCuenta'];

                    return $client['role'];
                }

               return NULL;
           }
           return NULL;
        } catch (PDOException $e) {
           echo $e;
           return NULL;
        }    
    }

    if (isset($_POST['email']) && isset($_POST['password'])){
        if (empty($_POST['email']) && empty($_POST['pasword'])){
            array_push($array, 'Asegurate que hayas ingresado los datos correctamente.');
        }

        if ($results = auntheticateEjecutivo($_POST['email'],$_POST['password']) === NULL) {
            $results = auntheticateCliente($_POST['email'],$_POST['password']);

            if($results === NULL){ array_push($array, 'El correo y/o contraseña es incorrecto.'); return;}

            header('Location: cliente');

        } else {
            header('Location: ejecutivo');
        }
    }
?>

