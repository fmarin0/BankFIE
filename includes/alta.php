<?php
    require 'validaciones.php';
    require '../libs/PHPMailer/email.php';

    function gurdarNuevaImagen($imagen){
        $origen  = $imagen['tmp_name'];
        $destino = constant('URL-IMG') . basename($imagen['name']);

        if(move_uploaded_file($origen, $destino)){
            return true;
        }
    }

    function enviarCorreo($correo,$nombre,$pass){
        $sendMail = new Email();
        $sendMail -> sendMail($correo, $nombre, "Alta de cliente", "Felicidades has sido aceptado tu contraseña es " . $pass);
    }

    function crearNoCuenta(){
        return $_SESSION['user'][0] . '-' . date('Ymdis');
    }

    function generarPass(){
        $newpass = "";
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
        $max = strlen($pattern)-1;

        for($i = 0; $i < 10; $i++){ 
            $newpass .= substr($pattern, mt_rand(0,$max), 1);
        }

        return $newpass;
    }

    function cifrarPass($pass){ return password_hash($pass, PASSWORD_BCRYPT);}

    function guardarNuevoCliente($parametros){   
        try {
            $insertar = prepararConsulta('INSERT INTO clientes (NoCuenta, name, fena, curp, imgClient, domicilio, codPostal, estado, municipio, email, pass) VALUES (:NoCuenta, :name, :fena, :curp, :imgClient, :domicilio, :codPostal, :estado, :municipio, :email, :pass)');
            $insertar -> execute([
                "NoCuenta"  => $parametros['NoCuenta'],    
                "name"      => $parametros['name'],
                "fena"      => $parametros['fena'],
                "curp"      => $parametros['curp'],
                "imgClient" => $parametros['imgClient'],     
                "domicilio" => $parametros['domicilio'],     
                "codPostal" => $parametros['codPostal'],     
                "estado"    => $parametros['estado'],  
                "municipio" => $parametros['municipio'],     
                "email"     => $parametros['email'], 
                "pass"      => $parametros['pass']
            ]);

            if (crearNuevaCuenta($parametros['NoCuenta'])) {
                return true;
            }

        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function crearNuevaCuenta($NoCuenta){
        try {
            $insertar = prepararConsulta('INSERT INTO cuentas (NoCuenta, saldo) VALUES (:NoCuenta, :saldo)');
            $insertar -> execute([
                "NoCuenta"  => $NoCuenta,    
                "saldo"     => 0
            ]);

            return true;

        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    if (isset($_POST['CURP'])) {
        $info = validacionGeneral(['nombre', 'CURP', 'fena', 'estado', 'domicilio', 'municipio', 'codPostal', 'email']);

        $info += existeFILES('img') ? validacionGeneralImg(['img']) : $info += ["img" => "No has ingresado una imagen."] ;

        if (existeCURP($_POST['CURP'])){ $info += ["CURP" => "La CURP ingresada ya existe."];}
        if (validarEdad($_POST['fena'])){ $info += ["fena" => "El cliente debe ser mayor de edad."];}
        
        if(!empty($info)){die(json_encode($info));}
        
        gurdarNuevaImagen($_FILES['img']);
        $contraseña = generarPass();
        $imagen     = $_FILES['img']['name'];

        $data = [
            "NoCuenta"  => crearNoCuenta(),
            "name"      => $_POST['nombre'],
            "fena"      => $_POST['fena'],
            "curp"      => $_POST['CURP'],
            "imgClient" => $imagen,
            "domicilio" => $_POST['domicilio'],
            "codPostal" => $_POST['codPostal'],
            "estado"    => $_POST['estado'],
            "municipio" => $_POST['municipio'],
            "email"     => $_POST['email'],
            "pass"      => cifrarPass($contraseña)
        ];

        
        if (guardarNuevoCliente($data)) {
            enviarCorreo($_POST['email'],$_POST['nombre'],$contraseña);
            die(json_encode([true, 'Cliente guardado correctamente.']));            
        }

        die(json_encode(['error', 'No se ha podido guardar el cliente.']));
    }
?>