<?php 

    require 'validaciones.php';

    function calcularEdad($fena){
        $nacimiento = new DateTime($fena);
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($nacimiento);
        
        return $diferencia->format("%y");
    }

    function gurdarNuevaImagen($imagen){
        $origen  = $imagen['tmp_name'];
        $destino = constant('URL-IMG') . basename($imagen['name']);

        if(move_uploaded_file($origen, $destino)){
            return true;
        }
    }

    function borrarImgAnterior($archivo){
        if (existeArchivo($archivo)){
            unlink(constant('URL-IMG') . $archivo);
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
        $imgClient = consultarImg($_POST['key']);
        $info = validacionGeneral(['name', 'CURP', 'fena', 'estado', 'domicilio', 'municipio', 'codPostal']);

        if (existeFILES('img')) {
            $info += validacionGeneralImg(['img']);

            if (empty($info)) {
                if (validarNuevaImg($_POST['key'],$_FILES['img']['name'])) {

                    borrarImgAnterior($imgClient);

                    if(gurdarNuevaImagen($_FILES['img'])){
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