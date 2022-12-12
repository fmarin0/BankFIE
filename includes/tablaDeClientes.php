<?php

    require 'validaciones.php';
    session_start();

    

    function escape($string){
        $res = '';
        for($i = 0; $i < strlen($string); ++$i) {
            $char = $string[$i];
            $ord = ord($char);

            if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
                $res .= $char;
            else
                $res .= '\\x' . dechex($ord);
        }

        return $res;
    }

    function TablaClientes($busqueda){
        $prefijo = $_SESSION['user'][0];
        $error   = '<td colspan="5">No hay clientes aún.</td>';
        
        if ($prefijo === NULL) { return '<td colspan="5">Error al cargar la tabla.</td>'; }
        
        $sql = "SELECT * FROM clientes WHERE NoCuenta LIKE '" . $prefijo ."%' ORDER BY status";
        $informacion = '';

        if ($busqueda !== NULL) {
            $error   = '<td colspan="5">No hay clientes que coincidan con sus criterios de busqueda.</td>';
            $q = escape($busqueda);
            $sql = "SELECT * FROM clientes WHERE NoCuenta LIKE '". $prefijo ."%' AND name LIKE '%". $q ."%' ORDER BY status";   
        }

        try {
            $consulta = prepararConsulta($sql);
            $consulta -> execute();
            $clientes = $consulta -> fetchAll(PDO::FETCH_OBJ); 
            
            if (count($clientes) <= 0) { return $error; }

            foreach ($clientes as $cliente) {
                $status = $cliente -> status === 'inactivo' ? 'inactivo' : 'activo';
                       
                $informacion .= '
                            <tr>
                                <td>'. $cliente -> id    .'</td>
                                <td>'. $cliente -> name  .'</td>
                                <td><span class="'.$status.'"><i class="fa-solid fa-circle"></i></span></td>
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

    $buscar = NULL;

    if (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
        $buscar = $_POST['busqueda'];
    }

    echo json_encode(TablaClientes($buscar));
?>