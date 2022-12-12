<?php
    class Movimientos {
        private $movimientos;
        private $accion;
        private $cantidad;
        private $NoCuenta;

        function __construct(){
            $this -> movimientos = ['pago', 'retiro', 'prestamo', 'deposito'];
        }

        function generarMovimiento(){
            try {
                $query = prepararConsulta('INSERT INTO movimientos (NoCuenta, accion, cantidad, fecha, saldo) VALUES (:NoCuenta, :accion, :cantidad, :fecha, :saldo)');
                $query -> execute([
                    'NoCuenta'    => $this -> NoCuenta,
                    'accion'      => $this -> accion,
                    'cantidad'    => $this -> cantidad,
                    'fecha'       => date('y-m-d'),
                    'saldo'       => $this -> getSaldo($this -> NoCuenta)
                ]);

                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        function getSaldo(){
            try {
                $query = prepararConsulta('SELECT saldo FROM cuentas WHERE NoCuenta = :NoCuenta');
                $query -> execute(['NoCuenta'=> $this -> NoCuenta]);

                if($query->rowCount() == 1){
                    $account = $query -> fetch(PDO::FETCH_ASSOC); 

                    return $account['saldo'];
                }
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        function setNoCuenta   ($NoCuenta){ $this -> NoCuenta    = $NoCuenta                     ;}
        function setAccion     ($accion  ){ $this -> accion      = $this -> movimientos[$accion] ;}
        function setcantidad   ($cantidad){ $this -> cantidad    = $cantidad                     ;}
    }
?>