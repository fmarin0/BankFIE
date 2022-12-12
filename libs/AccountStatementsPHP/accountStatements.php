<?php
    require '../../includes/validaciones.php';
    include_once '../Dompdf/vendor/autoload.php';
    use Dompdf\Dompdf;
    define('URL-IMG-L', '/var/www/BankFIE/public/img/');

    class AccontStatements {
        private $id             ;
        private $NoCuenta       ;
        private $name           ;
        private $fena           ;
        private $curp           ;
        private $domicilio      ;
        private $codPostal      ;
        private $estado         ;
        private $ciudad         ;
        private $email          ;

        private $transferencias ;
        private $retiros        ;
        private $movimientos    ;

        function __construct($NoCuenta){
            $this -> NoCuenta = $NoCuenta;

            $this -> transferencias = 0;
            $this -> retiros        = 0;
        }
        
        function render($nombre, $data = []){
            $this->d = $data;

            require '../../views/' . $nombre . '.php';
        }

        function CreateEstadoDeCuenta(){
            $this -> getUsers();
            $this -> generarPDF();

        }

        function getUsers(){
            try{
                $query = prepararConsulta('SELECT * FROM clientes WHERE NoCuenta = :NoCuenta');
                $query->execute(['NoCuenta' => $this -> NoCuenta]);
                
                if($query->rowCount() == 1){
                    $item = $query -> fetch(PDO::FETCH_ASSOC); 
                    $this  -> from($item);                
                }
            }catch(PDOException $e){
                return NULL;
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

        function queryMovimientos(){
            try {
                $query = prepararConsulta('SELECT * FROM movimientos WHERE NoCuenta = :NoCuenta ORDER BY id DESC');
                $query -> execute(["NoCuenta" => $this -> getNoCuenta()]);
                $movimientos = $query -> fetchAll(PDO::FETCH_OBJ);

                if (count($movimientos) > 0) {  
                    foreach ($movimientos as $movimiento) {
                        if ($movimiento -> accion == 'retiro') { $this -> retiros += $movimiento -> cantidad;} 
                        if ($movimiento -> accion == 'deposito') { $this -> transferencias += $movimiento -> cantidad;}

                        $this -> movimientos .= '<tr>
                                                    <td>'. $movimiento -> fecha .'</td>
                                                    <td class="let"><span>'. $movimiento -> accion .'</span></td>';

                        if ($movimiento -> accion == 'retiro') {
                            $this -> movimientos .= '<td>$'. $this -> decimales($movimiento -> cantidad) .'</td>
                                                     <td>$0.00</td>
                                                     <td>$0.00</td>';
                        }

                        if ($movimiento -> accion == 'deposito') {
                            $this -> movimientos .= '<td>$0.00</td>
                                                     <td>$'. $this -> decimales($movimiento -> cantidad) .'</td>
                                                     <td>$0.00</td>';
                        } 

                        if ($movimiento -> accion == 'prestamo' ||
                            $movimiento -> accion == 'pago'     
                        ) {
                            $this -> movimientos .= '<td>$0.00</td>
                                                     <td>$0.00</td>
                                                     <td>$'. $this -> decimales($movimiento -> cantidad) .'</td>';
                        }

                        $this -> movimientos .= '<td>$'. $this -> decimales($movimiento -> saldo) .'</td></tr>';
                    }
                }

                return false;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        function getData(){
            $this -> queryMovimientos();

            $data = [
                'name'           => $this -> getName(),
                'codPostal'      => $this -> getCodPostal(),
                'domicilio'      => $this -> getDomicilio(),
                'estado'         => $this -> getEstado(),
                'NoCuenta'       => $this -> getNoCuenta(),
                'saldo'          => $this -> decimales($this -> getSaldo()),
                'transferencias' => $this -> decimales($this -> transferencias),
                'retiros'        => $this -> decimales($this -> retiros),
                'movimientos'    => $this -> movimientos
            ];

            return $data;
        }

        function generarPDF(){
            
            $dompdf = new Dompdf();
            ob_start();

            $this -> loadTemplate();
            
            $html = ob_get_clean();
            $dompdf->loadHtml($html);
            $dompdf->render();
            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=Estados De Cuenta - ". $this -> NoCuenta .".pdf");
            echo $dompdf->output(); 
        }

        function loadTemplate(){
            $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents(constant('URL-IMG-L') . "logo.png"));

            $this -> render('templates/estadodecuenta',[
                'data' => $this -> getData(),
                'logo' => $imagenBase64
            ]);
        }

        public function from($array){
            $this -> id         = $array['id'];
            $this -> name       = $array['name'];
            $this -> fena       = $array['fena'];
            $this -> curp       = $array['curp'];
            $this -> domicilio  = $array['domicilio'];
            $this -> codPostal  = $array['codPostal'];
            $this -> estado     = $array['estado'];
            $this -> ciudad     = $array['municipio'];
            $this -> email      = $array['email'];
        }

        function getId       (){ return $this -> id         ;}
        function getNoCuenta (){ return $this -> NoCuenta   ;}
        function getName     (){ return $this -> name       ;}
        function getFena     (){ return $this -> fena       ;}
        function getCurp     (){ return $this -> curp       ;}
        function getDomicilio(){ return $this -> domicilio  ;}
        function getCodPostal(){ return $this -> codPostal  ;}
        function getEstado   (){ return $this -> estado     ;}
        function getCiudad   (){ return $this -> ciudad     ;}
        function getEmail    (){ return $this -> email      ;}

        function decimales($value){return number_format($value, 2, '.', '');}
    }

    session_start();

    $estadoDeCuenta = new AccontStatements($_SESSION['user']);
    
    $estadoDeCuenta -> CreateEstadoDeCuenta();
    

?>