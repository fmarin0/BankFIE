
<?php
    class LoanTable {
        
        private $cantPrestamo;
        private $plazo;
        private $interes;
        private $cuota;
        private $totalIntereses;
        private $tableHtml;

        function __construct(){
            $this -> cuota          = 0;
            $this -> interes        = 0.075/12;
            $this -> totalIntereses = 0;
            $this -> tableHtml      = '';
        }

        function cuotaFija(){
            $this -> cuota = $this -> cantPrestamo * ((pow(1+$this->interes,$this->plazo)*$this->interes) / (pow(1+$this->interes,$this->plazo)-1)); 
        }

        function calcular($cant, $plazo){
            $this -> cantPrestamo = $cant;
            $this -> plazo        = $plazo;
            $this -> cuotaFija();
            $this -> intereTotal();

            $data = '<div id="prestamo">
            <div class="content-datos-amorticacion">
                <header class="title"><h1 class="">Tabla de amortización</h1></header>
                <div class="body-datos-amorticacion">
                    <div class="columnas">
                        <div class="sub-title"><p>Cantidad del préstamo</p></div>
                        <div class="sub-title"><p>Cuota mensual</p></div>
                        <div class="sub-title"><p>Interes aplicado</p></div>
                        <div class="sub-title"><p>Interes total pagado</p></div>
                        <div class="sub-title"><p>Cantidad total a pagar</p></div>
                    </div>
                    <div class="columnas">
                        <div class="datos"><p>'. $this -> cantPrestamo .'</p></div>
                        <div class="datos"><p> '. $this -> Decimales($this -> cuota).' </p></div>
                        <div class="datos"><p>7.5%</p></div>
                        <div class="datos"><p>'. $this -> Decimales(round($this -> totalIntereses, 1)) .'</p></div>
                        <div class="datos"><p>'. $this -> Decimales(round($this -> cantPrestamo + $this -> totalIntereses,1)) .'</p></div>
                    </div>
                </div>
            </div>
            <div class="content-tabla-amorticacion">
                <div class="body-table-amorticacion">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-center">#               </th>
                                <th class="text-center">Saldo Inicial   </th>
                                <th class="text-center">Cuota Fija      </th>
                                <th class="text-center">Interes         </th>
                                <th class="text-center">Abono a capital </th>
                                <th class="text-center">Saldo final     </th>
                            </tr>
                        </thead>
                        <tbody id="datos-tabla">
                            '. $this -> getTabla() .'
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <div class="soliciar-prestamo">
                <div class="body-soliciar-prestamo">
                    <div class="columnas">
                        <div class="sub-title"><p>Solicitar préstamo al Cliente No.</p></div>
                    </div>
                    <div class="columnas">
                        <div class="datos">
                            <input type="hidden" name="cant"    id="cant"     value="'. $this -> cantPrestamo .'">
                            <input type="hidden" name="termino" id="termino"  value="'. $this -> plazo        .'">
                            <input type="text" name="NoCuenta" id="NoCuenta" placeholder="--" class="text-center bb-n">
                        </div>
                    </div>
                </div>
            </div>
            <div class="botones">
                <div class="body-botones">
                    <button type="button" class="btn-submit" id="btn-submit">Aplicar</button>
                    <form action="http://bankfie.com/libs/loandPHP/loandController.php" method="POST" target="print_popup" onsubmit="openNewPage()">
                        <input type="hidden" name="cantidad" id="cantidad" value="'. $this -> cantPrestamo .'">
                        <input type="hidden" name="plazo"    id="plazo"    value="'. $this -> plazo        .'">
                        <button type="submit" class="btn-pdf"><i class="fa-solid fa-print"></i></button>
                    </form>
                </div>
            </div>
            
                        
            ';
        
            return $data;;
        }

        function getTabla(){
            $temp = 0;
            $interesPoMes = 0;
            $abonoCapital = 0; 
            $total = $this -> cantPrestamo;

            for ($i=0; $i <= $this-> plazo; $i++) { 

                if ($i === 0){
                    $this -> tableHtml .= '
                                <tr>
                                    <td>'. $i .'</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td> $'. $this -> cantPrestamo .'</td>
                                </tr>';
                } else {

                    $interesPoMes = $total * $this -> interes;
                    $abonoCapital = $this -> cuota - $interesPoMes; 
                    $temp = $abonoCapital - $total;
                    $this -> tableHtml .= '
                            <tr>
                                <td class="celdas"> '  . $i                                 . '</td>
                                <td class="celdas"> $' . $this -> Decimales($total)         . '</td>
                                <td class="celdas"> $' . $this -> Decimales($this -> cuota) . '</td>
                                <td class="celdas"> $' . $this -> Decimales($interesPoMes ) . '</td>
                                <td class="celdas"> $' . $this -> Decimales($abonoCapital)  . '</td>
                                <td class="celdas"> $' . abs($this -> Decimales($temp))     . '</td>
                            </tr>
                    ';
                    
                    $total = abs($temp);
                }
            }

            return strval($this -> tableHtml);
        }

        function intereTotal(){
            $temp = 0;
            $interesPoMes = 0;
            $abonoCapital = 0; 
            $total = $this -> cantPrestamo;

            for ($i=1; $i <= $this-> plazo; $i++) { 


                    $interesPoMes = $total * $this -> interes;
                    $this -> totalIntereses += $interesPoMes;
                    $abonoCapital = $this -> cuota - $interesPoMes; 
                    $temp = $abonoCapital - $total;
                    
                    $total = abs($temp);
                
            }
        }

        function Decimales($value){
            return number_format($value, 2, '.', '');
        }
    }
?>