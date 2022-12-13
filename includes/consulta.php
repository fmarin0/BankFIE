<?php
    require 'loanModel.php';
    require 'movimientos.php';

    function generarMovimiento($NoCuenta, $cantidad){
        $movimientos = new Movimientos();
        
        $movimientos -> setNoCuenta($NoCuenta);
        $movimientos -> setCantidad($cantidad);      
        $movimientos -> setAccion(0);      
        
        if ($movimientos -> generarMovimiento()){return true;}

        return false;
    }

    function enviarCorreoPago($NoCuenta, $cantidad, $NoPrestamo){
        $sendMail = new Email();
        $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Pago de mensualidad", "¡Hola  " . consultarName($NoCuenta) . "! tu pago por " . $cantidad . "mxn ha sido abonado exitosamente a tu prestamo " . $NoPrestamo . "." );
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

    function subtractMoney($NoCuenta, $monto){
        try {
            $query = prepararConsulta('UPDATE cuentas SET saldo = :saldo WHERE NoCuenta = :NoCuenta');
            $query -> execute([
                'NoCuenta' => $NoCuenta,
                'saldo'    => getSaldo($NoCuenta) - $monto 
            ]);
            if (generarMovimiento($NoCuenta, $monto)) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    if (isset($_POST['ver'])) {
        $loan = new LoanModel();
        $data = $loan -> getDesglose($_POST['ver']);

        die(json_encode($data));
    }
    
    if (isset($_POST['pagar'])) {
        
        $loan = new LoanModel();
        $data = $loan -> pagos($_POST['pagar']);

        die(json_encode($data));
    }

    if (isset($_POST['pago'])) {
        $info =  validacionGeneral(['cantidad', 'NoPrestamo', 'interes']);
        session_start();
        if(validarSaldo($_SESSION['user'], $_POST['cantidad'])){ $info +=  ['cantidad' => "No dispones con la cantidad suficiente para realizar esta operación."];}
        if(!empty($info)){die(json_encode($info));}

        $loan = new LoanModel();

        if ($_POST['pago'] == 1) {
            $loan -> pagarTotalPrestamo($_POST['NoPrestamo']);
        } else {
            $loan -> pagarPrestamo($_POST['NoPrestamo'], $_POST['interes'], $_POST['cantidad']);
        }

        if (subtractMoney($_SESSION['user'], $_POST['cantidad'])) {
            enviarCorreoPago($_SESSION['user'], $_POST['cantidad'], $_POST['NoPrestamo']);
            die(json_encode([true,'Pago realizado correctamente.']));
        }
        
        die(json_encode([false,'Hubo un error']));
    }
?>