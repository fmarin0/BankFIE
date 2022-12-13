<?php

    require 'validaciones.php';
    session_start();

    function TablaPrestamos(){
        $error       = '<td colspan="6">Aún no tienes prestamos, si desas sacar un prestamo ve a la sucursal más sercana.</td>';
        $informacion = '';

        try {
            $consulta = prepararConsulta("SELECT * FROM prestamos WHERE NoCuenta = :NoCuenta AND status = 'pendiente'");
            $consulta -> execute(['NoCuenta'=> $_SESSION['user']]);
            $prestamos = $consulta -> fetchAll(PDO::FETCH_OBJ); 

            if (count($prestamos) <= 0) { return $error; }

            foreach ($prestamos as $prestamo) {

                $informacion .= '
                            <tr>
                                <td class="text-center">'. $prestamo -> NoPrestamo.'</td>
                                <td class="text-center">'. $prestamo -> monto     .'</td>
                                <td class="text-center">7.5%</td>
                                <td class="text-center">'. $prestamo -> plazo     .'</td>
                                <td class="text-center">
                                    <form action="#" id="formVer'. $prestamo -> NoPrestamo .'">
                                        <input type="hidden" name="ver" value="'.$prestamo -> NoPrestamo .'">
                                        <button type="button" onclick="modalOpen('.$prestamo -> NoPrestamo .')" class="ver"><i class="fa-light fa-eye"></i></button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form method="post" id="FormPagar'.$prestamo -> NoPrestamo .'">
                                        <input  type="hidden" name="pagar" value="'.$prestamo -> NoPrestamo .'">
                                        <button type="button" class="pagar" onclick="modalOpen2('.$prestamo -> NoPrestamo .')"><i class="fa-duotone fa-dollar-sign"></i></button>
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


echo json_encode(TablaPrestamos());

?>