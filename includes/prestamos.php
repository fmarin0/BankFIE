<?php
    require 'validaciones.php';
    require '../libs/loandPHP/londTable.php';
    require '../libs/PHPMailer/email.php';
    require 'movimientos.php';

    function generarMovimiento($NoCuenta, $cantidad){
        $movimientos = new Movimientos();
        
        $movimientos -> setNoCuenta($NoCuenta);
        $movimientos -> setCantidad($cantidad);      
        $movimientos -> setAccion(2);      
        
        if ($movimientos -> generarMovimiento()){return true;}

        return false;
    }

    function enviarCorreo($NoCuenta, $cantidad){
        $sendMail = new Email();
        $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Prestamo", "Felicidades " . consultarName($NoCuenta) . " tu prestamo por " . $cantidad . "mxn ha sido aprovado.");
    }

    function generarPrestamo($NoCuenta, $monto, $plazo){
        try {
            $query = prepararConsulta('INSERT INTO prestamos (NoCuenta, monto, interes, plazo, FeAsignado,interesAcumulado, pagado, status) VALUE (:NoCuenta, :monto, :interes, :plazo, :FeAsignado, :interesAcumulado, :pagado, :status)');
            $query -> execute([
                'NoCuenta'          => $NoCuenta,
                'monto'             => $monto,
                'interes'           => "0.075",
                'plazo'             => $plazo,
                'FeAsignado'        => date("Y-m-d"),
                'interesAcumulado'  => 0,
                'pagado'            => 0,
                'status'            => "Pendiente"
            ]);

            if (sendMoney($NoCuenta, $monto)) {
                enviarCorreo($NoCuenta, $monto);
                return true;
            }

            return false;
            
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function sendMoney($NoCuenta, $monto){
        try {
            $query = prepararConsulta('UPDATE cuentas SET saldo = :saldo WHERE NoCuenta = :NoCuenta');
            $query -> execute([
                'NoCuenta' => $NoCuenta,
                'saldo'    => $monto + getSaldo($NoCuenta)
            ]);
            if (generarMovimiento($_POST['NoCuenta'], $_POST['cant'])) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    function getSaldo($NoCuenta){
        try {
            $query = prepararConsulta('SELECT saldo FROM cuentas WHERE NoCuenta = :NoCuenta');
            $query -> execute(['NoCuenta'=> $NoCuenta]);

            if($query->rowCount() == 1){
                $account = $query -> fetch(PDO::FETCH_ASSOC); 

                return $account['saldo'];
            }
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    if (isset($_POST['cantidad'])) {
        $load = new LoanTable();

        $data = $load -> calcular($_POST['cantidad'], $_POST['plazo']);

        die(json_encode($data));
    }

    if(isset($_POST['NoCuenta'])){
        $info = validacionGeneral(['NoCuenta', 'termino', 'cant']);
            
        if (!existeCliente($_POST['NoCuenta'])){ $info +=  ['NoCuenta' => "El NoCuenta ingresado no existe."]; }
        if (validarPlazo($_POST['termino'])) {   $info +=  ['termino' => "El plazo debe ser mayor a 0 y menor a 60"];}
        if (validarCantidad($_POST['cant'])) {   $info +=  ['cant' => "La cantidad debe ser mayor a 0 y menor a 1,000,001."];}

        if(!empty($info)){die(json_encode($info));}

        if (generarPrestamo($_POST['NoCuenta'], $_POST['cant'], $_POST['termino'])) {
            die(json_encode([true, ""]));
        }
    }
    
?>