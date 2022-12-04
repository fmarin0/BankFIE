<?php

    require 'db.php';
    session_start();    
    
    function prepararConsulta($sql){
        $conexion = new DB(); 
        $nuevaConsulta = $conexion -> connect() -> prepare($sql);

        return $nuevaConsulta;
    }

    function TablaClientes(){
        $prefijo = numeroDelEjecutivo();

        if ($prefijo === NULL) { return "Error al cargar la tabla."; }

        try {
            $consulta = prepararConsulta("SELECT * FROM clientes WHERE NoCuenta LIKE '" . $prefijo ."%' ORDER BY status");
            $consulta -> execute();
            $clientes = $consulta -> fetchAll(PDO::FETCH_OBJ); 

            $informacion = '';

            foreach ($clientes as $cliente) {
                if ($cliente -> status === 'inactivo')
                    $informacion .= '
                             <tr>
                                <td>'. $cliente -> id    .'</td>
                                <td>'. $cliente -> name  .'</td>
                                <td><span class="'.$cliente -> status.'"><i class="fa-solid fa-circle"></i></span></td>
                                <td class="text-center">--</td>
                                <td class="text-center">--</td>
                            </tr>';
                else    
                    $informacion .= '
                            <tr>
                                <td>'. $cliente -> id    .'</td>
                                <td>'. $cliente -> name  .'</td>
                                <td><span class="'.$cliente -> status.'"><i class="fa-solid fa-circle"></i></span></td>
                                <td>
                                    <form action="#" id="formEditar'. $cliente -> id .'">
                                        <input type="hidden" name="editar" value="'.$cliente -> id .'">
                                        <button type="button" onclick="modalOpen('.$cliente -> id .')" class="ver"><i class="fa-light fa-eye"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" id="FormEliminar'.$cliente -> id .'">
                                        <input  type="hidden" name="eliminar" value="'.$cliente -> id .'">
                                        <button type="button" class="eliminar" onclick="Eliminar('.$cliente -> id .')"><i class="fa-light fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>'; 
            }

            return $informacion;

        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function numeroDelEjecutivo(){
        try {
            $consulta = prepararConsulta('SELECT num_client FROM users WHERE id = :id');
            $consulta -> execute(['id' => $_SESSION['user']]);

            if ($consulta -> rowCount() == 1) {
                $cliente = $consulta -> fetch(PDO::FETCH_ASSOC);

                return $cliente['num_client'][0];
            }

            return NULL;

        } catch (PDOException $e) {
            echo $e;
            return NULL;
        }
    }

    function separPorEspacios($cadena){
        $separador = " ";
        $cadenaSeparada = explode($separador, $cadena);

        return $cadenaSeparada;
    }

    echo json_encode(TablaClientes());
?>