<?php
    require 'validaciones.php';
    require '../libs/PHPMailer/email.php';
    require 'movimientos.php';

    function generarMovimiento($NoCuenta, $cantidad, $accion){
        $movimientos = new Movimientos();
        
        $movimientos -> setNoCuenta($NoCuenta);
        $movimientos -> setCantidad($cantidad);      
        $movimientos -> setAccion($accion);      
        
        if ($movimientos -> generarMovimiento()){return true;}

        return false;
    }

    function enviarCorreoRetiro($NoCuenta, $cantidad){
        $sendMail = new Email();
        $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Retiro", "¡Hola  " . consultarName($NoCuenta) . "! has realizado un retiro por la cantidad " . $cantidad . "mxn.");
    }

    function enviarCorreoDeposito($NoCuenta, $cantidad){
        $sendMail = new Email();
        $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Deposito", "¡Hola  " . consultarName($NoCuenta) . "! tu deposito por la " . $cantidad . "mxn ha sido enviado correctamente.");
    }

    function enviarDepositoRecibe($NoCuenta, $cantidad){
        $sendMail = new Email();
        $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Deposito", "¡Hola  " . consultarName($NoCuenta) . "! te han depositado " . $cantidad . "mxn.");
    }

    function enviarReferencia($NoCuenta, $cantidad, $referencia, $accion){
        $sendMail = new Email();
        $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Referencia", "¡Hola  " . consultarName($NoCuenta) . "! aquí tienes tu codigo de referencia ". $referencia ." para que puedas realizar tu " . $accion . " por la cantidad de  " . $cantidad . "mxn, esta referencia la puedes usar en ventanilla en cualquiera de nustras sucursales o puedes ir alguna de las tiendas de conveniencia participantes como Sorina Hiper, OXXO y Comercial Mexicana.");
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

    function sendMoney($NoCuenta, $monto){
        try {
            $query = prepararConsulta('UPDATE cuentas SET saldo = :saldo WHERE NoCuenta = :NoCuenta');
            $query -> execute([
                'NoCuenta' => $NoCuenta,
                'saldo'    => getSaldo($NoCuenta) + $monto
            ]);
            if (generarMovimiento($NoCuenta, $monto, 3)) {
                return true;
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
            if (generarMovimiento($NoCuenta, $monto, 1)) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    if (isset($_POST['NoCuenta']) && !isset($_POST['accion'])) {
        $info = validacionGeneral(['NoCuenta']);
        if (!existeCliente($_POST['NoCuenta'])){ $info +=  ['NoCuenta' => "El NoCuenta ingresado no existe."]; }

        if(!empty($info)){die(json_encode($info));}

        die(json_encode([true, getSaldo($_POST['NoCuenta'])]));
    }

    if (isset($_POST['NoCuenta']) && isset($_POST['accion'])) {
        $info = validacionGeneral(['NoCuenta', 'accion', 'cantidad']);
        if(!existeCliente($_POST['NoCuenta'])){ $info +=  ['NoCuenta' => "El NoCuenta ingresado no existe."]; }
        if($_POST['accion'] == 1) { if(validarSaldo($_POST['NoCuenta'], $_POST['cantidad'])){ $info +=  ['cantidad' => "El cliente no cuenta con sufienciente dinero para realizar esta operación"]; }}
        if(!empty($info)){die(json_encode($info));}

        if ($_POST['accion'] == 1) {
            if (subtractMoney($_POST['NoCuenta'], $_POST['cantidad'])){
                enviarReferencia($_POST['NoCuenta'], $_POST['cantidad'], date("Ymdis") . $_POST['cantidad'], "retiro");
                enviarCorreoRetiro($_POST['NoCuenta'], $_POST['cantidad']);

                die(json_encode([true, ""]));
            }
        } else {
            $info = validacionGeneral(['cuentaDestino']);
            if(!existeCliente($_POST['cuentaDestino'])){ $info +=  ['cuentaDestino' => "La cuenta destino ingresada no existe."]; }

            if(!empty($info)){die(json_encode($info));}

            if (sendMoney($_POST['cuentaDestino'], $_POST['cantidad'])) {
                enviarReferencia($_POST['NoCuenta'], $_POST['cantidad'], date("Ymdis") . $_POST['cantidad'], "deposito");
                enviarDepositoRecibe($_POST['cuentaDestino'], $_POST['cantidad']);
                enviarCorreoDeposito($_POST['NoCuenta'], $_POST['cantidad']);

                die(json_encode([true, ""]));
            }

        }
    }

?>