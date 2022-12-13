<?php require_once '../includes/sessionCliente.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet"    href="./../public/css/ejecutivo.css">                     
    <link rel="stylesheet"    href="./../public/css/cliente.css">                     
    <title>Panel de cliente</title>
</head>
<body>
    <?php require '../views/nav.php' ?>
    <section>
        <div class="body-content">
            <div class="content-tittle">
                <h1 class="mb-1 mt-1">¡Hola, <?php echo $user['name']; ?>!</h1>
            </div>
            <div class="content-customers">
                <p id="respuesta"></p>
                <div>
                    <h2 class="text-center mb-1">Prestamos</h2>
                </div>
                <div class="body-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#       </th>
                                <th>Monto  </th>
                                <th class="tmp">Interes </th>
                                <th class="tmp">plazo   </th>
                                <th class="tmp">ver     </th>
                                <th class="tmp">pagar   </th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="modal" class="modal" >
            <div class="modal-content" id="content">
                <div class="head">
                    <div class="title">
                        <h2>Prestamo - <span id="NoPrestamo"></span></h2>
                    </div>
                    <div class="closed">
                        <i class="fa-solid fa-circle-xmark" id="btn-closed"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha de pago</th>
                                <th>Estatus</th>    
                                <th>Monto</th>    
                            </tr>
                        </thead>
                        <tbody id="desglose">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="modal2" class="modal">
            <div class="modal-content" id="content">
                <div class="head">
                    <div class="title">
                        <h2 class="mb-1 text-left">Pago <span id="pago"></span></h2>
                    </div>
                    <div class="closed">
                        <i class="fa-solid fa-circle-xmark" id="btn-closed2"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <p id="respuestas-pagos"></p>
                    <p>Saldo: $<span id="Saldo"></span> MXN</p>
                    <form id="pagarPrestamo">
                        <input type="hidden" name="cantidad" id="Cantidad">
                        <input type="hidden" name="interes" id="interes">
                        <input type="hidden" name="NoPrestamo" id="NoPrestamoD">
                        <div class="content-radios">
                            <input type="radio" name="pago" id="pago1" value="1">
                            <label class="label" for="pago1">Pagar total</label>
                            <input type="radio" name="pago" id="pago2" value="2">
                            <label class="label" for="pago2">Pagar mensualidad</label>
                        </div>
                        <div class="text-right" id="Datos">
                                                        
                        </div>
                        <div class="content-right">
                            <button type="button" id="btn-submit">Pagar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/consulta.js"></script>
</body>
</html>