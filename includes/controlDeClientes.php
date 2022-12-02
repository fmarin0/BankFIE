<?php 

    require 'db.php';
    session_start();    

    function prepararConsulta($sql){
        $conexion = new DB(); 
        $nuevaConsulta = $conexion -> connect() -> prepare($sql);

        return $nuevaConsulta;
    }

    if(isset($_POST['eliminar'])){
        $informacion = '';

        try {
            $consulta = prepararConsulta("UPDATE clientes SET status = 'inactivo' WHERE id = :id");
            $consulta -> execute(['id' => $_POST['eliminar']]);

            $informacion = "Se ha borrado con exito";
        } catch (PDOException $e) {
            echo $e;
            return false;
        }

        die(json_encode($informacion));
    }

    if (isset($_POST['editar'])) {
        $informacion = '';

        try {
            $consulta = prepararConsulta('SELECT * FROM clientes WHERE id = :id');
            $consulta -> execute(['id' => $_POST['editar']]);

            return $informacion;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }

    }
?>