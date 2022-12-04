<?php 

    require 'db.php';
    session_start();
    define('URL-IMG', '/var/www/BankFIE/public/uploads/');    

    function prepararConsulta($sql){
        $conexion = new DB(); 
        $nuevaConsulta = $conexion -> connect() -> prepare($sql);

        return $nuevaConsulta;
    }

    function calcularEdad($fena){
        $nacimiento = new DateTime($fena);
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($nacimiento);
        
        return $diferencia->format("%y");
    }

    function validarDatos($datos){
        $caracteresValidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_#@.áéíóú ";
        $respuesta = [];

        foreach ($datos as $dato) {
            if(empty($_POST[$dato]))
                if ($dato == "name") { $respuesta += [$dato => "El campo <b>nombre</b> esta vacio."];} 
                else {$respuesta += [$dato => "El campo <b>" . $dato . "</b> esta vacio."];}
            for ($j=0; $j < strlen($_POST[$dato]); $j++){
                if (strpos($caracteresValidos, substr($_POST[$dato],$j,1)) === false)
                    if ($dato == "name") { $respuesta += [$dato => "El campo <b>nombre</b> tiene un caracter invalido."]; }
                    else { $respuesta += [$dato => "El campo <b>" . $dato . "</b> tiene un caracter invalido."]; }
            }
        }

        return $respuesta;
    }

    function validarImagen($img){
        $respuesta = [];

        $archivo = basename($img["name"]);
        $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        
        if($tipoArchivo != "jpg"){
            $respuesta += ["img" => "El campo <b>img</b> solo puede aceptar formato jpg."];
        }

        $checarSiImagen = getimagesize($img["tmp_name"]);

        if($checarSiImagen === true){ 
            $respuesta += ["img" => "Hubo un error al ingresar el dato de <b>img</b>."];
         }

        if ($img["size"] > 500000) { 
            $respuesta += ["img" => "La imagen es dasiado grande."];
        }

        return $respuesta;
    }

    function mostrarImagen($id){
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

    if(isset($_POST['eliminar'])){
        try {
            $consulta = prepararConsulta("UPDATE clientes SET status = 'inactivo' WHERE id = :id");
            $consulta -> execute(['id' => $_POST['eliminar']]);

            die(json_encode("Se ha borrado con exito"));
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    if (isset($_POST['editar'])) {
        try {
            $consulta = prepararConsulta('SELECT * FROM clientes WHERE id = :id');
            $consulta -> execute(['id' => $_POST['editar']]);
            $cliente = $consulta -> fetch(PDO::FETCH_ASSOC);

            $informacion = [
                "noCuenta"  => $cliente['NoCuenta'],
                "name"      => $cliente['name'],
                "fena"      => $cliente['fena'],
                "curp"      => $cliente['curp'],
                "domicilio" => $cliente['domicilio'],
                "estado"    => $cliente['estado'],
                "municipio" => $cliente['municipio'],
                "cp"        => $cliente['codPostal'],
                "edad"      => calcularEdad($cliente['fena']),
                "key"       => $cliente['id'],
                "avatar"    => $cliente['imgClient']
            ];

            die(json_encode($informacion));
            
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }


    if (isset($_POST['key'])) {
        $imgClient = mostrarImagen($_POST['key']);
        $info = validarDatos(['name', 'CURP', 'fena', 'estado', 'domicilio', 'municipio', 'codPostal']);

        if (isset($_FILES['img'])) {
            $info += validarImagen($_FILES['img']);

            if (empty($info)) {
                if ($_FILES['img']['name'] != $imgClient) {
                    if (file_exists(constant('URL-IMG') . $imgClient)){
                        unlink(constant('URL-IMG') . $imgClient);
                    }

                    $archivo = constant('URL-IMG') . basename($_FILES['img']['name']);
            
                    if(move_uploaded_file($_FILES['img']['tmp_name'], $archivo)){
                        $imgClient = $_FILES['img']['name'];
                    }
                }
            }
        }

        if (empty($info)) {
            try {
                $consulta = prepararConsulta('UPDATE clientes SET name = :name, fena = :fena, curp = :curp, imgClient = :imgClient, domicilio = :domicilio, codPostal = :codPostal, estado = :estado, municipio = :municipio WHERE id = :id');
                $consulta -> execute([
                    'id'        => $_POST['key'],
                    'name'      => $_POST['name'],
                    'fena'      => $_POST['fena'],
                    'curp'      => $_POST['CURP'],
                    'imgClient' => $imgClient,
                    'estado'    => $_POST['estado'], 
                    'domicilio' => $_POST['domicilio'], 
                    'municipio' => $_POST['municipio'], 
                    'codPostal' => $_POST['codPostal']
                ]);
                
                die(json_encode([TRUE, "La información se ha actualizado correctamente"]));

            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        } else {
            die(json_encode($info));
        }
    }
?>