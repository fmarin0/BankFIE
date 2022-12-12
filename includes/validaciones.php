<?php
    require 'db.php';
    require 'rutes.php';

    function prepararConsulta($sql){
        $conexion = new DB(); 
        $nuevaConsulta = $conexion -> connect() -> prepare($sql);

        return $nuevaConsulta;
    }

    function consultarImg($id){
        try {
            $query = prepararConsulta('SELECT imgClient FROM clientes WHERE id = :id');
            $query -> execute(['id' => $id]); 
            $img_client = $query -> fetch(PDO::FETCH_ASSOC);

            return $img_client['imgClient'];
        } catch (PDOException $e){
            echo $e;
            return false;
        } 
    }

    function consultarCURP($id){
        try {
            $query = prepararConsulta('SELECT curp FROM clientes WHERE id = :id');
            $query -> execute(['id' => $id]); 
            $img_client = $query -> fetch(PDO::FETCH_ASSOC);

            return $img_client['curp'];
        } catch (PDOException $e){
            echo $e;
            return false;
        } 
    }

    function existeCURP($CURP){
        try {
            $query = prepararConsulta('SELECT curp FROM clientes WHERE curp = :curp');
            $query -> execute(['curp' => $CURP]);
            
            if ($query -> rowCount() == 1) { return true;}
            
            return false;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function existeCliente($NoCuenta){
        try {
            $query = prepararConsulta('SELECT NoCuenta FROM clientes WHERE NoCuenta = :NoCuenta');
            $query -> execute(['NoCuenta' => $NoCuenta]);
            
            if ($query -> rowCount() == 1) { return true;}
            
            return false;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function consultarEmail($id){
        try {
            $query = prepararConsulta('SELECT email FROM clientes WHERE id = :id');
            $query -> execute(['id' => $id]); 
            $email = $query -> fetch(PDO::FETCH_ASSOC);

            return $email['email'];
        } catch (PDOException $e){
            echo $e;
            return false;
        } 
    }

    function consultarEmailPorNoCuenta($NoCuenta){
        try {
            $query = prepararConsulta('SELECT email FROM clientes WHERE NoCuenta = :NoCuenta');
            $query -> execute(['NoCuenta' => $NoCuenta]); 
            $email = $query -> fetch(PDO::FETCH_ASSOC);

            return $email['email'];
        } catch (PDOException $e){
            echo $e;
            return false;
        } 
    }

    function consultarName($NoCuenta){
        try {
            $query = prepararConsulta('SELECT name FROM clientes WHERE NoCuenta = :NoCuenta');
            $query -> execute(['NoCuenta' => $NoCuenta]); 
            $name = $query -> fetch(PDO::FETCH_ASSOC);

            return $name['name'];
        } catch (PDOException $e){
            echo $e;
            return false;
        } 
    }

    function validarSaldo($NoCuenta, $cantidad){
        try {
            $query = prepararConsulta('SELECT saldo FROM cuentas WHERE NoCuenta = :NoCuenta');
            $query -> execute(['NoCuenta' => $NoCuenta]); 
            $saldo = $query -> fetch(PDO::FETCH_ASSOC);

            if ($saldo['saldo'] >= $cantidad) {
                return false;
            }

            return true;
            
        } catch (PDOException $e){
            echo $e;
            return false;
        } 
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////

    function existePOST($dato){
        if (!isset($_POST[$dato])) 
            return true;
            
        return false;
    }

    function existeSESSION($dato){
        session_start();

        if (!isset($_SESSION[$dato])) 
            return true;
    }

    function existeFILES($dato){
        if (isset($_FILES[$dato])) 
            return true;

        return false;
    }

    function datosVacios($dato){
        if (empty($_POST[$dato])) 
            return true;

        return false;
    }

    function caracteresValidos($dato){
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_#@.áéíóú ";

        for ($j = 0; $j < strlen($_POST[$dato]); $j++){ 
            if (strpos($caracteres, substr($_POST[$dato],$j,1)) === false)
                return true;
        }

        return false;
    }

    function validarImg($dato){
        if (getimagesize($dato["tmp_name"]) === TRUE)
            return true;
    }

    function validarImgTam($dato){
        if ($dato["size"] > 500000) { 
            return true;
        }
    }

    function validarImgFormato($dato){
        $archivo = basename($dato["name"]);
                
        if(strtolower(pathinfo($archivo, PATHINFO_EXTENSION)) != "jpg")
            return true;
    }

    function existeArchivo($archivo){
        if (file_exists(constant('URL-IMG') . $archivo)){
            return true;
        }
    }

    function validarNuevaImg($id, $nuevaImg){
        $img_client = consultarImg($id);

        if ($nuevaImg != $img_client) {
            return true;
        }
    }

    function arrayVacio($array){

    }

    function validarEdad($fecha){
        $nacimiento = new DateTime($fecha);
        $ahora      = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($nacimiento);
        
        if ($diferencia->format("%y")<18) {
            return true;
        }

        return false;
    }

    function validacionGeneral($parametros){
        $respuesta = [];

        foreach ($parametros as $parametro) {
            if (existePOST($parametro)) {
                return NULL;
            }

            if (datosVacios($parametro)) {
                $respuesta += [$parametro => "El campo <b>" . $parametro . "</b> esta vacío."];
            }

            if (caracteresValidos($parametro)) {
                $respuesta += [$parametro => "El campo <b>" . $parametro . "</b> tiene un caracter invalido."];
            }
        }

        return $respuesta;
    }

    function validacionGeneralImg($parametros){
        $respuesta = [];

        foreach ($parametros as $parametro) {
            if (validarImg($_FILES[$parametro])) {
                $respuesta += ["img" => "El archivo ingresado en <b>img</b> no es una imagen, asegurse de elegir una imagen en formato jpg."];
            }

            if (validarImgFormato($_FILES[$parametro])) {
                $respuesta += ["img" => "El formato en <b>img</b> es incorrecto, asegurse de elegir una imagen en formato jpg."];
            }
        }

        return $respuesta;
    }

    function validarCantidad($cantidad){
        if ($cantidad != ''     && 
            $cantidad != 0      && 
            $cantidad < 1000001
        ) {
          return false;
        }

        return true;
    }

    function validarPlazo($plazo){
        if ($plazo != ''&& 
            $plazo != 0 && 
            $plazo < 61
        ) {
          return false;
        }

        return true;
    }
?>