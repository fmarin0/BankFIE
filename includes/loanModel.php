<?php 
    require 'validaciones.php';
    require '../libs/PHPMailer/email.php';
    
    class LoanModel {
        private $NoCuenta         ;
        private $NoPrestamo       ;
        private $monto            ;
        private $interes          ;
        private $plazo            ;
        private $FeAsignado       ;
        private $interesAcumulado ;
        private $pagado           ;
        private $status           ;

        private $cuota            ;
        private $interesTotal     ;
        private $dataPayment      = array();

        function getPrestamo($NoPrestamo){
            try{
                $query = prepararConsulta('SELECT * FROM prestamos WHERE NoPrestamo = :NoPrestamo');
                $query->execute(['NoPrestamo' => $NoPrestamo]);
                
                if($query->rowCount() == 1){
                    $item = $query -> fetch(PDO::FETCH_ASSOC); 
                    $this  -> from($item);                
                }
            }catch(PDOException $e){
                return NULL;
            }
        }

        function enviarFelicitacion($NoCuenta, $NoPrestamo){
            $sendMail = new Email();
            $sendMail -> sendMail(consultarEmailPorNoCuenta($NoCuenta), consultarName($NoCuenta), "Felicidades", "¡Hola  " . consultarName($NoCuenta) . "! Muchas felicidades has pagado el total de tu prestamo " . $NoPrestamo . ".");
        }

        function getDesglose($NoPrestamo){
            $this -> getPrestamo($NoPrestamo);
            $this -> dateCal();
            $this -> cuotaFija();
            $data = '';

            $año = $this -> separateDate(2);
            $mes = $this -> separateDate(5);
            $dia = $this -> separateDate(8);

            for ($i=0; $i < $this -> plazo; $i++) { 

                if ($mes < 12) { 
                    $mes += 1;
                } else {
                    $mes =  1;
                    $año += 1;
                }

                $pagos = $this -> calcularPagosRealizados();
                $fecha = $año . '-' . $this -> ceros($mes) . '-' .  $this -> ceros($dia);

                if ($pagos != NULL && $i <= $pagos - 1) {
                    $style = 'pagado';
                } else {
                    $fechaInversa = $this -> ceros($dia) . '-' . $this -> ceros($mes) . '-' .  $año;
                    
                    if ($this -> differenceDate($fechaInversa)) {
                        $style = 'atrasado';
                        $this -> interesAcumulado += $this -> calInteres($this -> ceros($dia), $this -> ceros($mes), $año);
                    } else if($this -> differenceDate($fechaInversa) === NULL) {
                        $style = 'pendiete';
                    } else {
                        $style = '';
                    }
                }         

                $data .= '
                    <tr>
                        <td>'.$i + 1  .'</td>
                        <td>'.$fecha .'</td>
                        <td class="'. $style .' text-center"><i class="fa-solid fa-circle"></i></td>
                        <td>'.$this -> decimales($this -> cuota).'</td>
                    </tr>
                ';
            }

            $data .= '
                <tr>
                    <td class="text-right" colspan="3">Interes moratorios: </td>
                    <td>'. $this -> decimales($this -> interesAcumulado) .'</td>
                </tr>
                <tr>
                    <td class="text-right"  colspan="3">Total:</td>
                    <td>'.$this -> decimales($this -> cuota * $this -> plazo + $this -> interesAcumulado) .'</td>
                </tr>
            '; 
            
            return $data;
        }

        function pagarPrestamo($NoPrestamo,$interes, $cantidad){
            $this -> getPrestamo($NoPrestamo);
            $this -> cuotaFija();
            $NoPago = $this -> calcularPagosRealizados() !== NULL ? $this -> calcularPagosRealizados() : 0;

            try {
                $query = prepararConsulta("UPDATE prestamos SET interesAcumulado = :interesAcumulado, pagado = :pagado WHERE NoPrestamo = :NoPrestamo");
                $query -> execute([
                    "NoPrestamo"       => $NoPrestamo, 
                    "interesAcumulado" => $interes,
                    "pagado"           => ($cantidad - $interes) + $this -> pagado,
                ]);

                if ($NoPago + 1 == $this -> plazo) {
                    $this -> pagarTotalPrestamo($NoPrestamo);
                }

                return true;

            } catch(PDOException $e){
                echo $e;
                return false;
            }
        }

        function pagarTotalPrestamo($NoPrestamo){
            $this -> getPrestamo($NoPrestamo);
            
            try {
                $query = prepararConsulta("UPDATE prestamos SET status = 'pagado' WHERE NoPrestamo = :NoPrestamo");
                $query -> execute(['NoPrestamo' => $NoPrestamo]);

                if ($this -> enviarFelicitacion($this -> NoCuenta, $NoPrestamo)) {
                    return true;
                }

            } catch(PDOException $e){
                echo $e;
                return false;              
            }
        }

        function pagos($NoPrestamo){
            $this -> getPrestamo($NoPrestamo);
            $this -> dateCal();
            $this -> cuotaFija();
            $data = '';

            $año = $this -> separateDate(2);
            $mes = $this -> separateDate(5);
            $dia = $this -> separateDate(8);

            for ($i=0; $i < $this -> plazo; $i++) { 

                if ($mes < 12) { 
                    $mes += 1;
                } else {
                    $mes =  1;
                    $año += 1;
                }

                $pagos = $this -> calcularPagosRealizados();

                if ($pagos != NULL && $i <= $pagos - 1) {
                } else {
                    $fechaInversa = $this -> ceros($dia) . '-' . $this -> ceros($mes) . '-' .  $año;
                    
                    if ($this -> differenceDate($fechaInversa)) {
                        if ($pagos != NULL && $i == $pagos) {
                            $interes = $this -> calInteres($this -> ceros($dia), $this -> ceros($mes), $año);
                        } else if ($pagos === NULL && $i == 0) {
                            $interes = $this -> calInteres($this -> ceros($dia), $this -> ceros($mes), $año);
                        }

                        $this -> interesAcumulado += $this -> calInteres($this -> ceros($dia), $this -> ceros($mes), $año);
                    }
                }

                $NoPago = $pagos === NULL ? 0 : $pagos ;

                $data = [
                    "mensualidad"    => $this -> decimales($this -> cuota),
                    "NoMensualidad"  => $NoPago,
                    "interesTotal"   => $this -> decimales($this -> interesAcumulado),
                    "interesMensual" => $this -> decimales($interes),
                    "total"          => $this -> decimales($this -> cuota * ($this -> plazo - $pagos)),
                    "saldo"          => $this -> decimales($this -> getSaldo($this -> NoCuenta)),
                    "plazo"          => $this -> plazo
                ];
            }

            return $data;
        }


        function getSaldo($NoCuenta){
            try {
                $query = prepararConsulta('SELECT saldo FROM cuentas WHERE NoCuenta = :NoCuenta');
                $query -> execute(['NoCuenta' => $NoCuenta]); 
                $saldo = $query -> fetch(PDO::FETCH_ASSOC);
            
                return $saldo['saldo'];
                
            } catch (PDOException $e){
                echo $e;
                return false;
            } 
        }

        function dateCal(){
            $año = $this -> separateDate(2);
            $mes = $this -> separateDate(5);
            $dia = $this -> separateDate(8);

            for ($i=1; $i <= $this -> plazo; $i++) { 
                if ($mes < 12) { 
                    $mes += 1;
                } else {
                    $mes =  1; 
                    $año += 1;
                }

                array_push($this -> dataPayment, $año . '-' . $this -> ceros($mes) . '-' . $this -> ceros($dia));
            }
        }

        function calDiasDeAtraso($dia, $mes, $año){  

            $fecha  = mktime(0,0,0,$mes,$dia,$año);
            $fecha2 = mktime(4,12,0,date('m'),date('d'),date('Y'));

            $calDiferencia = $fecha - $fecha2;
            
            $value = $calDiferencia / (60 * 60 * 24);
            $value = abs($value);
            $value = floor($value);
                        
            return $value;
        }

        function cuotaFija(){
            $this -> cuota = $this -> monto * ((pow(1+$this->interes/12,$this->plazo)*$this->interes/12) / (pow(1+$this->interes/12,$this->plazo)-1)); 
        }

        function reacomodarFecha($fecha){
            $this -> FeAsignado = $fecha;

            $año = $this -> separateDate(2);
            $mes = $this -> separateDate(5);
            $dia = $this -> separateDate(8);

            return $dia. '-' . $this -> ceros($mes) . '-' . $año;
        }

        function separateDate($n){
            $result = '';
    
            for ($i = $n; $i <= $n+1; $i++) 
                $result .= $this -> FeAsignado[$i];

            if ($n === 2) 
                $result = (int)'20'. $result;
            
            return (int)$result;
        }

        function differenceDate($fecha){
            $fecha_actual  = strtotime(date('d-m-Y'));
            $fecha_entrada = strtotime($fecha);

            if($fecha_actual > $fecha_entrada){return true;}
            else if ($fecha_actual == $fecha_entrada){return NULL;}
                
            return false;
        }

        function dateValidate($fecha,$fecha2){
            $fecha_actual  = strtotime($fecha2);
            $fecha_entrada = strtotime($fecha);

            if($fecha_actual <= $fecha_entrada)
                return true;
            
            return false;
        }

        function calInteres($dia, $mes, $año){
            $this -> calInteresTotal();
            $DiasAtraso = $this -> calDiasDeAtraso($dia, $mes, $año);

            $interes =  $this -> interesTotal / $this -> plazo;
            
            return $DiasAtraso * $interes;
        }

        function calcularPagosRealizados(){
            $pagos = null;

            if ($this -> pagado != 0) {
                $pagos = $this -> pagado/$this -> cuota;
                $pagos = ceil($pagos);
            }

            return $pagos;

        }

        function calInteresTotal(){$this -> interesTotal = ($this -> plazo * $this -> cuota) - $this -> monto;}
        function ceros($value){return str_pad($value, 2, "0", STR_PAD_LEFT);}
        function decimales($value){return number_format($value, 2, '.', '');}

        public function from($array){
            $this -> NoCuenta         = $array['NoCuenta'];
            $this -> NoPrestamo       = $array['NoPrestamo'];
            $this -> monto            = $array['monto'];
            $this -> interes          = $array['interes'];
            $this -> plazo            = $array['plazo'];
            $this -> FeAsignado       = $array['feAsignado'];
            $this -> interesAcumulado = $array['interesAcumulado'];
            $this -> pagado           = $array['pagado'];
            $this -> status           = $array['status'];
        }

        function getNoCuenta         (){ return $this -> NoCuenta         ; }
        function getNoPrestamo       (){ return $this -> NoPrestamo       ; }
        function getMonto            (){ return $this -> monto            ; }
        function getInteres          (){ return $this -> interes          ; }
        function getPlazo            (){ return $this -> plazo            ; }
        function getFeAsignado       (){ return $this -> FeAsignado       ; }
        function getInteresAcumulado (){ return $this -> interesAcumulado ; }
        function getPagado           (){ return $this -> pagado           ; }
        function getStatus           (){ return $this -> status           ; }
    }

?>