<?php
    require 'db.php';

    $connect = new DB();
    
    global $connect;
    
    $array = array();
    
    function auntheticate($email, $password){
        
        global $connect;
        
        try {
           $query = $connect -> connect() -> prepare('SELECT * FROM users WHERE email = :email');
           $query -> execute(['email' => $email]);

           if ($query -> rowCount() == 1) {
               $client = $query -> fetch(PDO::FETCH_ASSOC);
               
               if (password_verify($password, $client['pass'])) {
                    session_start();
                    $_SESSION['user'] = $client['id'];
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

        $results = auntheticate($_POST['email'],$_POST['password']);

        if ($results === NULL) {
            array_push($array, 'El correo y/o contraseña es incorrecto.');
        } else {
            if ($results === 'admin') {
                header('Location: ejecutivo');
            } else {
                header('Location: cliente');
            }
        }
    }
?>

